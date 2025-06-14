<?php
/**
 * app/views/admin/dashboard.php
 * Panel de control dinámico
 */

$totalUsuarios       = $totalUsuarios       ?? 0;
$clasesProgramadas   = $clasesProgramadas   ?? 0;
$entrenadoresActivos = $entrenadoresActivos ?? 0;
$ingresos            = $ingresos            ?? 0.00;

$usuariosRecientes   = $usuariosRecientes   ?? [];
$clasesProximas      = $clasesProximas      ?? [];
$usuariosPorMes      = $usuariosPorMes      ?? ['labels'=>[],'data'=>[]];
?><!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Panel Admin | Gimnasio XYZ</title>

  <!-- Poppins & Chart.js -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/admin.css">
</head>
<body class="admin-page">
  <aside class="sidebar">
    <div class="logo">
      <img src="<?= BASE_URL ?>frontend/assets/img/Logo de Gym Sergio con resplandor azul.png" alt="Gym Sergio" class="logo-img">
    </div>
    <nav>
      <a href="<?= BASE_URL ?>administrador/dashboard" class="active">Inicio</a>
      <a href="<?= BASE_URL ?>administrador/usuarios">Usuarios</a>
      <a href="<?= BASE_URL ?>administrador/clases">Clases</a>
      <a href="<?= BASE_URL ?>administrador/entrenadores">Entrenadores</a>
      <a href="<?= BASE_URL ?>administrador/membresias">Membresías</a>
      <a href="<?= BASE_URL ?>auth/logout">Cerrar sesión</a>
    </nav>
  </aside>

  <main class="main-content">
    <header class="main-header"><h1>Panel de control</h1></header>

    <!-- KPI CARDS -->
    <section class="cards">
      <div class="card"><h2>Usuarios</h2><p><?= $totalUsuarios ?></p></div>
      <div class="card"><h2>Clases</h2><p><?= $clasesProgramadas ?></p></div>
      <div class="card"><h2>Entrenadores</h2><p><?= $entrenadoresActivos ?></p></div>
      <div class="card"><h2>Ingresos</h2><p>€<?= number_format($ingresos,2,',','.') ?></p></div>
    </section>

    <!-- GRAPH & LISTS -->
    <section class="widgets">
      <div class="widget graph">
        <h2>Usuarios / mes</h2>
        <canvas id="chartUsuarios"></canvas>
      </div>

      <div class="widget lists">
        <div>
          <h2>Usuarios recientes</h2>
          <?php if ($usuariosRecientes): ?>
            <ul>
              <?php foreach($usuariosRecientes as $u): ?>
                <li>
                  <span class="name"><?= htmlspecialchars($u['nombre']) ?></span>
                  <span class="date"><?= date('d/m/Y', strtotime($u['fecha'])) ?></span>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?><p class="empty">Sin registros.</p><?php endif; ?>
        </div>

        <div>
          <h2>Próximas clases</h2>
          <?php if ($clasesProximas): ?>
            <ul>
              <?php foreach($clasesProximas as $c): ?>
                <li>
                  <span class="name"><?= htmlspecialchars($c['nombre']) ?></span>
                  <span class="date">
                    <?= date('d/m', strtotime($c['fecha'])) ?>
                    • <?= htmlspecialchars($c['hora']) ?>
                  </span>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?><p class="empty">Sin clases.</p><?php endif; ?>
        </div>
      </div>
    </section>
  </main>

  <script>
    /*---- Chart.js ----*/
    const datos = <?= json_encode($usuariosPorMes) ?>;
    new Chart(document.getElementById('chartUsuarios'), {
      type: 'line',
      data: {
        labels: datos.labels,
        datasets: [{
          data: datos.data,
          fill: false,
          tension: .3,
          label: 'Altas'
        }]
      },
      options: { plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}} }
    });
  </script>
</body>
</html>

