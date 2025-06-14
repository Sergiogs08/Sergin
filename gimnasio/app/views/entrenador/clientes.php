<?php $active='clientes'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Clientes | Entrenador</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/admin.css">
</head>
<body class="admin-page">
  <?php include __DIR__.'/sidebar.php'; ?>

  <main class="main-content">
    <header class="main-header"><h1>Mis clientes</h1></header>

    <table class="tabla-datos">
      <thead><tr><th>ID</th><th>Nombre</th></tr></thead>
      <tbody>
        <?php foreach ($clientes ?? [] as $c): ?>
          <tr>
            <td><?= $c['id'] ?></td>
            <td><?= htmlspecialchars($c['nombre']) ?></td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($clientes)): ?>
          <tr><td colspan="2" class="empty">No tienes clientes asignados.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </main>
</body>
</html>

