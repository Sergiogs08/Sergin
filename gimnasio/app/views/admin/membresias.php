<?php /** @var array $membresias */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Membresías | Admin</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/admin.css">
</head>
<body class="admin-page">
  <aside class="sidebar">
    <div class="logo">
      <img src="<?= BASE_URL ?>frontend/assets/img/Logo de Gym Sergio con resplandor azul.png" alt="Gym Sergio" class="logo-img">
    </div>
    <nav>
      <a href="<?= BASE_URL ?>administrador/dashboard">Inicio</a>
      <a href="<?= BASE_URL ?>administrador/usuarios">Usuarios</a>
      <a href="<?= BASE_URL ?>administrador/clases">Clases</a>
      <a href="<?= BASE_URL ?>administrador/entrenadores">Entrenadores</a>
      <a href="<?= BASE_URL ?>administrador/membresias" class="active">Membresías</a>
      <a href="<?= BASE_URL ?>auth/logout">Cerrar sesión</a>
    </nav>
  </aside>

  <main class="main-content">
    <header class="main-header"><h1>Membresías</h1></header>

    <table class="tabla-datos">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Precio</th>
          <th>Duración</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($membresias as $m): ?>
          <tr>
            <td><?= $m['id'] ?></td>
            <td><?= htmlspecialchars($m['nombre_plan']) ?></td>
            <td>€<?= number_format($m['precio'], 2) ?></td>
            <td><?= $m['duracion'] ?> días</td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </main>
</body>
</html>

