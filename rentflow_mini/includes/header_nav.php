<?php
// header_nav.php: Centraliza el <head> y navbar para inclusión en páginas
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($page_title ?? 'Inmobiliaria') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    /* Estilos generales siguiendo inspiración minimal y elegante */
    body {
      font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
      background: #ffffff;
      color: #374151;
      padding-top: 5.5rem;
      min-height: 100vh;
      margin: 0;
    }

    nav {
      box-shadow: 0 2px 5px rgb(0 0 0 / 0.05);
      background: #fff;
    }

    .container-main {
      max-width: 1200px;
      /* Puedes ajustar este valor según sea necesario */
      margin: auto;
      padding: 1rem;
    }

    h1 {
      /* Ajustado para ser consistente */
      margin-bottom: 1.5rem;
      color: #111827;
    }

    label {
      font-weight: 600;
    }

    .card {
      border-radius: 0.75rem;
      box-shadow: 0 3px 10px rgb(0 0 0 / 0.07);
      background: #fff;
    }

    a.nav-link {
      transition: color 0.25s ease;
    }

    a.nav-link:hover,
    a.nav-link:focus {
      color: #FFFFFF;
      text-decoration: none;
    }

    a.nav-link.active {
      color: #FFFFFF;
      border-bottom: 2px solid #FFFFFF;
    }

    .btn-remove-image {
      position: absolute;
      top: 2px;
      right: 2px;
      border-radius: 50%;
      padding: 0 6px 2px 6px;
      line-height: 1;
      font-weight: bold;
      font-size: 1rem;
      cursor: pointer;
      border: none;
      background-color: rgba(220, 38, 38, 0.85);
      color: white;
    }

    .img-preview {
      position: relative;
      display: inline-block;
      margin-right: 12px;
      margin-bottom: 10px;
    }
  </style>

</head>

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
      </div>
    </div>
  </nav>
