<?php
$active  = 'clases';             // pestaña activa
$classes = $classes ?? [];       // asegura array
?>
<!DOCTYPE html><html lang="es"><head>
  <meta charset="UTF-8">
  <title>Clases | Recepcionista</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/recepcionista.css">
</head><body>
<?php include __DIR__.'/sidebar.php'; ?>

<main class="main">
  <h1>Clases en curso</h1>

  <?php if (!$classes): ?>
    <p class="empty">No hay clases programadas.</p>
  <?php else: ?>
    <table class="tabla-datos">
      <thead><tr><th>Fecha</th><th>Hora</th><th>Título</th><th>Entrenador</th></tr></thead>
      <tbody>
        <?php foreach ($classes as $c): ?>
          <tr>
            <td><?= date('d/m/Y', strtotime($c['fecha'])) ?></td>
            <td><?= htmlspecialchars($c['hora']) ?></td>
            <td><?= htmlspecialchars($c['nombre']) ?></td>
            <td><?= $c['entrenador_id'] ?: '—' ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</main>
</body></html>

