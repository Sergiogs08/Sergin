<?php
/*  app/views/entrenador/sidebar.php
 *  $active debe contener la sección activa: inicio | clientes | rutinas | clases
 */
?>
<aside class="sidebar">
  <div class="logo">
    <img src="<?= BASE_URL ?>frontend/assets/img/Logo de Gym Sergio con resplandor azul.png" alt="Gym Sergio" class="logo-img">
  </div>

  <nav class="nav">
    <a href="<?= BASE_URL ?>entrenador/dashboard"
       class="nav-link <?= $active==='inicio'   ? 'active' : '' ?>">
       🏠 Inicio
    </a>

    <a href="<?= BASE_URL ?>entrenador/clientes"
       class="nav-link <?= $active==='clientes' ? 'active' : '' ?>">
       👥 Clientes
    </a>

    <a href="<?= BASE_URL ?>entrenador/rutinas"
       class="nav-link <?= $active==='rutinas'  ? 'active' : '' ?>">
       📋 Rutinas
    </a>

    <a href="<?= BASE_URL ?>entrenador/clases"
       class="nav-link <?= $active==='clases'   ? 'active' : '' ?>">
       🏋️‍♂️ Clases a impartir
    </a>

    <a href="<?= BASE_URL ?>auth/logout" class="nav-link">
       🔒 Cerrar sesión
    </a>
  </nav>
</aside>

