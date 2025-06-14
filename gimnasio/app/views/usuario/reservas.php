<?php
/** @var array  $reservedClasses */
/** @var string $active */
$active = 'reservas';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mis Reservas | Gym Sergio</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/usuario.css">
</head>
<body class="usuario-page admin-page">
  <?php include __DIR__.'/sidebar.php'; ?>

  <main class="main">
    <header class="header">
      <h1>Mis Reservas</h1>
    </header>

    <?php if (empty($reservedClasses)): ?>
      <p class="empty">No tienes reservas realizadas.</p>
    <?php else: ?>
      <table class="tabla-datos">
        <thead>
          <tr>
            <th>ID</th><th>Clase</th><th>Fecha</th><th>Hora</th><th>Entrenador</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($reservedClasses as $c): ?>
          <tr>
            <td><?= htmlspecialchars($c['reserva_id'] ?? $c['id'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($c['titulo'],          ENT_QUOTES) ?></td>
            <td><?= date('d/m/Y', strtotime($c['fecha'])) ?></td>
            <td><?= date('H:i',    strtotime($c['hora']))  ?></td>
            <td><?= htmlspecialchars($c['entrenador_nombre'] ?? $c['nombre'], ENT_QUOTES) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </main>
</body>
</html>

