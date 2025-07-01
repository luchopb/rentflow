<?php
require_once 'config.php';
check_login();
$page_title = 'Dashboard - Inmobiliaria';
include 'includes/header_nav.php';

// Obtener el mes y año actual
$mes_actual = date('m');
$anio_actual = date('Y');
$periodo = date('Y-m');
$busqueda = clean_input($_GET['search'] ?? '');

// Obtener conteo de propiedades y contratos activos por tipo
$stmt_propiedades = $pdo->query("
    SELECT p.tipo, 
           COUNT(*) as total,
           SUM(CASE WHEN c.estado = 'activo' THEN 1 ELSE 0 END) as ocupadas
    FROM propiedades p
    LEFT JOIN contratos c ON p.id = c.propiedad_id AND c.estado = 'activo'
    GROUP BY p.tipo
    ORDER BY total DESC
");
$propiedades_por_tipo = $stmt_propiedades->fetchAll(PDO::FETCH_ASSOC);
$total_propiedades = array_sum(array_column($propiedades_por_tipo, 'total'));
$total_ocupadas = array_sum(array_column($propiedades_por_tipo, 'ocupadas'));
$ratio_ocupacion = $total_propiedades > 0 ? round(($total_ocupadas / $total_propiedades) * 100) : 0;

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
    WHERE MONTH(fecha) = ? AND YEAR(fecha) = ? AND concepto = 'Pago mensual'
");
$stmt_pagos->execute([$mes_actual, $anio_actual]);
$pagos_mes_actual = $stmt_pagos->fetchAll(PDO::FETCH_COLUMN, 0);

// Calcular ratio de pagos
$total_contratos = count($propiedades_inquilinos);
$pagos_recibidos = count($pagos_mes_actual);
$pagos_pendientes = $total_contratos - $pagos_recibidos;
$ratio_pagos = $total_contratos > 0 ? round(($pagos_recibidos / $total_contratos) * 100) : 0;

?>

<main class="container container-main">
  <h1>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?></h1>

  <form action="propiedades.php" method="GET" class="mb-4" role="search" aria-label="Buscar propiedades">
    <div class="input-group" style="max-width:480px;">
      <input
        type="search"
        name="search"
        class="form-control"
        placeholder="Buscar por nombre, dirección, local o inquilino"
        value="<?= htmlspecialchars($busqueda) ?>"
        aria-label="Buscar propiedades" autocomplete="off" />
      <button class="btn btn-primary" type="submit" aria-label="Buscar">Buscar</button>
      <?php if ($busqueda): ?>
        <a href="dashboard.php" class="btn btn-outline-secondary" aria-label="Limpiar búsqueda">Limpiar</a>
      <?php endif; ?>
    </div>
  </form>

  <!-- Tarjetas del Dashboard -->
  <div class="row mb-4">
    <div class="col-md-4 h-100">
      <a href="propiedades.php" class="text-decoration-none">
        <div class="card text-bg-primary h-100 mb-3">
          <div class="card-body d-flex flex-column justify-content-between">
            <h5 class="card-title">Propiedades</h5>
            <p class="card-text display-4 mb-0"><?= $total_propiedades ?></p>
            <div class="small mt-2">
              <?php foreach ($propiedades_por_tipo as $tipo): ?>
                <div class="d-flex justify-content-between">
                  <span class="text-capitalize"><?= htmlspecialchars($tipo['tipo']) ?>:</span>
                  <span><?= $tipo['total'] ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-4 h-100">
      <a href="contratos.php" class="text-decoration-none">
        <div class="card text-bg-success h-100 mb-3">
          <div class="card-body d-flex flex-column justify-content-between">
            <h5 class="card-title">Propiedades Ocupadas</h5>
            <p class="card-text display-4"><?= $total_ocupadas ?> de <?= $total_propiedades ?></p>
            <div class="progress mb-2" role="progressbar" aria-label="Progreso de ocupación">
              <div class="progress-bar" style="width: <?= $ratio_ocupacion ?>%"><?= $ratio_ocupacion ?>%</div>
            </div>
            <div class="small mt-2">
              <?php foreach ($propiedades_por_tipo as $tipo): ?>
                <?php 
                  $ratio_tipo = $tipo['total'] > 0 ? round(($tipo['ocupadas'] / $tipo['total']) * 100) : 0;
                ?>
                <div class="d-flex justify-content-between">
                  <span class="text-capitalize"><?= htmlspecialchars($tipo['tipo']) ?>:</span>
                  <span><?= $tipo['ocupadas'] ?>/<?= $tipo['total'] ?> (<?= $ratio_tipo ?>%)</span>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-4 h-100">
      <a href="listado_pagos.php" class="text-decoration-none">
        <div class="card text-bg-info h-100 mb-3">
          <div class="card-body d-flex flex-column justify-content-between">
            <h5 class="card-title">Pagos del Mes</h5>
            <p class="card-text display-4"><?= $pagos_recibidos ?> de <?= $total_contratos ?></p>
            <div class="progress" role="progressbar" aria-label="Progreso de pagos">
              <div class="progress-bar" style="width: <?= $ratio_pagos ?>%"><?= $ratio_pagos ?>%</div>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>

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
        <?php foreach ($propiedades_inquilinos as $fila): ?>
          <tr>
            <td><?= htmlspecialchars($fila['id']) ?></td>
            <td>
              <a href="contratos.php?edit=<?= $fila['id'] ?>" class="text-decoration-none text-dark">
                <b><?= htmlspecialchars($fila['propiedad_nombre']) ?></b></a><br>
              <a href="inquilinos.php?edit=<?= $fila['inquilino_id'] ?>" class="text-decoration-none text-dark">
                <?= htmlspecialchars($fila['inquilino_nombre'] ?? 'N/A') ?>
              </a>
            </td>
            <td>
              <?php if (in_array($fila['id'], $pagos_mes_actual)): ?>
                <a href="pagos.php?contrato_id=<?= $fila['id'] ?>" class="btn btn-success btn-sm">Pago recibido</a>
              <?php else: ?>
                <a href="pagos.php?contrato_id=<?= $fila['id'] ?>&add=true" class="btn btn-outline-success btn-sm">Registrar pago</a>
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