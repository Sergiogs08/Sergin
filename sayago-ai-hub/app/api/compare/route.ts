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
    const requested = Array.isArray(body?.providers)
      ? body.providers.filter((p:string) => ["gemini","groq","openrouter"].includes(p)).slice(0,3)
      : ["gemini","groq","openrouter"];

    const settled = await Promise.allSettled(
      requested.map((provider:string) => askAI({ prompt, profile, provider: provider as any }))
    );

    return Response.json({
      results: settled.map((r, i) =>
        r.status === "fulfilled"
          ? { ok: true, ...r.value }
          : { ok: false, provider: requested[i], error: String(r.reason?.message || r.reason) }
      )
    });
  } catch (e) {
    return Response.json({ error: e instanceof Error ? e.message : String(e) }, { status: 500 });
  }
}
