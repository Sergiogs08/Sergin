<?php
/* Vista Rutinas agrupadas por día */
$active='rutinas';
$grp=[];
foreach($rutinas??[] as $r){
  $dia=ucfirst($r['dia_semana']);
  $grp[$dia][]=$r;
}
ksort($grp);
?>
<!DOCTYPE html><html lang="es"><head>
  <meta charset="UTF-8">
  <title>Rutinas | Entrenador</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/admin.css">
</head><body class="admin-page">
<?php include __DIR__.'/sidebar.php'; ?>
<main class="main-content">
  <header class="main-header">
    <h1>Rutinas</h1>
    <a href="<?= BASE_URL ?>entrenador/nuevaRutina" class="btn-primary">Nueva rutina</a>
  </header>

  <?php if(!$grp): ?>
    <p class="empty">No tienes rutinas registradas.</p>
  <?php else: ?>
    <div class="rutina-grid">
      <?php foreach($grp as $dia=>$arr): ?>
        <section class="rutina-dia">
          <h2 class="dia-heading"><?= $dia ?></h2>
          <table class="tabla-datos mini">
            <thead>
              <tr><th>Ejercicio</th><th>Series</th><th>Reps</th></tr>
            </thead>
            <tbody>
              <?php foreach($arr as $r): ?>
              <tr>
                <td><?= htmlspecialchars($r['ejercicio']) ?></td>
                <td><?= $r['series'] ?></td>
                <td><?= $r['repeticiones'] ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </section>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</main>
</body></html>

