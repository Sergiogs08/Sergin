<?php
$active = 'usuarios';
$users  = $users ?? [];               // evita warnings
?>
<!DOCTYPE html><html lang="es"><head>
  <meta charset="UTF-8">
  <title>Usuarios | Recepcionista</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/recepcionista.css">
</head><body>
<?php include __DIR__.'/sidebar.php'; ?>

<main class="main">
  <h1>Usuarios</h1>
  <a href="<?= BASE_URL ?>recepcionista/nuevoUsuario" class="btn-primary">Nuevo usuario</a>

  <?php if (!$users): ?>
    <p class="empty">No hay usuarios registrados.</p>
  <?php else: ?>
    <table class="tabla-datos">
      <thead>
        <tr><th>ID</th><th>Nombre</th><th>Email</th><th>Tarifa</th></tr>
      </thead>
      <tbody>
        <?php foreach ($users as $u): ?>
          <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['nombre']) ?></td>
            <td><?= htmlspecialchars($u['email'])  ?></td>
            <td><?= htmlspecialchars($u['tarifa'] ?? '—') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</main>
</body></html>

