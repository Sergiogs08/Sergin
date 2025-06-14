<aside class="sidebar">
  <div class="sidebar__logo">
    <img src="<?= BASE_URL ?>frontend/assets/img/Logo de Gym Sergio con resplandor azul.png" alt="Gym Sergio">
  </div>
  <nav class="sidebar__nav">
    <a href="<?= BASE_URL ?>recepcionista/dashboard"
       class="<?= $active==='inicio'   ? 'active':'' ?>">Inicio</a>

    <a href="<?= BASE_URL ?>recepcionista/usuarios"
       class="<?= $active==='usuarios' ? 'active':'' ?>">Usuarios</a>

    <a href="<?= BASE_URL ?>recepcionista/clases"
       class="<?= $active==='clases'   ? 'active':'' ?>">Clases</a>

    <a href="<?= BASE_URL ?>recepcionista/reservas"
       class="<?= $active==='reservas' ? 'active':'' ?>">Reservas</a>

    <a href="<?= BASE_URL ?>recepcionista/tarifas"
       class="<?= $active==='tarifas'  ? 'active':'' ?>">Tarifas</a>

    <a href="<?= BASE_URL ?>auth/logout" class="logout-link">Cerrar sesión</a>
  </nav>
</aside>

