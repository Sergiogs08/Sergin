<?php /** @var string $active */ ?>
<aside class="sidebar">
  <div class="sidebar__logo">
    <img src="<?= BASE_URL ?>frontend/assets/img/Logo de Gym Sergio con resplandor azul.png" alt="Gym Sergio">
  </div>
  <nav class="sidebar__nav">
    <a href="<?= BASE_URL ?>usuario/dashboard" class="<?= $active==='dashboard' ? 'active' : '' ?>">Inicio</a>
    <a href="<?= BASE_URL ?>usuario/rutinas"    class="<?= $active==='rutinas'   ? 'active' : '' ?>">Rutinas</a>
    <a href="<?= BASE_URL ?>usuario/reservas"   class="<?= $active==='reservas'  ? 'active' : '' ?>">Reservas</a>
    <a id="logout" href="<?= BASE_URL ?>auth/logout">Cerrar sesión</a>
  </nav>
</aside>


