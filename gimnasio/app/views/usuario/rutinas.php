<?php
/** @var array  $currentRoutines */
/** @var string $active */
$active = 'rutinas';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mis Rutinas | Gym Sergio</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/usuario.css">
</head>
<body class="usuario-page admin-page">
  <?php include __DIR__.'/sidebar.php'; ?>

  <main class="main">
    <header class="header">
      <h1>Mis Rutinas</h1>
    </header>

    <?php if (empty($currentRoutines)): ?>
      <p class="empty">No tienes rutinas asignadas.</p>
    <?php else: ?>
      <table class="tabla-datos">
        <thead>
          <tr>
            <th>Día</th><th>Ejercicio</th><th>Series</th><th>Repeticiones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($currentRoutines as $r): ?>
          <tr>
            <td><?= htmlspecialchars($r['nombre_dia'], ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($r['ejercicio'],   ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($r['series'],      ENT_QUOTES) ?></td>
            <td><?= htmlspecialchars($r['repeticiones'],ENT_QUOTES) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </main>
</body>
</html>

