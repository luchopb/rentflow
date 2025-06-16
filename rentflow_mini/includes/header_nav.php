<?php
// header_nav.php: Centraliza el <head> y navbar para inclusión en páginas
$search = clean_input($_GET['search'] ?? '');
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($page_title ?? 'Inmobiliaria') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="includes/styles.css" rel="stylesheet" />

  <link rel="apple-touch-icon" sizes="57x57" href="images/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="images/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="images/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="images/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="images/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="images/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="images/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="images/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="images/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="images/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
  <link rel="manifest" href="manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="images/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
</head>

<script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
      navigator.serviceWorker.register('service-worker.js').then(function(registration) {
        console.log('Service Worker registrado con éxito:', registration);
      }).catch(function(error) {
        console.log('Error al registrar el Service Worker:', error);
      });
    });
  }
</script>

<body>
  <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
    <div class="container container-main d-flex justify-content-between align-items-center py-2">
      <a href="dashboard.php" class="navbar-brand fw-bold fs-4">Inmobiliaria</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">

        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link <?= ($_SERVER['SCRIPT_NAME'] ?? '') === '/dashboard.php' ? 'active' : '' ?>" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link <?= ($_SERVER['SCRIPT_NAME'] ?? '') === '/propiedades.php' ? 'active' : '' ?>" href="propiedades.php">Propiedades</a></li>
          <li class="nav-item"><a class="nav-link <?= ($_SERVER['SCRIPT_NAME'] ?? '') === '/inquilinos.php' ? 'active' : '' ?>" href="inquilinos.php">Inquilinos</a></li>
          <li class="nav-item"><a class="nav-link <?= ($_SERVER['SCRIPT_NAME'] ?? '') === '/contratos.php' ? 'active' : '' ?>" href="contratos.php">Contratos</a></li>
          <li class="nav-item"><a class="nav-link <?= ($_SERVER['SCRIPT_NAME'] ?? '') === '/pagos.php' ? 'active' : '' ?>" href="pagos.php">Pagos</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
        </ul>

        <form action="propiedades.php" method="GET" class="" role="search" aria-label="Buscar propiedades">
          <div class="input-group">
            <input
              type="search"
              name="search"
              class="form-control"
              placeholder="Buscar por nombre, dirección, local o inquilino"
              value="<?= htmlspecialchars($search) ?>"
              aria-label="Buscar propiedades" autocomplete="off" />
            <?php if ($search): ?>
              <a href="propiedades.php" class="btn btn-outline-light" aria-label="Limpiar búsqueda">Limpiar</a>
            <?php endif; ?>
            <button class="btn btn-outline-light" type="submit" aria-label="Buscar">Buscar</button>
          </div>
        </form>

      </div>
    </div>
  </nav>