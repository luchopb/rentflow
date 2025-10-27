<?php
require_once 'config.php';
check_login();
$page_title = 'Dashboard - Inmobiliaria';
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

// Calcular ratio de pagos
$total_contratos = count($propiedades_inquilinos);
$pagos_recibidos = count($pagos_mes_actual);
$pagos_pendientes = $total_contratos - $pagos_recibidos;
$ratio_pagos = $total_contratos > 0 ? round(($pagos_recibidos / $total_contratos) * 100) : 0;

// Obtener contratos por vencer en los próximos 60 días
$stmt_vencer = $pdo->prepare("
    SELECT c.id, p.nombre AS propiedad_nombre, p.id AS propiedad_id, i.nombre AS inquilino_nombre, c.fecha_fin,
           DATEDIFF(c.fecha_fin, CURDATE()) AS dias_restantes
    FROM contratos c
    JOIN propiedades p ON c.propiedad_id = p.id
    LEFT JOIN inquilinos i ON c.inquilino_id = i.id
    WHERE c.estado = 'activo'
      AND c.fecha_fin BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 60 DAY)
    ORDER BY c.fecha_fin ASC
");
$stmt_vencer->execute();
$contratos_por_vencer = $stmt_vencer->fetchAll(PDO::FETCH_ASSOC);

