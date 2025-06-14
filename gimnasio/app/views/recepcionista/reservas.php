<?php
/* Vista Reservas – Recepcionista */
$active    = 'reservas';            // pestaña activa
$reservas  = $reservas ?? [];       // asegura array
?>
<!DOCTYPE html><html lang="es"><head>
  <meta charset="UTF-8">
  <title>Reservas | Recepcionista</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/recepcionista.css">
</head><body>
<?php include __DIR__.'/sidebar.php'; ?>

<main class="main">
  <h1>Reservas</h1>

  <?php if (!$reservas): ?>
    <p class="empty">No hay reservas registradas.</p>
  <?php else: ?>
    <table class="tabla-datos">
      <thead>
        <tr>
          <th>ID</th>
          <th>Cliente</th>
          <th>Clase</th>
          <th>Fecha&nbsp;clase</th>
          <th>Hora</th>
          <th>Fecha&nbsp;reserva</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reservas as $r): ?>
          <tr>
            <td><?= $r['id'] ?></td>
            <td><?= htmlspecialchars($r['cliente']) ?></td>
            <td><?= htmlspecialchars($r['clase']) ?></td>
            <td><?= date('d/m/Y', strtotime($r['fecha'])) ?></td>
            <td><?= htmlspecialchars($r['hora']) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($r['fecha_reserva'])) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</main>
</body></html>


