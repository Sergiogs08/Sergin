<?php
// Ruta: /app/views/layouts/main.php
// Layout base para todos los dashboards

// Recibiendo título y contenido inyectado
/** @var string $title */
/** @var string $content */
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($title) ?> | Gym Sergio</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/sidebar.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/dashboard.css">
  <script defer src="<?= BASE_URL ?>frontend/assets/js/dashboard.js"></script>
</head>
<body>
  <?php require __DIR__ . '/sidebar.php'; ?>

  <header class="topbar">
    <img src="<?= BASE_URL ?>frontend/assets/img/logo.png" alt="Gym Sergio Logo" class="topbar-logo">
  </header>

  <main class="main-content">
    <?= $content ?>
  </main>
</body>
</html>