// Obtener contratos vencidos sin renovación en los últimos 30 días
$stmt_vencidos = $pdo->prepare("
    SELECT c1.id, p.nombre AS propiedad_nombre, p.id AS propiedad_id, i.nombre AS inquilino_nombre, c1.fecha_fin,
           DATEDIFF(CURDATE(), c1.fecha_fin) AS dias_vencido
    FROM contratos c1
    JOIN propiedades p ON c1.propiedad_id = p.id
    LEFT JOIN inquilinos i ON c1.inquilino_id = i.id
    WHERE c1.estado = 'finalizado'
      AND c1.fecha_fin BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()
      AND NOT EXISTS (
        SELECT 1 FROM contratos c2
        WHERE c2.propiedad_id = c1.propiedad_id
          AND c2.estado = 'activo'
          AND c2.fecha_inicio > c1.fecha_fin
      )
    ORDER BY c1.fecha_fin DESC
");
$stmt_vencidos->execute();
$contratos_vencidos = $stmt_vencidos->fetchAll(PDO::FETCH_ASSOC);

// Obtener gastos del período seleccionado (excluyendo arqueos)
$stmt_gastos = $pdo->prepare("
    SELECT COALESCE(SUM(importe), 0) as total_gastos
    FROM gastos 
    WHERE fecha BETWEEN ? AND ? AND concepto != 'Arqueo de Caja (resta)'
");
$stmt_gastos->execute([$fecha_desde, $fecha_hasta]);
$total_gastos = $stmt_gastos->fetch(PDO::FETCH_ASSOC)['total_gastos'];

// Obtener cobros del período seleccionado (pagos mensuales, excluyendo arqueos)
$stmt_cobros = $pdo->prepare("
    SELECT COALESCE(SUM(importe), 0) as total_cobros
    FROM pagos 
    WHERE fecha BETWEEN ? AND ? AND concepto != 'Arqueo de Caja (suma)'
");
$stmt_cobros->execute([$fecha_desde, $fecha_hasta]);
$total_cobros = $stmt_cobros->fetch(PDO::FETCH_ASSOC)['total_cobros'];

// Calcular diferencia (cobros - gastos)
$diferencia = $total_cobros - $total_gastos;

// Obtener datos para gráficos - ingresos y egresos por mes
$stmt_grafico = $pdo->prepare("
    SELECT 
        DATE_FORMAT(fecha, '%Y-%m') as mes,
        DATE_FORMAT(fecha, '%M %Y') as mes_nombre,
        'ingresos' as tipo,
        COALESCE(SUM(importe), 0) as total
    FROM pagos 
    WHERE fecha BETWEEN ? AND ? AND concepto != 'Arqueo de Caja (suma)'
    GROUP BY DATE_FORMAT(fecha, '%Y-%m')
    
    UNION ALL
    
    SELECT 
        DATE_FORMAT(fecha, '%Y-%m') as mes,
        DATE_FORMAT(fecha, '%M %Y') as mes_nombre,
        'egresos' as tipo,
        COALESCE(SUM(importe), 0) as total
    FROM gastos 
    WHERE fecha BETWEEN ? AND ? AND concepto != 'Arqueo de Caja (resta)'
    GROUP BY DATE_FORMAT(fecha, '%Y-%m')
    
    ORDER BY mes, tipo
");
$stmt_grafico->execute([$fecha_desde, $fecha_hasta, $fecha_desde, $fecha_hasta]);
$datos_grafico = $stmt_grafico->fetchAll(PDO::FETCH_ASSOC);

// Procesar datos para el gráfico
$meses_grafico = [];
$ingresos_grafico = [];
$egresos_grafico = [];

foreach ($datos_grafico as $dato) {
    if (!in_array($dato['mes_nombre'], $meses_grafico)) {
        $meses_grafico[] = $dato['mes_nombre'];
    }
    
    if ($dato['tipo'] === 'ingresos') {
        $ingresos_grafico[$dato['mes']] = floatval($dato['total']);
    } else {
        $egresos_grafico[$dato['mes']] = floatval($dato['total']);
    }
}

// Asegurar que todos los meses tengan datos (0 si no hay)
$meses_unicos = array_unique(array_column($datos_grafico, 'mes'));
foreach ($meses_unicos as $mes) {
    if (!isset($ingresos_grafico[$mes])) {
        $ingresos_grafico[$mes] = 0;
    }
    if (!isset($egresos_grafico[$mes])) {
        $egresos_grafico[$mes] = 0;
    }
}

// Ordenar por mes
ksort($ingresos_grafico);
ksort($egresos_grafico);

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
  <h1>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?></h1>

  <!-- Filtros de fecha y búsqueda -->
  <div class="row mb-4">
    <div class="col-md-8">
      <form action="dashboard.php" method="GET" class="row g-3">
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
          <a href="dashboard.php" class="btn btn-outline-secondary">Limpiar</a>
        </div>
      </form>
    </div>
  </div>


  <!-- Indicadores Financieros del Mes -->
  <div class="row mb-3">
    <div class="col-md-4">
      <a href="listado_pagos.php" class="text-decoration-none">
        <div class="card mb-2">
          <div class="card-body py-2">
            <h6 class="card-title mb-1 text-success">Ingresos</h6>
            <p class="card-text h4 mb-1">$<?= number_format($total_cobros, 0, ',', '.') ?></p>
            <div class="small">
              <span>Total de pagos mensuales recibidos del <?= date('d/m/Y', strtotime($fecha_desde)) ?> al <?= date('d/m/Y', strtotime($fecha_hasta)) ?></span>
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-4">
      <a href="gastos.php" class="text-decoration-none">
        <div class="card mb-2">
          <div class="card-body py-2">
            <h6 class="card-title mb-1 text-danger">Egresos</h6>
            <p class="card-text h4 mb-1">$<?= number_format($total_gastos, 0, ',', '.') ?></p>
            <div class="small">
              <span>Total de gastos registrados del <?= date('d/m/Y', strtotime($fecha_desde)) ?> al <?= date('d/m/Y', strtotime($fecha_hasta)) ?></span>
            </div>
          </div>
        </div>
      </a>
    </div>
    <div class="col-md-4">
      <div class="card mb-2">
        <div class="card-body py-2">
          <h6 class="card-title mb-1 <?= $diferencia >= 0 ? 'text-success' : 'text-warning' ?>">Diferencia</h6>
          <p class="card-text h4 mb-1">$<?= number_format($diferencia, 0, ',', '.') ?></p>
          <div class="small">
            <span><?= $diferencia >= 0 ? 'Ganancia neta' : 'Pérdida neta' ?> del <?= date('d/m/Y', strtotime($fecha_desde)) ?> al <?= date('d/m/Y', strtotime($fecha_hasta)) ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Gráficos de Estadísticas -->
  <section class="mt-4">
    <h2 class="fw-semibold">Estadísticas de Movimientos</h2>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <canvas id="graficoMovimientos" width="400" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Reporte: Contratos por vencer -->
  <section class="mt-4">
    <h2 class="fw-semibold">Contratos por vencer <small>(próximos 60 días)</small></h2>
    <?php if (count($contratos_por_vencer) === 0): ?>
      <p>No hay contratos por vencer en los próximos 60 días.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-sm align-middle">
          <tbody>
            <?php foreach ($contratos_por_vencer as $c): ?>
              <tr>
                <td>
                  <a href="contratos.php?edit=<?= intval($c['id']) ?>" class="text-decoration-none text-dark"><b><?= htmlspecialchars($c['propiedad_nombre']) ?></b> <?= htmlspecialchars($c['inquilino_nombre'] ?? 'N/A') ?><br>
                    Vence: <?= date('d/m/Y', strtotime($c['fecha_fin'])) ?></a>
                </td>
                <td><span class="badge bg-danger">En <?= $c['dias_restantes'] ?> días</span></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>

  <!-- Reporte: Contratos vencidos sin renovación -->
  <section class="mt-4">
    <h2 class="fw-semibold">Contratos vencidos sin renovación <small>(últimos 30 días)</small></h2>
    <?php if (count($contratos_vencidos) === 0): ?>
      <p>No hay contratos vencidos sin renovación en los últimos 30 días.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-sm align-middle">
          <tbody>
            <?php foreach ($contratos_vencidos as $c): ?>
              <tr>
                <td>
                  <a href="contratos.php?edit=<?= intval($c['id']) ?>" class="text-decoration-none text-dark"><b><?= htmlspecialchars($c['propiedad_nombre']) ?></b> <?= htmlspecialchars($c['inquilino_nombre'] ?? 'N/A') ?><br>
                    Vencido: <?= date('d/m/Y', strtotime($c['fecha_fin'])) ?></a>
                </td>
                <td><span class="badge bg-warning">Hace <?= $c['dias_vencido'] ?> días</span></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>

  <!-- Enlace a Control de Pagos -->
  <section class="mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2 class="fw-semibold">Control de Pagos</h2>
      <a href="control_pagos.php" class="btn btn-primary">Ver Control de Pagos</a>
    </div>
    <p class="text-muted">Gestiona los pagos mensuales de tus propiedades desde la página dedicada.</p>
  </section>
</main>

<script>
// Datos para el gráfico
const datosGrafico = {
    meses: <?= json_encode(array_values($meses_grafico)) ?>,
    ingresos: <?= json_encode(array_values($ingresos_grafico)) ?>,
    egresos: <?= json_encode(array_values($egresos_grafico)) ?>
};

// Crear gráfico de movimientos
const ctx = document.getElementById('graficoMovimientos').getContext('2d');
const graficoMovimientos = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: datosGrafico.meses,
        datasets: [
            {
                label: 'Ingresos',
                data: datosGrafico.ingresos,
                backgroundColor: 'rgba(40, 167, 69, 0.8)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            },
            {
                label: 'Egresos',
                data: datosGrafico.egresos,
                backgroundColor: 'rgba(220, 53, 69, 0.8)',
                borderColor: 'rgba(220, 53, 69, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '$' + value.toLocaleString('es-ES');
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': $' + context.parsed.y.toLocaleString('es-ES');
                    }
                }
            }
        }
    }
});
</script>

<?php
include 'includes/footer.php';
?>