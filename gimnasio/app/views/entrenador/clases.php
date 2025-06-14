<?php $active='clases'; ?>
<!DOCTYPE html><html lang="es"><head>
  <meta charset="UTF-8"><title>Clases a impartir</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/admin.css">
</head><body class="admin-page">
<?php include __DIR__.'/sidebar.php'; ?>
<main class="main-content">
  <header class="main-header"><h1>Clases a impartir</h1></header>

  <table class="tabla-datos">
    <thead>
      <tr><th>Fecha</th><th>Hora</th><th>Título</th></tr>
    </thead>
    <tbody>
      <?php foreach ($clases ?? [] as $c): ?>
        <tr>
          <td><?= date('d/m/Y', strtotime($c['fecha'])) ?></td>
          <td><?= htmlspecialchars($c['hora']) ?></td>
          <td><?= htmlspecialchars($c['nombre']) ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (empty($clases)): ?>
        <tr><td colspan="3" class="empty">No tienes clases programadas.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</main>
</body></html>

