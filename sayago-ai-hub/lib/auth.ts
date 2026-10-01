export function isAuthorized(request: Request): boolean {
  const expected = process.env.HUB_TOKEN?.trim();

  // Never expose provider keys behind an unauthenticated production deployment.
  if (!expected) return process.env.NODE_ENV !== "production";

  const direct = request.headers.get("x-hub-token")?.trim();
  const bearer = request.headers
    .get("authorization")
    ?.replace(/^Bearer\s+/i, "")
    .trim();

  return direct === expected || bearer === expected;
}

export function unauthorized(): Response {
  return Response.json(
    {
      error:
        "No autorizado. Configura HUB_TOKEN en Vercel y usa ese mismo valor para acceder.",
    },
    { status: 401 }
  );
}
