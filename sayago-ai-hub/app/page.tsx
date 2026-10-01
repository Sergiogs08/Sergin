"use client";

import { useEffect, useMemo, useState } from "react";

const profiles = [
  ["general", "General"],
  ["redes_n2", "Redes N2"],
  ["coaching", "Coaching natural"],
  ["contenido", "Contenido Sayago"],
  ["codigo", "Código / automatización"],
  ["investigacion", "Investigación"],
  ["video", "Director de vídeo"],
];

const providers = [
  ["auto", "Auto · failover"],
  ["gemini", "Gemini 3.8 Flash"],
  ["groq", "Groq · GPT-OSS 120B"],
  ["openrouter", "OpenRouter · Free router"],
];

export default function Home() {
  const [token, setToken] = useState("");
  const [profile, setProfile] = useState("general");
  const [provider, setProvider] = useState("auto");
  const [prompt, setPrompt] = useState("");
  const [result, setResult] = useState("");
  const [meta, setMeta] = useState("");
  const [loading, setLoading] = useState(false);
  const [status, setStatus] = useState<Record<string, boolean> | null>(null);

  useEffect(() => {
    setToken(localStorage.getItem("sayago_hub_token") || "");
  }, []);

  const headers = useMemo(
    () => ({
      "content-type": "application/json",
      ...(token ? { "x-hub-token": token } : {}),
    }),
    [token]
  );

  async function checkStatus() {
    try {
      const r = await fetch("/api/status", { headers });
      const data = await r.json();
      if (!r.ok) throw new Error(data.error || "Error");
      setStatus(data.providers);
    } catch (e) {
      setStatus(null);
      setMeta(e instanceof Error ? e.message : String(e));
    }
  }

  async function ask() {
    if (!prompt.trim()) return;
    setLoading(true);
    setResult("");
    setMeta("");
    localStorage.setItem("sayago_hub_token", token);
    try {
      const r = await fetch("/api/ask", {
        method: "POST",
        headers,
        body: JSON.stringify({ prompt, profile, provider }),
      });
      const data = await r.json();
      if (!r.ok) throw new Error(data.error || "Error");
      setResult(data.text);
      setMeta(`${data.provider} · ${data.model}`);
    } catch (e) {
      setMeta(e instanceof Error ? e.message : String(e));
    } finally {
      setLoading(false);
    }
  }

  async function compare() {
    if (!prompt.trim()) return;
    setLoading(true);
    setResult("");
    setMeta("");
    localStorage.setItem("sayago_hub_token", token);
    try {
      const r = await fetch("/api/compare", {
        method: "POST",
        headers,
        body: JSON.stringify({
          prompt,
          profile,
          providers: ["gemini", "groq", "openrouter"],
        }),
      });
      const data = await r.json();
      if (!r.ok) throw new Error(data.error || "Error");
      const text = (data.results || [])
        .map((x: any) =>
          x.ok
            ? `### ${x.provider} · ${x.model}\n\n${x.text}`
            : `### ${x.provider}\n\nERROR: ${x.error}`
        )
        .join("\n\n---\n\n");
      setResult(text);
      setMeta("Comparativa de proveedores");
    } catch (e) {
      setMeta(e instanceof Error ? e.message : String(e));
    } finally {
      setLoading(false);
    }
  }

  return (
    <main>
      <section className="hero">
        <div>
          <p className="eyebrow">SAYAGO · PRIVATE TOOLING</p>
          <h1>AI Hub</h1>
          <p className="lead">
            Respaldo independiente para redes, coaching, contenido, código,
            investigación y vídeo.
          </p>
        </div>
        <button className="ghost" onClick={checkStatus}>Comprobar conexiones</button>
      </section>

      {status && (
        <div className="status">
          {Object.entries(status).map(([name, ok]) => (
            <span key={name} className={ok ? "on" : "off"}>
              {name}: {ok ? "OK" : "pendiente"}
            </span>
          ))}
        </div>
      )}

      <section className="panel">
        <div className="grid">
          <label>
            Perfil
            <select value={profile} onChange={(e) => setProfile(e.target.value)}>
              {profiles.map(([id, label]) => <option key={id} value={id}>{label}</option>)}
            </select>
          </label>
          <label>
            Proveedor
            <select value={provider} onChange={(e) => setProvider(e.target.value)}>
              {providers.map(([id, label]) => <option key={id} value={id}>{label}</option>)}
            </select>
          </label>
        </div>

        <label>
          Token privado del Hub
          <input
            type="password"
            value={token}
            onChange={(e) => setToken(e.target.value)}
            placeholder="HUB_TOKEN"
          />
        </label>

        <label>
          Qué necesitas
          <textarea
            value={prompt}
            onChange={(e) => setPrompt(e.target.value)}
            placeholder="Ej.: revisa este troubleshooting de FortiGate y dime el siguiente paso..."
          />
        </label>

        <div className="actions">
          <button onClick={ask} disabled={loading}>
            {loading ? "Procesando…" : "Preguntar"}
          </button>
          <button className="secondary" onClick={compare} disabled={loading}>
            Comparar 3 IAs
          </button>
        </div>
      </section>

      {(meta || result) && (
        <section className="answer">
          <div className="answerMeta">{meta}</div>
          <pre>{result}</pre>
        </section>
      )}

      <footer>
        Las claves se guardan en Vercel. El token privado se guarda solo en tu navegador.
      </footer>
    </main>
  );
}
