import { createMcpHandler } from "mcp-handler";
import { z } from "zod";
import { askAI, providerStatus } from "@/lib/providers";
import { PROFILES } from "@/lib/profiles";
import { isAuthorized, unauthorized } from "@/lib/auth";

export const runtime = "nodejs";

const profileEnum = z.enum([
  "general",
  "redes_n2",
  "coaching",
  "contenido",
  "codigo",
  "investigacion",
  "video",
]);

const providerEnum = z.enum(["auto", "gemini", "groq", "openrouter"]);

const rawHandler = createMcpHandler((server) => {
  server.registerTool(
    "sayago_ask",
    {
      title: "Sayago Ask",
      description:
        "Consulta una IA de respaldo especializada. Auto usa Gemini/Groq/OpenRouter con failover.",
      inputSchema: z.object({
        prompt: z.string().min(1),
        profile: profileEnum.default("general"),
        provider: providerEnum.default("auto"),
        maxTokens: z.number().int().min(256).max(16384).optional(),
      }),
    },
    async ({ prompt, profile, provider, maxTokens }) => {
      try {
        const result = await askAI({ prompt, profile, provider, maxTokens });
        return {
          content: [
            {
              type: "text",
              text: JSON.stringify(result, null, 2),
            },
          ],
        };
      } catch (e) {
        return {
          isError: true,
          content: [
            {
              type: "text",
              text: e instanceof Error ? e.message : String(e),
            },
          ],
        };
      }
    }
  );

  server.registerTool(
    "sayago_compare",
    {
      title: "Compare AI",
      description:
        "Pregunta lo mismo a varios proveedores para contrastar respuestas.",
      inputSchema: z.object({
        prompt: z.string().min(1),
        profile: profileEnum.default("general"),
        providers: z
          .array(z.enum(["gemini", "groq", "openrouter"]))
          .min(2)
          .max(3)
          .default(["gemini", "groq", "openrouter"]),
      }),
    },
    async ({ prompt, profile, providers }) => {
      const settled = await Promise.allSettled(
        providers.map((provider) => askAI({ prompt, profile, provider }))
      );
      const results = settled.map((r, i) =>
        r.status === "fulfilled"
          ? { ok: true, ...r.value }
          : {
              ok: false,
              provider: providers[i],
              error: r.reason instanceof Error ? r.reason.message : String(r.reason),
            }
      );
      return {
        content: [{ type: "text", text: JSON.stringify({ results }, null, 2) }],
      };
    }
  );

  server.registerTool(
    "sayago_status",
    {
      title: "Provider Status",
      description:
        "Comprueba qué proveedores de IA están configurados sin revelar ninguna clave.",
      inputSchema: z.object({}),
    },
    async () => ({
      content: [
        {
          type: "text",
          text: JSON.stringify(
            {
              providers: providerStatus(),
              profiles: Object.fromEntries(
                Object.entries(PROFILES).map(([id, p]) => [id, p.label])
              ),
            },
            null,
            2
          ),
        },
      ],
    })
  );
});

async function secured(request: Request) {
  if (!isAuthorized(request)) return unauthorized();
  return rawHandler(request);
}

export { secured as GET, secured as POST };
