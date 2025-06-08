<?php
require_once 'config.php';
check_login();
$page_title = 'Dashboard - Inmobiliaria';
include 'includes/header_nav.php';
?>

<main class="container container-main">
  <h1>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?></h1>
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

<?php
include 'includes/footer.php';
?>