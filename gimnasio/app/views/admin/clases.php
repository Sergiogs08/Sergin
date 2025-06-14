<?php /** @var array $clases */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Clases | Admin</title>
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
      <a href="<?= BASE_URL ?>administrador/clases" class="active">Clases</a>
      <a href="<?= BASE_URL ?>administrador/entrenadores">Entrenadores</a>
      <a href="<?= BASE_URL ?>administrador/membresias">Membresías</a>
      <a href="<?= BASE_URL ?>auth/logout">Cerrar sesión</a>
    </nav>
  </aside>

  <main class="main-content">
    <header class="main-header">
      <h1>Clases</h1>
      <a href="<?= BASE_URL ?>clases/crear" class="btn-primary">Nueva clase</a>
    </header>

    <table class="tabla-datos">
      <thead>
        <tr><th>ID</th><th>Nombre</th><th>Fecha</th><th>Hora</th><th>Acciones</th></tr>
      </thead>
      <tbody>
        <?php if ($clases): ?>
          <?php foreach ($clases as $c): ?>
            <tr>
              <td><?= $c['id'] ?></td>
              <td><?= htmlspecialchars($c['nombre']) ?></td>
              <td><?= date('d/m/Y', strtotime($c['fecha'])) ?></td>
              <td><?= htmlspecialchars($c['hora']) ?></td>
              <td>
                <form action="/administrador/eliminarClase" method="POST" style="display:inline">
                  <input type="hidden" name="id" value="<?= $c['id'] ?>">
                  <button type="submit" class="btn-danger"
                          onclick="return confirm('¿Eliminar clase?')">
                    Eliminar
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr><td colspan="5" class="empty">No hay clases programadas.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </main>
</body>
</html>

