# IA local opcional con Ollama

Esta capa es opcional. Sirve como último respaldo cuando no quieras depender de ninguna API externa.

## Uso

Instala Ollama en Windows y prueba un modelo que quepa cómodamente en tu VRAM. Ejemplos actuales:

```powershell
ollama run gemma4:e4b
```

Para código también puedes explorar la familia Qwen Coder disponible en Ollama.

Ollama expone por defecto una API local en:

`http://localhost:11434`

## Integración con Sayago AI Hub

No expongas Ollama directamente a Internet. Para usarlo con una copia local del Hub se puede añadir un proveedor `ollama` apuntando a `localhost:11434`.

Para una instalación Vercel pública, usa antes un proxy/túnel privado y autenticado. No configures una URL pública sin protección.

La capa local no sustituye a los modelos cloud para todas las tareas: su calidad y velocidad dependen del modelo y de la VRAM disponible. Su ventaja es coste por petición cero y control local de los datos.
