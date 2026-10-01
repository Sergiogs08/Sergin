import { isAuthorized, unauthorized } from "@/lib/auth";
import { providerStatus } from "@/lib/providers";
import { PROFILES } from "@/lib/profiles";

export async function GET(request: Request) {
  if (!isAuthorized(request)) return unauthorized();
  return Response.json({
    ok: true,
    providers: providerStatus(),
    profiles: Object.fromEntries(Object.entries(PROFILES).map(([id, p]) => [id, p.label]))
  });
}
