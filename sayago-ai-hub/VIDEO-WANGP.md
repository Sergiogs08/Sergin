# Vídeo gratuito: WanGP + MCP

WanGP es la capa de vídeo local del ecosistema. Ejecuta modelos abiertos en tu propia GPU, no cobra una licencia por generación local y expone un servidor MCP.

## Por qué usarlo

- Vídeo local sin créditos por clip.
- Soporta familias como Wan, LTX, Hunyuan Video y otras.
- Tiene optimizaciones para GPU con poca VRAM y soporte RTX 50xx.
- Permite texto-a-vídeo, imagen-a-vídeo, colas, LoRAs, postprocesado y MCP.
- El agente puede descubrir modelos y parámetros antes de generar, en vez de inventar configuraciones.

## Instalación recomendada en Windows

Usa exclusivamente el repositorio oficial de WanGP.

Ruta sencilla:
1. Clona WanGP.
2. Ejecuta su instalador de Windows `scripts\install.bat`.
3. Usa el modo Auto Install adecuado a tu GPU.
4. Arranca primero la interfaz y comprueba una generación sencilla.
5. Después activa MCP.

La instalación manual actual para RTX 40xx/50xx usa Python 3.11 y una build reciente de PyTorch/CUDA; sigue siempre la guía oficial porque estas dependencias cambian.

## MCP local

Desde la carpeta de WanGP:

```powershell
python wgp.py --mcp --mcp-transport streamable-http --mcp-host 127.0.0.1 --mcp-port 7866
```

Endpoint local:

`http://127.0.0.1:7866/mcp`

Mantén `127.0.0.1` si solo lo usas desde el propio PC.

## Acceso desde otro dispositivo o desde la nube

No expongas el puerto directamente a Internet.

Si necesitas que ChatGPT u otro agente remoto llegue al MCP:
1. Pon WanGP detrás de un proxy/túnel HTTPS autenticado.
2. Activa la autenticación MCP de WanGP.
3. Usa un origen público HTTPS.
4. Restringe acceso y no habilites lectura arbitraria del sistema de archivos.

WanGP admite `--mcp-auth` y una contraseña de aprobación separada. Consulta su documentación de autenticación antes de publicar el endpoint.

## Flujo recomendado para Sayago

1. Perfil `video` del Sayago AI Hub crea concepto, storyboard y prompt técnico.
2. WanGP MCP lista modelos compatibles.
3. El agente elige el modelo según texto-a-vídeo o imagen-a-vídeo.
4. Genera el clip localmente.
5. Conserva el resultado en la galería.
6. Si hace falta, Runway/OpenArt quedan como alternativas para tareas que un modelo local no resuelva bien.

## Seguridad

- No uses `--mcp-host 0.0.0.0` fuera de una red de confianza sin autenticación y proxy.
- No actives lectura libre del filesystem salvo que sea imprescindible.
- No publiques claves o contraseñas en GitHub.
