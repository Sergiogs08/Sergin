<?php
// app/views/recepcionista/dashboard.php
$active       = 'inicio';
$users        = $users        ?? [];
$classes      = $classes      ?? [];
$reservas     = $reservas     ?? [];
$memberships  = $memberships  ?? [];

/*  Descripciones por defecto (si la BD trae campo vacìo) */
$defaultDesc = [
  'basico'   => 'Acceso ilimitado a la sala de musculación y cardio.',
  'pro'      => 'Básico + acceso a clases colectivas (spinning, HIIT, yoga).',
  'gymrat'   => 'Pro + consulta mensual con nutricionista y zona sauna.',
  'olympia'  => 'GymRat + rutinas personalizadas, 4 sesiones PT/mes, seguimiento corporal.',
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width,initial-scale=1"/>
  <title>Panel Recepcionista | Gym Sergio</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/recepcionista.css"/>
</head>
<body>

  <?php include __DIR__.'/sidebar.php'; ?>

  <main class="main">
    <header class="header">
      <h1>Panel Recepcionista</h1>
    </header>

    <!-- KPI -->
    <section class="stats">
      <div class="stat-card"><h2>Usuarios</h2>    <p><?= count($users) ?></p></div>
      <div class="stat-card"><h2>Clases</h2>      <p><?= count($classes) ?></p></div>
      <div class="stat-card"><h2>Reservas</h2>    <p><?= count($reservas) ?></p></div>
      <div class="stat-card"><h2>Membresías</h2>  <p><?= count($memberships) ?></p></div>
    </section>

    <!-- Listados rápidos -->
    <section class="tables">
      <div class="table-container">
        <h3>Usuarios</h3>
        <?php if (!$users): ?>
          <p class="empty">No hay usuarios registrados.</p>
        <?php else: ?>
          <table>
            <thead><tr><th>Nombre</th><th>Email</th><th>Rol</th></tr></thead>
            <tbody>
              <?php foreach ($users as $u): ?>
                <tr>
                  <td><?= htmlspecialchars($u['nombre']) ?></td>
                  <td><?= htmlspecialchars($u['email'])  ?></td>
                  <td><?= htmlspecialchars($u['rol'])    ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>

      <div class="table-container">
        <h3>Reservas</h3>
        <?php if (!$reservas): ?>
          <p class="empty">No hay reservas registradas.</p>
        <?php else: ?>
          <table>
            <thead><tr><th>Usuario</th><th>Clase</th><th>Fecha</th></tr></thead>
            <tbody>
              <?php foreach ($reservas as $r): ?>
                <tr>
                  <td><?= htmlspecialchars($r['cliente'] ?? $r['usuario_id']) ?></td>
                  <td><?= htmlspecialchars($r['clase']   ?? $r['clase_id'])   ?></td>
                  <td><?= date('d/m/Y H:i',strtotime($r['fecha_reserva']))   ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
      </div>
    </section>

    <!-- Tarjetas de Tarifas -->
    <?php if ($memberships): ?>
    <section class="tarifas">
      <h2>Tarifas disponibles</h2>

      <div class="tarifa-grid">
        <?php foreach ($memberships as $t): ?>
          <?php
            $nombre = strtolower($t['nombre_plan'] ?? $t['nombre']);
            $desc   = trim($t['descripcion'] ?? '');
            if ($desc === '' && isset($defaultDesc[$nombre])) {
                $desc = $defaultDesc[$nombre];
            }
          ?>
          <article class="tarifa-card">
            <img src="<?= BASE_URL ?>frontend/assets/img/Tarjeta de Miembro Gym Sergio.png"
                 alt="Tarifa <?= htmlspecialchars($t['nombre_plan'] ?? $t['nombre']) ?>">

            <div class="tarifa-info">
              <h3><?= htmlspecialchars($t['nombre_plan'] ?? $t['nombre']) ?></h3>
              <p class="precio">€<?= number_format($t['precio'],2) ?>/mes</p>
              <p class="desc"><?= nl2br(htmlspecialchars($desc)) ?></p>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>

  </main>
</body>
</html>


