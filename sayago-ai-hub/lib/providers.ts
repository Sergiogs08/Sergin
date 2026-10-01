import { PROFILES, type ProfileId } from "./profiles";

export type ProviderId = "auto" | "gemini" | "groq" | "openrouter";

export type AskInput = {
  prompt: string;
  profile?: ProfileId;
  provider?: ProviderId;
  maxTokens?: number;
};

export type AskResult = {
  provider: Exclude<ProviderId, "auto">;
  model: string;
  text: string;
};

const timeoutMs = 70_000;

function systemFor(profile: ProfileId = "general") {
  return PROFILES[profile]?.system ?? PROFILES.general.system;
}

async function fetchJson(url: string, init: RequestInit) {
  const controller = new AbortController();
  const timer = setTimeout(() => controller.abort(), timeoutMs);
  try {
    const res = await fetch(url, { ...init, signal: controller.signal });
    const text = await res.text();
    let data: any;
    try { data = JSON.parse(text); } catch { data = { raw: text }; }
    if (!res.ok) {
      throw new Error(`${res.status} ${res.statusText}: ${JSON.stringify(data).slice(0, 1000)}`);
    }
    return data;
  } finally {
    clearTimeout(timer);
  }
}

async function askGemini(input: AskInput): Promise<AskResult> {
  const key = process.env.GEMINI_API_KEY;
  if (!key) throw new Error("GEMINI_API_KEY no configurada");
  const model = process.env.GEMINI_MODEL || "gemini-3.8-flash";
  const data = await fetchJson(
    `https://generativelanguage.googleapis.com/v1beta/models/${encodeURIComponent(model)}:generateContent?key=${encodeURIComponent(key)}`,
    {
      method: "POST",
      headers: { "content-type": "application/json" },
      body: JSON.stringify({
        system_instruction: { parts: [{ text: systemFor(input.profile) }] },
        contents: [{ role: "user", parts: [{ text: input.prompt }] }],
        generationConfig: {
          maxOutputTokens: Math.min(Math.max(input.maxTokens || 4096, 256), 16384),
          temperature: 0.35
        }
      })
    }
  );
  const text = (data.candidates?.[0]?.content?.parts || [])
    .map((p: any) => p.text || "")
    .join("")
    .trim();
  if (!text) throw new Error("Gemini devolvió una respuesta vacía");
  return { provider: "gemini", model, text };
}

async function askOpenAICompatible(
  provider: "groq" | "openrouter",
  input: AskInput
): Promise<AskResult> {
  const isGroq = provider === "groq";
  const key = isGroq ? process.env.GROQ_API_KEY : process.env.OPENROUTER_API_KEY;
  if (!key) throw new Error(`${isGroq ? "GROQ_API_KEY" : "OPENROUTER_API_KEY"} no configurada`);
  const model = isGroq
    ? (process.env.GROQ_MODEL || "openai/gpt-oss-120b")
    : (process.env.OPENROUTER_MODEL || "openrouter/free");
  const base = isGroq
    ? "https://api.groq.com/openai/v1/chat/completions"
    : "https://openrouter.ai/api/v1/chat/completions";

  const headers: Record<string,string> = {
    "content-type": "application/json",
    authorization: `Bearer ${key}`
  };
  if (!isGroq && process.env.PUBLIC_APP_URL) {
    headers["HTTP-Referer"] = process.env.PUBLIC_APP_URL;
    headers["X-Title"] = "Sayago AI Hub";
  }

  const data = await fetchJson(base, {
    method: "POST",
    headers,
    body: JSON.stringify({
      model,
      messages: [
        { role: "system", content: systemFor(input.profile) },
        { role: "user", content: input.prompt }
      ],
      temperature: 0.35,
      max_tokens: Math.min(Math.max(input.maxTokens || 4096, 256), 16384)
    })
  });

  const content = data.choices?.[0]?.message?.content;
  const text = typeof content === "string"
    ? content.trim()
    : Array.isArray(content)
      ? content.map((x:any) => x?.text || "").join("").trim()
      : "";
  if (!text) throw new Error(`${provider} devolvió una respuesta vacía`);
  return { provider, model, text };
}

export function providerStatus() {
  return {
    gemini: Boolean(process.env.GEMINI_API_KEY),
    groq: Boolean(process.env.GROQ_API_KEY),
    openrouter: Boolean(process.env.OPENROUTER_API_KEY),
    videoBackend: Boolean(process.env.VIDEO_BACKEND_URL),
  };
}

export async function askAI(input: AskInput): Promise<AskResult> {
  const requested = input.provider || "auto";
  if (requested === "gemini") return askGemini(input);
  if (requested === "groq") return askOpenAICompatible("groq", input);
  if (requested === "openrouter") return askOpenAICompatible("openrouter", input);

  const profile = input.profile || "general";
  // Quality first for research/coaching; speed first for technical/code; OpenRouter is final free fallback.
  const order: Array<Exclude<ProviderId,"auto">> =
    profile === "redes_n2" || profile === "codigo"
      ? ["groq", "gemini", "openrouter"]
      : ["gemini", "groq", "openrouter"];

  const errors: string[] = [];
  for (const p of order) {
    try {
      if (p === "gemini") return await askGemini(input);
      return await askOpenAICompatible(p, input);
    } catch (e) {
      errors.push(`${p}: ${e instanceof Error ? e.message : String(e)}`);
    }
  }
  throw new Error("Ningún proveedor disponible. " + errors.join(" | "));
}
