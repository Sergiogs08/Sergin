# Sayago AI Hub

Hub privado y ligero para seguir trabajando aunque no haya usos de ChatGPT Work disponibles.

## Qué incluye

- Web privada con perfiles especializados:
  - General
  - Redes N2
  - Coaching natural
  - Contenido Sayago
  - Código / automatización
  - Investigación
  - Dirección de vídeo
- Proveedores gratuitos o con free tier:
  - Google Gemini 3.8 Flash
  - Groq + GPT-OSS 120B
  - OpenRouter Free Models Router
- Failover automático: si el proveedor preferente falla o no está configurado, prueba el siguiente.
- Comparador de hasta 3 IAs.
- MCP remoto en `/api/mcp` con:
  - `sayago_ask`
  - `sayago_compare`
  - `sayago_status`
- Ninguna clave queda en el repositorio.

## Despliegue en Vercel

1. Importa el repositorio `Sergiogs08/Sergin` en Vercel.
2. Configura **Root Directory** como:
   `sayago-ai-hub`
3. Añade las variables de entorno de `.env.example`.
4. `HUB_TOKEN` es obligatorio en producción. Usa un valor largo y aleatorio.
5. Despliega.
6. Abre la web, pega tu `HUB_TOKEN` una vez y pulsa **Comprobar conexiones**.

No reutilices tokens o contraseñas de otros servicios como `HUB_TOKEN`.

## Claves de proveedores

### Gemini
Crea una clave de Gemini Developer API / Google AI Studio y guárdala únicamente como `GEMINI_API_KEY` en Vercel.

### Groq
Crea una clave de GroqCloud y guárdala como `GROQ_API_KEY`.

### OpenRouter
Crea una clave de OpenRouter y guárdala como `OPENROUTER_API_KEY`.
El modelo por defecto es `openrouter/free`, que usa únicamente modelos gratuitos compatibles.

## Política de selección automática

- `redes_n2` y `codigo`: Groq → Gemini → OpenRouter.
- Resto de perfiles: Gemini → Groq → OpenRouter.

Se puede forzar un proveedor desde la interfaz o desde MCP.

## MCP

Endpoint:

`https://TU-DOMINIO/api/mcp`

Autenticación:

`Authorization: Bearer TU_HUB_TOKEN`

Ejemplo conceptual de configuración para un cliente MCP con Streamable HTTP:

```json
{
  "mcpServers": {
    "sayago-ai-hub": {
      "url": "https://TU-DOMINIO/api/mcp",
      "headers": {
        "Authorization": "Bearer TU_HUB_TOKEN"
      }
    }
  }
}
```

## Privacidad

Los proveedores gratuitos pueden tener políticas de uso de datos distintas a los planes empresariales o de pago. No envíes documentación identificable de clientes, credenciales, secretos, historiales médicos ni otros datos sensibles sin anonimizar.

## Vídeo gratuito local

Consulta `VIDEO-WANGP.md`. WanGP puede ejecutarse en tu GPU y expone su propio MCP, por lo que no consume créditos de vídeo por generación.

## Desarrollo local

```bash
npm install
npm run dev
```

Copia `.env.example` a `.env.local` y rellena solo las claves que quieras usar.

## Estado

El código está preparado para Vercel. El despliegue y las claves externas requieren acceso a tu cuenta de Vercel/proveedores; no se almacenan en GitHub.
