<?php
// app/views/usuario/dashboard.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inicio | Gym Sergio</title>
  <link rel="stylesheet" href="<?= BASE_URL ?>frontend/assets/css/usuario.css">
  <!-- Versión 6: descripciones divertidas a cada imagen -->
  <script defer src="<?= BASE_URL ?>frontend/assets/js/usuario.js?v=6"></script>
</head>
<body class="usuario-page admin-page">
  <?php $active = 'dashboard'; include __DIR__ . '/sidebar.php'; ?>

  <main class="main">
    <header class="header">
      <h1>¡Hola, <?= htmlspecialchars($usuario['nombre'] ?? 'Usuario', ENT_QUOTES) ?>!</h1>
      <p class="subtitulo">Bienvenido de nuevo. ¡A por tus metas! 💪</p>
    </header>

    <section class="stats">
      <div class="stat-card">
        <div class="stat-icon">🏋️</div>
        <h2 class="stat-label">Rutinas Asignadas</h2>
        <p class="stat-count"><?= count($currentRoutines) ?></p>
      </div>
      <div class="stat-card">
        <div class="stat-icon">📅</div>
        <h2 class="stat-label">Reservas Activas</h2>
        <p class="stat-count"><?= count($reservedClasses) ?></p>
      </div>
      <div id="subscribed-plan-card" class="stat-card">
        <div class="stat-icon">💳</div>
        <h2 class="stat-label">Abono Contratado</h2>
        <p id="plan-value" class="stat-count">—</p>
      </div>
    </section>

    <!-- Mosaico con descripciones únicas -->
    <section class="gym-mosaic">
      <h2>Conoce Todas las Partes del Gym</h2>
      <div class="mosaic-grid">
        <?php
          // Mapa de títulos y descripciones para cada imagen
          $friendlyNames = [
            'Área de fitness con luz azul.png'                  => 'Santuario Azul de Cardio',
            'Batido y suplementos en GYM SERGIO.png'            => 'Bar de Recarga Mágica',
            'Cinta de correr en luz neón azul.png'              => 'Autopista Neón de Velocidad',
            'Clase de boxeo con iluminación neón.png'           => 'Ring de Puños Fiesta',
            'Entrenamiento en gimnasio con trainer funcional.png' => 'Zona Élite Funcional',
            'Estación de levantamiento en luces neón.png'       => 'Torre de los Titanes',
            'Estación de press de banca iluminada.png'          => 'Trono del Levantamiento',
            'Estante de pesas en gimnasio moderno.png'         => 'Armería de Fuerza',
            'Estudio de ciclismo iluminado con neón.png'        => 'Carril Turbo Neón',
            'Estudio de fitness futurista y minimalista.png'    => 'Cámara del Futuro Fit',
            'Gimnasio CrossFit con iluminación LED.png'         => 'Arena LED de Gladiadores',
            'Gimnasio de CrossFit iluminado en azul.png'        => 'Campo Azul de Batalla',
            'Gimnasio de levantamiento con luces neón.png'     => 'Cuadrilátero de Hierro',
            'Gimnasio industrial de CrossFit moderno.png'       => 'Factoría de Músculos',
            'Gimnasio moderno con equipo completo (1).png'      => 'Catedral del Fitness',
            'Gimnasio moderno con luces violetas.png'           => 'Templo Violeta del Sudor',
            'Gimnasio moderno en día soleado.png'               => 'Patio Solar de Ambición',
            'Gimnasio oscuro con equipo de fuerza.png'         => 'Bóveda del Poder',
            'gimnasio-nocturno-iluminado-con-neon.png'          => 'Noche Neón de Fuerza',
            'Logo de Gym Sergio con resplandor azul.png'       => 'Emblema de la Gloria',
            'Máquina de dominadas en gimnasio oscuro.png'      => 'Barra de los Valientes',
            'Máquina de extensión de piernas iluminada.png'     => 'Prensa de Gigantes',
            'Máquina de remo iluminada con neón (1).png'       => 'Remo Neón de Resistencia',
            'Prensa de pierna iluminada en neón.png'           => 'Troncal Neon de Piernas',
            'Recepción moderna en GYM SERGIO.png'              => 'Portal de Héroes',
            'Sala de espera en Gym Sergio.png'                 => 'Vestíbulo de Campeones',
            'Sala de vestuarios moderna y minimalista.png'     => 'Camerino de Leyendas',
            'Tarjeta de Miembro Gym Sergio.png'               => 'Pase VIP Legendario',
          ];
          $descriptions = [
            'Área de fitness con luz azul.png'                  => 'Entrena en un mar de energía azul donde las pulsaciones alcanzan el cielo.',
            'Batido y suplementos en GYM SERGIO.png'            => 'Tu pócima diaria para convertir sudor en músculo.',
            'Cinta de correr en luz neón azul.png'              => 'Corre como si persiguieras un cometa de neón.',
            'Clase de boxeo con iluminación neón.png'           => 'Desata tu furia al ritmo de luces eléctricas.',
            'Entrenamiento en gimnasio con trainer funcional.png' => 'Aquí el entrenador mueve más peso que tú (reto aceptado?).',
            'Estación de levantamiento en luces neón.png'       => 'Levantamientos tan épicos que iluminan la sala.',
            'Estación de press de banca iluminada.png'          => 'Donde forjas tu pecho y tu ego, ¡dosis doble!',
            'Estante de pesas en gimnasio moderno.png'         => 'Pesas alineadas como un ejército listo para la acción.',
            'Estudio de ciclismo iluminado con neón.png'        => 'Pedalea hasta que las luces te persigan.',
            'Estudio de fitness futurista y minimalista.png'    => 'Entrena en el set de tu película de acción favorita.',
            'Gimnasio CrossFit con iluminación LED.png'         => 'CrossFit con tanto LED que brillas tanto como tu sudor.',
            'Gimnasio de CrossFit iluminado en azul.png'        => 'Un mar de azul para desafiar tus límites.',
            'Gimnasio de levantamiento con luces neón.png'     => 'Donde los pesistas se convierten en leyendas de neón.',
            'Gimnasio industrial de CrossFit moderno.png'       => 'Factoría del esfuerzo y del sufrimiento glorioso.',
            'Gimnasio moderno con equipo completo (1).png'      => 'Tu arsenal completo para conquistar tus metas.',
            'Gimnasio moderno con luces violetas.png'           => 'Un rincón violeta para encender tu motivación.',
            'Gimnasio moderno en día soleado.png'               => 'Donde hasta el sol decide brillar por ti.',
            'Gimnasio oscuro con equipo de fuerza.png'         => 'La oscuridad no detiene al campeón que llevas dentro.',
            'gimnasio-nocturno-iluminado-con-neon.png'          => 'Entrena cuando la ciudad duerme y el neón arde.',
            'Logo de Gym Sergio con resplandor azul.png'       => 'Nuestro emblema: la promesa de tu próximo logro.',
            'Máquina de dominadas en gimnasio oscuro.png'      => 'Desafía la gravedad y tu pereza con cada agarre.',
            'Máquina de extensión de piernas iluminada.png'     => 'Tus piernas se harán tan fuertes que el suelo temblará.',
            'Máquina de remo iluminada con neón (1).png'       => 'Rema contra la corriente de tus excusas.',
            'Prensa de pierna iluminada en neón.png'           => 'Prensa que convierte tus piernas en columnas de acero.',
            'Recepción moderna en GYM SERGIO.png'              => 'Aquí comienza tu epopeya fitness.',
            'Sala de espera en Gym Sergio.png'                 => 'Donde la anticipación quema más calorías.',
            'Sala de vestuarios moderna y minimalista.png'     => 'Prepárate para lucir tu mejor versión.',
            'Tarjeta de Miembro Gym Sergio.png'               => 'Tu llave maestra hacia un yo imparable.',
          ];
        ?>
        <?php foreach ($galleryImages as $img):
          $title = $friendlyNames[$img] ?? ucwords(str_replace(['-','_','%20'], ' ', pathinfo($img, PATHINFO_FILENAME)));
          $desc  = $descriptions[$img] ?? "Descubre la zona $title y deja tu marca.";
        ?>
        <div class="mosaic-item">
          <img src="<?= BASE_URL ?>frontend/assets/img/<?= rawurlencode($img) ?>"
               alt="<?= htmlspecialchars($title, ENT_QUOTES) ?>">
          <div class="overlay">
            <h3><?= htmlspecialchars($title, ENT_QUOTES) ?></h3>
            <p><?= htmlspecialchars($desc, ENT_QUOTES) ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Reservas -->
    <section class="reservations">
      <h2>Tus Reservas</h2>
      <?php if (empty($reservedClasses)): ?>
        <p class="empty">Aún no tienes reservas.</p>
      <?php else: ?>
        <div class="reservations__grid">
          <?php foreach ($reservedClasses as $c): ?>
          <div class="reservations__item">
            <img src="<?= BASE_URL ?>frontend/assets/img/<?= rawurlencode($galleryImages[0] ?? '') ?>" alt="">
            <div class="reservations__info">
              <strong><?= htmlspecialchars($c['clase_nombre'], ENT_QUOTES) ?></strong>
              <span><?= date('d/m/Y H:i', strtotime($c['fecha_reserva'])) ?></span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </section>

    <!-- Abonos -->
    <section class="subscriptions">
      <h2>Elige tu Abono</h2>
      <div class="subscriptions__grid">
        <?php foreach ($plans as $plan): ?>
        <div class="sub-card">
          <h3><?= htmlspecialchars($plan['nombre_plan'], ENT_QUOTES) ?></h3>
          <p><?= htmlspecialchars($plan['precio'], ENT_QUOTES) ?>€/mes</p>
          <button class="subscribe-btn" data-plan="<?= htmlspecialchars($plan['nombre_plan'], ENT_QUOTES) ?>">
            Contratar
          </button>
        </div>
        <?php endforeach; ?>
      </div>
    </section>
  </main>
</body>
</html>

