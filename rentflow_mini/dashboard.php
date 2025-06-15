<?php
require_once 'config.php';
check_login();
$page_title = 'Dashboard - Inmobiliaria';
include 'includes/header_nav.php';

// Obtener el mes y año actual
$mes_actual = date('m');
$anio_actual = date('Y');
$periodo = date('Y-m');
$search = clean_input($_GET['search'] ?? '');

// Get total properties count
$stmt_properties = $pdo->query("SELECT COUNT(*) FROM propiedades");
$total_properties = $stmt_properties->fetchColumn();

// Get total active contracts count
$stmt_contracts = $pdo->query("SELECT COUNT(*) FROM contratos WHERE estado = 'activo'");
$total_active_contracts = $stmt_contracts->fetchColumn();

// Obtener propiedades y sus inquilinos actuales
$stmt = $pdo->prepare("
    SELECT c.id AS id, p.nombre AS propiedad_nombre, i.nombre AS inquilino_nombre, i.id AS inquilino_id, c.fecha_fin 
    FROM propiedades p
    INNER JOIN contratos c ON p.id = c.propiedad_id AND c.estado = 'activo'
    LEFT JOIN inquilinos i ON c.inquilino_id = i.id
    ORDER BY c.id DESC
");
$stmt->execute();
$propiedades_inquilinos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener pagos del mes actual
$stmt_pagos = $pdo->prepare("
    SELECT contrato_id 
    FROM pagos 
    WHERE periodo = ? AND concepto = 'Pago mensual'
");
$stmt_pagos->execute([$periodo]);
$pagos_mes_actual = $stmt_pagos->fetchAll(PDO::FETCH_COLUMN, 0);

// Calculate payments ratio
$total_contratos = count($propiedades_inquilinos);
$pagos_recibidos = count($pagos_mes_actual);
$pagos_pendientes = $total_contratos - $pagos_recibidos;
$payment_ratio = $total_contratos > 0 ? round(($pagos_recibidos / $total_contratos) * 100) : 0;

?>

<main class="container container-main">
  <h1>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?></h1>
  <!-- Dashboard Cards -->
  <div class="row mb-4">
    <div class="col-md-4 h-100">
      <a href="propiedades.php" class="text-decoration-none">
        <div class="card text-bg-primary h-100 mb-3">
          <div class="card-body d-flex flex-column justify-content-between">
            <h5 class="card-title">Propiedades</h5>
            <p class="card-text display-4 mb-0"><?= $total_properties ?></p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-4 h-100">
      <a href="contratos.php" class="text-decoration-none">
        <div class="card text-bg-success h-100 mb-3">
          <div class="card-body d-flex flex-column justify-content-between">
            <h5 class="card-title">Contratos Activos</h5>
            <p class="card-text display-4 mb-0"><?= $total_active_contracts ?></p>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-4 h-100">
      <a href="contratos.php" class="text-decoration-none">
        <div class="card text-bg-info h-100 mb-3">
          <div class="card-body d-flex flex-column justify-content-between">
            <h5 class="card-title">Pagos del Mes</h5>
            <p class="card-text display-4"><?= $pagos_recibidos ?>/<?= $total_contratos ?></p>
            <div class="progress" role="progressbar" aria-label="Payment progress">
              <div class="progress-bar" style="width: <?= $payment_ratio ?>%"><?= $payment_ratio ?>%</div>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>
  <form action="propiedades.php" method="GET" class="mb-4" role="search" aria-label="Buscar propiedades">
    <div class="input-group" style="max-width:480px;">
      <input
        type="search"
        name="search"
        class="form-control"
        placeholder="Buscar por nombre, dirección, local o inquilino"
        value="<?= htmlspecialchars($search) ?>"
        aria-label="Buscar propiedades" autocomplete="off" />
      <button class="btn btn-primary" type="submit" aria-label="Buscar">Buscar</button>
      <?php if ($search): ?>
        <a href="dashboard.php" class="btn btn-outline-secondary" aria-label="Limpiar búsqueda">Limpiar</a>
      <?php endif; ?>
    </div>
  </form>

  <section class="mt-5">
    <h2 class="fw-semibold">Pagos Mensuales</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Contrato</th>
          <th>Pago <?php 
              $fecha = new DateTime("$anio_actual-$mes_actual-01");
              $meses = [
                  1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                  5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                  9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
              ];
              $nombre_mes = $meses[(int)$fecha->format('n')];
              echo ucfirst($nombre_mes) . ' ' . $anio_actual;
          ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($propiedades_inquilinos as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td>
              <a href="contratos.php?edit=<?= $row['id'] ?>" class="text-decoration-none text-dark">
                <b><?= htmlspecialchars($row['propiedad_nombre']) ?></b></a><br>
              <a href="inquilinos.php?edit=<?= $row['inquilino_id'] ?>" class="text-decoration-none text-dark">
                <?= htmlspecialchars($row['inquilino_nombre'] ?? 'N/A') ?>
              </a>
            </td>
            <td>
              <?php if (in_array($row['id'], $pagos_mes_actual)): ?>
                <a href="pagos.php?contrato_id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Pago recibido</a>
              <?php else: ?>
                <a href="pagos.php?contrato_id=<?= $row['id'] ?>&add=true" class="btn btn-outline-success btn-sm">Registrar pago</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>
</main>

<?php
include 'includes/footer.php';
?>