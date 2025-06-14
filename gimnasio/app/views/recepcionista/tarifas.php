<?php
$active      = 'tarifas';
$membresias  = $membresias ?? [];      // evita warnings
?>
<!DOCTYPE html><html lang="es"><head>
  <meta charset="UTF-8">
  <title>Tarifas | Recepcionista</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/recepcionista.css">
</head><body>
<?php include __DIR__.'/sidebar.php'; ?>

<main class="main">
  <h1>Tarifas disponibles</h1>

  <?php if (!$membresias): ?>
    <p class="empty">No hay tarifas configuradas.</p>
  <?php else: ?>
    <table class="tabla-datos">
      <thead>
        <tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Duración</th></tr>
      </thead>
      <tbody>
        <?php foreach ($membresias as $m): ?>
          <tr>
            <td><?= $m['id'] ?></td>
            <td>
              <?= htmlspecialchars($m['nombre_plan'] ?? $m['nombre'] ?? '—') ?>
            </td>
            <td>€<?= number_format($m['precio'], 2) ?></td>
            <td><?= $m['duracion'] ?> días</td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</main>
</body></html>

