export function isAuthorized(request: Request): boolean {
  const expected = process.env.HUB_TOKEN?.trim();

  // Local/dev convenience: if HUB_TOKEN is not configured, no auth is enforced.
  if (!expected) return true;

  const direct = request.headers.get("x-hub-token")?.trim();
  const bearer = request.headers
    .get("authorization")
    ?.replace(/^Bearer\s+/i, "")
    .trim();

  return direct === expected || bearer === expected;
}

export function unauthorized(): Response {
  return Response.json(
    { error: "No autorizado. Revisa HUB_TOKEN." },
    { status: 401 }
  );
}
