<?php /** @var array $usuarios */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Usuarios | Admin</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/admin.css">
</head>
<body class="admin-page">
  <aside class="sidebar">
    <div class="logo">
      <img src="<?= BASE_URL ?>frontend/assets/img/Logo de Gym Sergio con resplandor azul.png" alt="Gym Sergio" class="logo-img">
    </div>
    <nav>
      <a href="<?= BASE_URL ?>administrador/dashboard">Inicio</a>
      <a href="<?= BASE_URL ?>administrador/usuarios" class="active">Usuarios</a>
      <a href="<?= BASE_URL ?>administrador/clases">Clases</a>
      <a href="<?= BASE_URL ?>administrador/entrenadores">Entrenadores</a>
      <a href="<?= BASE_URL ?>administrador/membresias">Membresías</a>
      <a href="<?= BASE_URL ?>auth/logout">Cerrar sesión</a>
    </nav>
  </aside>

  <main class="main-content">
    <header class="main-header">
      <h1>Usuarios</h1>
      <a href="<?= BASE_URL ?>auth/index" class="btn-primary">Nuevo usuario</a>
    </header>

    <table class="tabla-datos">
      <thead>
        <tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Acciones</th></tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $u): ?>
          <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['nombre']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= $u['rol'] ?></td>
            <td>
              <form action="/administrador/eliminarUsuario" method="POST" style="display:inline">
                <input type="hidden" name="id" value="<?= $u['id'] ?>">
                <button type="submit" class="btn-danger"
                        onclick="return confirm('¿Dar de baja al usuario?')">
                  Eliminar
                </button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </main>
</body>
</html>

