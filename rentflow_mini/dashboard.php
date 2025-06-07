<?php
require_once 'config.php';
check_login();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard - Inmobiliaria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: #fff;
            font-family: 'Poppins', sans-serif;
            color: #374151;
        }
        .navbar {
            box-shadow: 0 2px 4px rgb(0 0 0 / 0.05);
        }
        .container-main {
            max-width: 960px;
            margin: 4rem auto 2rem;
            padding: 1rem;
        }
        h1 {
            font-weight: 800;
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #111827;
        }
        .nav-link.active {
            font-weight: 600;
            border-bottom: 2px solid black;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white fixed-top">
  <div class="container">
    <a class="navbar-brand fw-bold fs-4" href="dashboard.php">Inmobiliaria</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">☰</span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto gap-3">
        <li class="nav-item"><a class="nav-link" href="propiedades.php">Propiedades</a></li>
        <li class="nav-item"><a class="nav-link" href="inquilinos.php">Inquilinos</a></li>
        <li class="nav-item"><a class="nav-link" href="contratos.php">Contratos</a></li>
        <li class="nav-item"><a class="nav-link" href="pagos.php">Pagos</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
      </ul>
    </div>
  </div>
</nav>

<main class="container container-main">
  <h1>Bienvenido, <?=htmlspecialchars($_SESSION['user_name'])?></h1>
  <p class="lead">Sistema de gestión inmobiliaria.</p>
  <section class="mt-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <div class="col">
        <div class="card shadow-sm rounded-3 p-3">
          <h5 class="card-title fw-semibold">Propiedades</h5>
          <p class="card-text text-gray-600">Administra las propiedades disponibles y alquiladas.</p>
          <a href="propiedades.php" class="btn btn-outline-dark">Gestionar</a>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm rounded-3 p-3">
          <h5 class="card-title fw-semibold">Inquilinos</h5>
          <p class="card-text text-gray-600">Consulta y registra inquilinos.</p>
          <a href="inquilinos.php" class="btn btn-outline-dark">Gestionar</a>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-sm rounded-3 p-3">
          <h5 class="card-title fw-semibold">Contratos</h5>
          <p class="card-text text-gray-600">Vincula contratos entre propiedades y inquilinos.</p>
          <a href="contratos.php" class="btn btn-outline-dark">Gestionar</a>
        </div>
      </div>
    </div>
  </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
