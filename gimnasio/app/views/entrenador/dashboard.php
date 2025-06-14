<?php
/**
 * app/views/entrenador/dashboard.php
 * Sección “Inicio” del panel de entrenador
 *
 * Variables esperadas:
 *   $trainer  – array con al menos ['nombre']
 *   $clientes – array (puede estar vacío)
 *   $progresoCliente – int 0-100
 */
$active = 'inicio';          // ← marca la pestaña activa
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Panel Entrenador · Gym Sergio</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  <?php
    $css = '/frontend/assets/css/trainer.css';
    $ver = is_file($_SERVER['DOCUMENT_ROOT'].$css) ? filemtime($_SERVER['DOCUMENT_ROOT'].$css) : time();
  ?>
  <link rel="stylesheet" href="<?= $css ?>?v=<?= $ver ?>">
</head>
<body class="admin-page">

<?php include __DIR__.'/sidebar.php'; ?>

<main class="main-content">
  <header class="header">
    <h1>Bienvenido, <?= htmlspecialchars($trainer['nombre'] ?? 'Coach', ENT_QUOTES, 'UTF-8') ?></h1>
    <p class="subtitle">Entrenador personal</p>
  </header>

  <section class="grid">
    <!-- Clientes asignados -->
    <div class="card">
      <h2>Clientes asignados</h2>
      <?php if (empty($clientes)): ?>
        <p class="empty">No tienes clientes asignados.</p>
      <?php else: ?>
        <ul>
          <?php foreach ($clientes as $c): ?>
            <li><?= htmlspecialchars($c['nombre'], ENT_QUOTES, 'UTF-8') ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </div>

    <!-- Crear rutina -->
    <div class="card center">
      <a href="<?= BASE_URL ?>entrenador/rutinas/nueva" class="btn-primary">Crear Rutina</a>
    </div>

    <!-- Progreso cliente -->
    <div class="card progress-card">
      <h2>Progreso Cliente</h2>
      <?php $pct = (int) ($progresoCliente ?? 0); ?>
      <div class="progress-circle" data-percent="<?= $pct ?>">
        <span class="percent"><?= $pct ?>%</span>
      </div>
    </div>

    <!-- Calendario -->
    <div class="card calendar-card">
      <h2>Calendario</h2>
      <div id="calendar"></div>
    </div>
  </section>
</main>

<script src="<?= BASE_URL ?>frontend/assets/js/trainer.js"></script>
</body>
</html>

