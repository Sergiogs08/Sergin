import { isAuthorized, unauthorized } from "@/lib/auth";
import { askAI } from "@/lib/providers";
import { PROFILES } from "@/lib/profiles";

export const runtime = "nodejs";

export async function POST(request: Request) {
  if (!isAuthorized(request)) return unauthorized();
  try {
    const body = await request.json();
    const prompt = String(body?.prompt || "").trim();
    if (!prompt) return Response.json({ error: "Falta prompt" }, { status: 400 });
    const profile = body?.profile && body.profile in PROFILES ? body.profile : "general";
    const provider = ["auto","gemini","groq","openrouter"].includes(body?.provider)
      ? body.provider : "auto";
    const result = await askAI({ prompt, profile, provider, maxTokens: body?.maxTokens });
    return Response.json(result);
  } catch (e) {
    return Response.json(
      { error: e instanceof Error ? e.message : String(e) },
      { status: 500 }
    );
  }
}
