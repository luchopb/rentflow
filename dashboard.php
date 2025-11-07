<?php
require_once 'config.php';
check_login();
$page_title = 'Dashboard - Inmobiliaria';
include 'includes/header_nav.php';

// Obtener filtros de fecha
$fecha_desde = $_GET['fecha_desde'] ?? date('Y-m-01'); // Primer día del mes actual por defecto
$fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-t'); // Último día del mes actual por defecto
$busqueda = clean_input($_GET['search'] ?? '');
$propietario_id = intval($_GET['propietario_id'] ?? 0);

// Validar fechas
$fecha_desde = DateTime::createFromFormat('Y-m-d', $fecha_desde) ? $fecha_desde : date('Y-m-01');
$fecha_hasta = DateTime::createFromFormat('Y-m-d', $fecha_hasta) ? $fecha_hasta : date('Y-m-t');

// Obtener mes y año para compatibilidad con código existente
$mes_actual = date('m', strtotime($fecha_desde));
$anio_actual = date('Y', strtotime($fecha_desde));
$periodo = date('Y-m', strtotime($fecha_desde));

// Construir condiciones de filtro por propietario
$propietario_todos = "";
$propietario_todos_gastos = "";
$condicion_propietario_pagos = "";
$condicion_propietario_gastos = "";
$params_propietario_pagos = [];
$params_propietario_gastos = [];

if ($propietario_id > 0) {
    if ($propietario_id === 1) {
        // Si filtro por propietario id 1 (todos) agrego los pagos y gastos sin propietario
        $propietario_todos = " OR pr.propietario_id = 2 OR pr.propietario_id IS NULL";
        // Para los gastos agrego los gastos de todos porque salen de nuestra cuenta 
        $propietario_todos_gastos = " OR pr.propietario_id = 2 OR pr.propietario_id = 5 OR pr.propietario_id = 6 OR pr.propietario_id = 9 OR pr.propietario_id IS NULL";
    }
    $condicion_propietario_pagos = " AND (pr.propietario_id = ? $propietario_todos)";
    $condicion_propietario_gastos = " AND (pr.propietario_id = ? $propietario_todos_gastos)";
    $params_propietario_pagos[] = $propietario_id;
    $params_propietario_gastos[] = $propietario_id;
}

// Obtener lista de propietarios para el select
$stmt_propietarios = $pdo->query("SELECT id, nombre FROM propietarios ORDER BY nombre");
$propietarios = $stmt_propietarios->fetchAll(PDO::FETCH_ASSOC);


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
$sql_gastos = "
    SELECT COALESCE(SUM(g.importe), 0) as total_gastos
    FROM gastos g
    LEFT JOIN propiedades pr ON g.propiedad_id = pr.id
    WHERE g.fecha BETWEEN ? AND ? AND g.concepto != 'Arqueo de Caja (resta)'
    $condicion_propietario_gastos
";
$params_gastos = [$fecha_desde, $fecha_hasta];
$params_gastos = array_merge($params_gastos, $params_propietario_gastos);
$stmt_gastos = $pdo->prepare($sql_gastos);
$stmt_gastos->execute($params_gastos);
$total_gastos = $stmt_gastos->fetch(PDO::FETCH_ASSOC)['total_gastos'];

// Obtener cobros del período seleccionado (pagos mensuales, excluyendo arqueos)
$sql_cobros = "
    SELECT COALESCE(SUM(p.importe), 0) as total_cobros
    FROM pagos p
    LEFT JOIN contratos c ON p.contrato_id = c.id
    LEFT JOIN propiedades pr ON c.propiedad_id = pr.id
    WHERE p.fecha BETWEEN ? AND ? AND p.concepto != 'Arqueo de Caja (suma)'
    $condicion_propietario_pagos
";
$params_cobros = [$fecha_desde, $fecha_hasta];
$params_cobros = array_merge($params_cobros, $params_propietario_pagos);
$stmt_cobros = $pdo->prepare($sql_cobros);
$stmt_cobros->execute($params_cobros);
$total_cobros = $stmt_cobros->fetch(PDO::FETCH_ASSOC)['total_cobros'];

