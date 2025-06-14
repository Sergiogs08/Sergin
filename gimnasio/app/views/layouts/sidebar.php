<?php
// Ruta: /app/views/layouts/sidebar.php
$uri = $_SERVER['REQUEST_URI'];
?>
<aside class="sidebar">
  <div class="sidebar-logo">
    <img src="<?= BASE_URL ?>frontend/assets/img/logo.png" alt="Gym Sergio Logo">
  </div>
  <nav>
    <ul>
      <li class="<?= strpos($uri, '/usuario/dashboard') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>usuario/dashboard">Inicio</a>
      </li>
      <?php if (strpos($uri, '/usuario') === 1): ?>
      <li class="<?= strpos($uri, '/usuario/rutinas') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>usuario/rutinas">Rutinas</a>
      </li>
      <li class="<?= strpos($uri, '/usuario/reservas') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>usuario/reservas">Reservas</a>
      </li>
      <?php endif; ?>

      <?php if (strpos($uri, '/entrenador') === 1): ?>
      <li class="<?= strpos($uri, '/entrenador/dashboard') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>entrenador/dashboard">Inicio</a>
      </li>
      <li class="<?= strpos($uri, '/entrenador/clientes') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>entrenador/clientes">Clientes</a>
      </li>
      <li class="<?= strpos($uri, '/entrenador/rutinas') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>entrenador/rutinas">Rutinas</a>
      </li>
      <li class="<?= strpos($uri, '/entrenador/calendario') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>entrenador/calendario">Calendario</a>
      </li>
      <?php endif; ?>

      <?php if (strpos($uri, '/administrador') === 1): ?>
      <li class="<?= strpos($uri, '/administrador/dashboard') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>administrador/dashboard">Inicio</a>
      </li>
      <li class="<?= strpos($uri, '/administrador/usuarios') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>administrador/usuarios">Usuarios</a>
      </li>
      <li class="<?= strpos($uri, '/administrador/clases') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>administrador/clases">Clases</a>
      </li>
      <li class="<?= strpos($uri, '/administrador/entrenadores') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>administrador/entrenadores">Entrenadores</a>
      </li>
      <li class="<?= strpos($uri, '/administrador/membresias') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>administrador/membresias">Membresías</a>
      </li>
      <?php endif; ?>

      <?php if (strpos($uri, '/recepcionista') === 1): ?>
      <li class="<?= strpos($uri, '/recepcionista/dashboard') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>recepcionista/dashboard">Inicio</a>
      </li>
      <li class="<?= strpos($uri, '/recepcionista/usuarios') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>recepcionista/usuarios">Usuarios</a>
      </li>
      <li class="<?= strpos($uri, '/recepcionista/clases') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>recepcionista/clases">Clases</a>
      </li>
      <li class="<?= strpos($uri, '/recepcionista/reservas') === 0 ? 'active' : '' ?>">
        <a href="<?= BASE_URL ?>recepcionista/reservas">Reservas</a>
      </li>
      <?php endif; ?>

      <li><a href="<?= BASE_URL ?>auth/logout">Cerrar sesión</a></li>
    </ul>
  </nav>
</aside>

