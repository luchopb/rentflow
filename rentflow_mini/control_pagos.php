<?php
require_once 'config.php';
check_login();
$page_title = 'Control de Pagos - Inmobiliaria';
include 'includes/header_nav.php';

// Obtener filtros de período
$periodo_seleccionado = $_GET['periodo'] ?? date('Y-m'); // Mes actual por defecto
$busqueda = clean_input($_GET['search'] ?? '');
$filtro_pago = clean_input($_GET['filtro_pago'] ?? '');

// Validar período y calcular fechas
$fecha_desde = $periodo_seleccionado . '-01'; // Primer día del mes
$fecha_hasta = date('Y-m-t', strtotime($fecha_desde)); // Último día del mes

// Obtener mes y año para compatibilidad con código existente
$mes_actual = date('m', strtotime($fecha_desde));
$anio_actual = date('Y', strtotime($fecha_desde));
$periodo = date('Y-m', strtotime($fecha_desde));

// Obtener propiedades y sus inquilinos actuales junto a último pago mensual
$stmt = $pdo->prepare("
    SELECT c.id AS id, p.nombre AS propiedad_nombre, i.nombre AS inquilino_nombre, i.id AS inquilino_id, c.fecha_fin, c.estado AS estado_contrato,
           (
               SELECT pa.fecha FROM pagos pa 
               WHERE pa.contrato_id = c.id AND pa.concepto = 'Pago mensual' AND pa.fecha <= ?
               ORDER BY pa.periodo DESC, pa.fecha DESC LIMIT 1
           ) AS fecha_ultimo_pago,
           (
               SELECT pa.periodo FROM pagos pa 
               WHERE pa.contrato_id = c.id AND pa.concepto = 'Pago mensual' AND pa.fecha <= ?
               ORDER BY pa.periodo DESC, pa.fecha DESC LIMIT 1
           ) AS periodo_ultimo_pago,
           (
               SELECT COUNT(*) FROM pagos pa 
               WHERE pa.contrato_id = c.id AND pa.concepto = 'Pago mensual' AND pa.fecha BETWEEN ? AND ?
           ) AS cantidad_pagos_periodo
    FROM propiedades p
    INNER JOIN contratos c ON p.id = c.propiedad_id AND c.fecha_fin >= CURDATE()
    -- AND c.estado = 'activo'
    LEFT JOIN inquilinos i ON c.inquilino_id = i.id
    ORDER BY c.id DESC
");
$stmt->execute([$fecha_hasta, $fecha_hasta, $fecha_desde, $fecha_hasta]);
$propiedades_inquilinos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener pagos del período seleccionado (solo de contratos activos)
$stmt_pagos = $pdo->prepare("
    SELECT p.contrato_id 
    FROM pagos p
    INNER JOIN contratos c ON p.contrato_id = c.id AND c.fecha_fin >= CURDATE()
    WHERE p.fecha BETWEEN ? AND ? AND p.concepto = 'Pago mensual'
");
$stmt_pagos->execute([$fecha_desde, $fecha_hasta]);
$pagos_mes_actual = $stmt_pagos->fetchAll(PDO::FETCH_COLUMN, 0);

// Definir nombre del mes para mostrar en las tarjetas
$fecha = new DateTime("$anio_actual-$mes_actual-01");
$meses = [
  1 => 'Enero',
  2 => 'Febrero',
  3 => 'Marzo',
  4 => 'Abril',
  5 => 'Mayo',
  6 => 'Junio',
  7 => 'Julio',
  8 => 'Agosto',
  9 => 'Septiembre',
  10 => 'Octubre',
  11 => 'Noviembre',
  12 => 'Diciembre'
];
$nombre_mes = $meses[(int)$fecha->format('n')];

// Obtener pagos del mes actual
$stmt_pagos = $pdo->prepare("
    SELECT contrato_id 
    FROM pagos 
    WHERE MONTH(fecha) = ? AND YEAR(fecha) = ? AND concepto = 'Pago mensual'
");
$stmt_pagos->execute([$mes_actual, $anio_actual]);
$pagos_mes_actual = $stmt_pagos->fetchAll(PDO::FETCH_COLUMN, 0);

// Aplicar filtro de estado de pago
$propiedades_filtradas = $propiedades_inquilinos;

if ($filtro_pago === 'con_pago') {
    $propiedades_filtradas = array_filter($propiedades_inquilinos, function($fila) {
        return $fila['cantidad_pagos_periodo'] > 0;
    });
} elseif ($filtro_pago === 'sin_pago') {
    $propiedades_filtradas = array_filter($propiedades_inquilinos, function($fila) {
        return $fila['cantidad_pagos_periodo'] == 0;
    });
}

// Calcular ratio de pagos basado en contratos con al menos un pago
$total_contratos = count($propiedades_inquilinos);
$pagos_recibidos = 0;
$total_pagos_periodo = 0;

foreach ($propiedades_inquilinos as $fila) {
    if ($fila['cantidad_pagos_periodo'] > 0) {
        $pagos_recibidos++;
    }
    $total_pagos_periodo += $fila['cantidad_pagos_periodo'];
}

$pagos_pendientes = $total_contratos - $pagos_recibidos;
$ratio_pagos = $total_contratos > 0 ? round(($pagos_recibidos / $total_contratos) * 100) : 0;

?>

<main class="container container-main">
  <h1>Control de Pagos</h1>

  <!-- Filtros de período y búsqueda -->
  <div class="row mb-4">
    <div class="col-md-8">
      <form action="control_pagos.php" method="GET" class="row g-3">
        <div class="col-md-3">
          <label for="periodo" class="form-label">Período:</label>
          <select class="form-select" id="periodo" name="periodo" required>
            <?php
            // Generar opciones de los últimos 24 meses
            for ($i = 0; $i < 24; $i++) {
              $fecha_opcion = date('Y-m', strtotime("-$i months"));
              $fecha_display = date('F Y', strtotime($fecha_opcion . '-01'));
              $fecha_display = str_replace([
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
              ], [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
              ], $fecha_display);
              $selected = ($periodo_seleccionado === $fecha_opcion) ? 'selected' : '';
              echo "<option value=\"$fecha_opcion\" $selected>$fecha_display</option>";
            }
            ?>
          </select>
        </div>
        <div class="col-md-3">
          <label for="filtro_pago" class="form-label">Estado de Pago:</label>
          <select class="form-select" id="filtro_pago" name="filtro_pago">
            <option value="">Todos</option>
            <option value="con_pago" <?= $filtro_pago === 'con_pago' ? 'selected' : '' ?>>Con Pago</option>
            <option value="sin_pago" <?= $filtro_pago === 'sin_pago' ? 'selected' : '' ?>>Sin Pago</option>
          </select>
        </div>
        <div class="col-md-4">
          <label for="search" class="form-label">Buscar:</label>
          <input type="search" class="form-control" id="search" name="search" 
                 placeholder="Buscar por nombre, dirección, local o inquilino"
                 value="<?= htmlspecialchars($busqueda) ?>" autocomplete="off">
        </div>
        <div class="col-md-2 d-flex align-items-end">
          <button class="btn btn-primary me-2" type="submit">Filtrar</button>
          <a href="control_pagos.php" class="btn btn-outline-secondary">Limpiar</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Tarjeta de Resumen de Pagos -->
  <div class="row mb-3">
    <div class="col-md-12">
      <a href="listado_pagos.php" class="text-decoration-none">
        <div class="card mb-2">
          <div class="card-body py-2">
            <h6 class="card-title mb-1 text-info">Pagos del Mes</h6>
              <p class="card-text h4 mb-1"><?= $pagos_recibidos ?>/<?= $total_contratos ?> contratos</p>
              <div class="small text-muted">
                Total de pagos: <?= $total_pagos_periodo ?>
              </div>
            <div class="progress" role="progressbar" aria-label="Progreso de pagos" style="height: 6px;">
              <div class="progress-bar" style="width: <?= $ratio_pagos ?>%"></div>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>

  <section>
    <h2 class="fw-semibold">Pagos Mensuales</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Contrato</th>
          <th>Estado</th>
          <th>Pago <?= ucfirst($nombre_mes) . ' ' . $anio_actual ?></th>
        </tr>
      </thead>
      <tbody>
        <?php $contador = 1; foreach ($propiedades_filtradas as $fila): ?>
          <tr>
            <td><?= $contador ?></td>
            <td>
              <a href="contratos.php?edit=<?= $fila['id'] ?>" class="text-decoration-none text-dark">
                <b><?= htmlspecialchars($fila['id']) ?>. <?= htmlspecialchars($fila['propiedad_nombre']) ?></b></a><br>
              <a href="inquilinos.php?edit=<?= $fila['inquilino_id'] ?>" class="text-decoration-none text-dark">
                <?= htmlspecialchars($fila['inquilino_nombre'] ?? 'N/A') ?>
              </a>
            </td>
            <td>
              <?= estado_contrato_label($fila['estado_contrato']) ?>
            </td>
            <td>
              <?php if ($fila['cantidad_pagos_periodo'] > 0): ?>
                <a href="pagos.php?contrato_id=<?= $fila['id'] ?>" class="btn btn-success btn-sm">
                  Pago recibido (<?= $fila['cantidad_pagos_periodo'] ?>)
                </a>
              <?php else: ?>
                <a href="pagos.php?contrato_id=<?= $fila['id'] ?>&add=true" class="btn btn-outline-success btn-sm">Registrar pago</a>
              <?php endif; ?>
              <?php if ($fila['fecha_ultimo_pago'] && $fila['periodo_ultimo_pago']): ?>
                <div class="small text-muted mt-1">
                  <b><?= date('Y-m-d', strtotime($fila['fecha_ultimo_pago'])) ?></b> Último pago<br>
                  <b><?= htmlspecialchars($fila['periodo_ultimo_pago']) ?></b> Período
                </div>
              <?php else: ?>
                <div class="small text-muted mt-1">Sin pagos registrados</div>
              <?php endif; ?>
            </td>
          </tr>
        <?php $contador++; endforeach; ?>
      </tbody>
    </table>
  </section>
</main>

<?php
include 'includes/footer.php';
?>