/*echo '<pre style="background: #f4f4f4; padding: 10px; border: 1px solid #ddd; margin: 10px;">';
echo 'DEBUG SQL: ' . $sql_cobros . "\n";
echo 'DEBUG PARAMS: ';
print_r($params_cobros);
echo '</pre>';*/
// die();

// Calcular diferencia (cobros - gastos)
$diferencia = $total_cobros - $total_gastos;

// Obtener datos para gráficos - ingresos y egresos por mes
$sql_grafico_pagos = "
    SELECT 
        DATE_FORMAT(p.fecha, '%Y-%m') as mes,
        DATE_FORMAT(p.fecha, '%M %Y') as mes_nombre,
        'ingresos' as tipo,
        COALESCE(SUM(p.importe), 0) as total
    FROM pagos p
    LEFT JOIN contratos c ON p.contrato_id = c.id
    LEFT JOIN propiedades pr ON c.propiedad_id = pr.id
    WHERE p.fecha BETWEEN ? AND ? AND p.concepto != 'Arqueo de Caja (suma)'
    $condicion_propietario_pagos
    GROUP BY DATE_FORMAT(p.fecha, '%Y-%m')
";

$sql_grafico_gastos = "
    SELECT 
        DATE_FORMAT(g.fecha, '%Y-%m') as mes,
        DATE_FORMAT(g.fecha, '%M %Y') as mes_nombre,
        'egresos' as tipo,
        COALESCE(SUM(g.importe), 0) as total
    FROM gastos g
    LEFT JOIN propiedades pr ON g.propiedad_id = pr.id
    WHERE g.fecha BETWEEN ? AND ? AND g.concepto != 'Arqueo de Caja (resta)'
    $condicion_propietario_gastos
    GROUP BY DATE_FORMAT(g.fecha, '%Y-%m')
";

$sql_grafico = $sql_grafico_pagos . " UNION ALL " . $sql_grafico_gastos . " ORDER BY mes, tipo";

$params_grafico = [$fecha_desde, $fecha_hasta];
$params_grafico = array_merge($params_grafico, $params_propietario_pagos);
$params_grafico = array_merge($params_grafico, [$fecha_desde, $fecha_hasta]);
$params_grafico = array_merge($params_grafico, $params_propietario_gastos);

$stmt_grafico = $pdo->prepare($sql_grafico);
$stmt_grafico->execute($params_grafico);
$datos_grafico = $stmt_grafico->fetchAll(PDO::FETCH_ASSOC);

// Procesar datos para el gráfico
$meses_grafico = [];
$meses_formato = []; // Array para mapear índices a formato YYYY-MM
$ingresos_grafico = [];
$egresos_grafico = [];
$mes_mapa = []; // Mapa para asociar mes_nombre con mes (YYYY-MM)

