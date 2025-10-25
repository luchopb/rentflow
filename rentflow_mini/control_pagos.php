<?php
require_once 'config.php';
check_login();
$page_title = 'Control de Pagos - Inmobiliaria';
include 'includes/header_nav.php';

// Obtener filtros de fecha
$fecha_desde = $_GET['fecha_desde'] ?? date('Y-m-01'); // Primer día del mes actual por defecto
$fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-t'); // Último día del mes actual por defecto
$busqueda = clean_input($_GET['search'] ?? '');

// Validar fechas
$fecha_desde = DateTime::createFromFormat('Y-m-d', $fecha_desde) ? $fecha_desde : date('Y-m-01');
$fecha_hasta = DateTime::createFromFormat('Y-m-d', $fecha_hasta) ? $fecha_hasta : date('Y-m-t');

// Obtener mes y año para compatibilidad con código existente
$mes_actual = date('m', strtotime($fecha_desde));
$anio_actual = date('Y', strtotime($fecha_desde));
$periodo = date('Y-m', strtotime($fecha_desde));

// Obtener propiedades y sus inquilinos actuales junto a último pago mensual
$stmt = $pdo->prepare("
    SELECT c.id AS id, p.nombre AS propiedad_nombre, i.nombre AS inquilino_nombre, i.id AS inquilino_id, c.fecha_fin,
           (
               SELECT pa.fecha FROM pagos pa 
               WHERE pa.contrato_id = c.id AND pa.concepto = 'Pago mensual'
               ORDER BY pa.periodo DESC, pa.fecha DESC LIMIT 1
           ) AS fecha_ultimo_pago,
           (
               SELECT pa.periodo FROM pagos pa 
               WHERE pa.contrato_id = c.id AND pa.concepto = 'Pago mensual'
               ORDER BY pa.periodo DESC, pa.fecha DESC LIMIT 1
           ) AS periodo_ultimo_pago
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

?>

<main class="container container-main">
  <h1>Control de Pagos</h1>

  <!-- Filtros de fecha y búsqueda -->
  <div class="row mb-4">
    <div class="col-md-8">
      <form action="control_pagos.php" method="GET" class="row g-3">
        <div class="col-md-3">
          <label for="fecha_desde" class="form-label">Desde:</label>
          <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" 
                 value="<?= htmlspecialchars($fecha_desde) ?>" required>
        </div>
        <div class="col-md-3">
          <label for="fecha_hasta" class="form-label">Hasta:</label>
          <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" 
                 value="<?= htmlspecialchars($fecha_hasta) ?>" required>
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

  <section>
    <h2 class="fw-semibold">Pagos Mensuales</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Contrato</th>
          <th>Pago <?= ucfirst($nombre_mes) . ' ' . $anio_actual ?> (<?= date('d/m', strtotime($fecha_desde)) ?> - <?= date('d/m', strtotime($fecha_hasta)) ?>)</th>
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
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>
</main>

<?php
include 'includes/footer.php';
?>
