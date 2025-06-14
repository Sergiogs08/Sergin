<?php
// app/views/auth/login.php
?><!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Login | Gym Sergio</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/login.css"/>
  <script defer src="<?= BASE_URL ?>frontend/assets/js/login.js"></script>
</head>
<body>
  <header class="main-header">
    <div class="brand">GYM SERGIO</div>
  </header>

  <div class="login-wrapper">
    <div class="login-card">
      <!-- Usa BASE_URL para esta imagen -->
      <div class="image-container">
        <img
          src="<?= BASE_URL ?>frontend/assets/img/Gimnasio moderno en día soleado.png"
          alt="Gym Sergio"
        />
      </div>

      <h2>INICIAR SESIÓN</h2>

      <?php if (!empty($error)): ?>
        <div class="error-text"><?= $error ?></div>
      <?php endif; ?>

      <form action="<?= BASE_URL ?>auth/login" method="post">
        <div class="input-group">
          <span class="icon">
            <!-- SVG mail -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <rect x="2" y="4" width="20" height="16" rx="2" stroke-width="2"/>
              <path d="M2 4l10 8 10-8" stroke-width="2"/>
            </svg>
          </span>
          <input
            type="email"
            name="email"
            placeholder="Email"
            required
            value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
          />
        </div>

        <div class="input-group password-group">
          <span class="icon">
            <!-- SVG lock -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <rect x="5" y="11" width="14" height="10" rx="2" stroke-width="2"/>
              <path d="M9 11V7a3 3 0 016 0v4" stroke-width="2"/>
            </svg>
          </span>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Contraseña"
            required
          />
          <button type="button" id="togglePassword" aria-label="Mostrar u ocultar contraseña">
            <!-- SVG eye -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z" stroke-width="2"/>
              <circle cx="12" cy="12" r="3" fill="currentColor"/>
            </svg>
          </button>
        </div>

        <button type="submit" class="btn-submit">Ingresar</button>
      </form>
    </div>
  </div>
</body>
</html>

