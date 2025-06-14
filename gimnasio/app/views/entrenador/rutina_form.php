<?php $active='rutinas'; ?>
<!DOCTYPE html><html lang="es"><head>
  <meta charset="UTF-8">
  <title>Nueva rutina</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/admin.css">
</head><body class="admin-page">
<?php include __DIR__.'/sidebar.php'; ?>
<main class="main-content">
  <header class="main-header"><h1>Nueva rutina</h1></header>

  <!-- action apunta a nuevaRutina (POST) -->
  <form action="<?= BASE_URL ?>entrenador/nuevaRutina" method="POST" class="form-box">
    <label>Ejercicio
      <input type="text" name="ejercicio" required>
    </label>
    <label>Series
      <input type="number" name="series" min="1" required>
    </label>
    <label>Repeticiones
      <input type="number" name="repeticiones" min="1" required>
    </label>
    <label>Nombre del día
      <input type="text" name="nombre_dia" required>
    </label>
	<label>Descripción (opcional)
  <textarea name="descripcion" rows="3"></textarea>
</label>
    <label>Día de la semana
      <select name="dia_semana" required>
        <option value="">-- seleccionar --</option>
        <?php foreach (['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'] as $d): ?>
          <option><?= $d ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <button type="submit" class="btn-primary">Guardar rutina</button>
  </form>
</main>
</body></html>