foreach ($datos_grafico as $dato) {
    if (!isset($mes_mapa[$dato['mes_nombre']])) {
        $meses_grafico[] = $dato['mes_nombre'];
        $meses_formato[] = $dato['mes']; // Guardar el formato YYYY-MM correspondiente
        $mes_mapa[$dato['mes_nombre']] = $dato['mes'];
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

// Ordenar ambos arrays juntos basándose en el formato YYYY-MM
$meses_combinados = [];
for ($i = 0; $i < count($meses_grafico); $i++) {
    $meses_combinados[] = [
        'nombre' => $meses_grafico[$i],
        'formato' => $meses_formato[$i]
    ];
}
// Ordenar por formato (YYYY-MM)
usort($meses_combinados, function($a, $b) {
    return strcmp($a['formato'], $b['formato']);
});
// Reconstruir los arrays ordenados
$meses_grafico = array_column($meses_combinados, 'nombre');
$meses_formato = array_column($meses_combinados, 'formato');

// Ordenar los arrays de datos por mes
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
    <div class="col-md-12">
      <form action="dashboard.php" method="GET" class="row g-3">
        <div class="col-md-2">
          <label for="fecha_desde" class="form-label">Desde:</label>
          <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" 
                 value="<?= htmlspecialchars($fecha_desde) ?>" required>
        </div>
        <div class="col-md-2">
          <label for="fecha_hasta" class="form-label">Hasta:</label>
          <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" 
                 value="<?= htmlspecialchars($fecha_hasta) ?>" required>
        </div>
        <div class="col-md-3">
          <label for="propietario_id" class="form-label">Propietario:</label>
          <select class="form-select" id="propietario_id" name="propietario_id">
            <option value="">Todos los propietarios</option>
            <?php foreach ($propietarios as $propietario): ?>
              <option value="<?= $propietario['id'] ?>" <?= $propietario_id == $propietario['id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($propietario['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3">
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
// Datos para el gráfico - asegurar que los datos estén en el mismo orden que los meses
const mesesFormato = <?= json_encode(array_values($meses_formato)) ?>;
const ingresosData = <?= json_encode($ingresos_grafico) ?>;
const egresosData = <?= json_encode($egresos_grafico) ?>;
const ingresosOrdenados = [];
const egresosOrdenados = [];

mesesFormato.forEach(mes => {
    ingresosOrdenados.push(ingresosData[mes] || 0);
    egresosOrdenados.push(egresosData[mes] || 0);
});

const datosGrafico = {
    meses: <?= json_encode(array_values($meses_grafico)) ?>,
    mesesFormato: mesesFormato,
    ingresos: ingresosOrdenados,
    egresos: egresosOrdenados
};

// Función para obtener el primer y último día de un mes en formato YYYY-MM
function obtenerRangoFechas(mes) {
    // mes está en formato YYYY-MM
    const [anio, mesNumStr] = mes.split('-');
    const mesNum = parseInt(mesNumStr, 10); // Convertir a número (1-12)
    const primerDia = `${anio}-${mesNumStr}-01`;
    // Obtener el último día del mes: Date(año, mes, 0) donde mes es el mes siguiente en 0-indexed
    // Si mesNum es 6 (junio), Date(2025, 6, 0) = último día de junio porque 6 es julio en 0-indexed
    const ultimoDia = new Date(anio, mesNum, 0);
    const ultimoDiaFormato = `${anio}-${mesNumStr}-${String(ultimoDia.getDate()).padStart(2, '0')}`;
    return { desde: primerDia, hasta: ultimoDiaFormato };
}

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
        onClick: (event, elements) => {
            // Si se hizo clic en un elemento del gráfico
            if (elements.length > 0) {
                const elemento = elements[0];
                const indiceMes = elemento.index; // Índice del mes (0, 1, 2, etc.)
                const datasetIndex = elemento.datasetIndex; // 0 = Ingresos, 1 = Egresos
                const mesFormato = datosGrafico.mesesFormato[indiceMes];
                
                if (mesFormato) {
                    const rangoFechas = obtenerRangoFechas(mesFormato);
                    const fechaDesde = rangoFechas.desde;
                    const fechaHasta = rangoFechas.hasta;
                    const propietarioId = <?= $propietario_id ? $propietario_id : 'null' ?>;
                    const paramPropietario = propietarioId ? `&propietario=${propietarioId}` : '';
                    
                    // Redirigir según el tipo de barra
                    if (datasetIndex === 0) {
                        // Barra verde (Ingresos) -> listado_pagos.php
                        window.location.href = `listado_pagos.php?fecha_desde=${fechaDesde}&fecha_hasta=${fechaHasta}${paramPropietario}`;
                    } else if (datasetIndex === 1) {
                        // Barra roja (Egresos) -> gastos.php
                        window.location.href = `gastos.php?fecha_desde=${fechaDesde}&fecha_hasta=${fechaHasta}${paramPropietario}`;
                    }
                }
            }
        },
        onHover: (event, elements) => {
            // Cambiar el cursor cuando se pasa sobre una barra
            event.native.target.style.cursor = elements.length > 0 ? 'pointer' : 'default';
        },
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