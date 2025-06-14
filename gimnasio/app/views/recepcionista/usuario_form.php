<?php
$active       = 'usuarios';
$membresias   = $membresias ?? [];   // evita warnings si llegara vacío
?>
<!DOCTYPE html><html lang="es"><head>
  <meta charset="UTF-8">
  <title>Nuevo usuario</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/recepcionista.css">
</head><body>
<?php include __DIR__.'/sidebar.php'; ?>

<main class="main">
  <h1>Alta de usuario</h1>

  <form action="<?= BASE_URL ?>recepcionista/nuevoUsuario" method="POST" class="form-box">
    <label>Nombre
      <input type="text" name="nombre" required>
    </label>

    <label>Email
      <input type="email" name="email" required>
    </label>

    <label>Tarifa
      <select name="membresia_id" required>
        <option value="">-- Selecciona tarifa --</option>
        <?php foreach ($membresias as $m): ?>
          <option value="<?= $m['id'] ?>">
            <?= htmlspecialchars($m['nombre_plan'] ?? $m['nombre'] ?? 'Tarifa') ?>
            &nbsp;(€<?= number_format($m['precio'],2) ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </label>

    <button type="submit" class="btn-primary">Guardar</button>
  </form>
</main>
</body></html>

