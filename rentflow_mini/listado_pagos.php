<?php
require_once 'config.php';
check_login();
$page_title = 'Listado de Pagos - Inmobiliaria';

$message = '';
$errors = [];

// Parámetros de filtro - declarar antes del manejo de exportación
$filtro_propiedad = $_GET['propiedad'] ?? '';
$filtro_propietario = $_GET['propietario'] ?? '';
$filtro_fecha_desde = $_GET['fecha_desde'] ?? '';
$filtro_fecha_hasta = $_GET['fecha_hasta'] ?? '';
$filtro_periodo = $_GET['periodo'] ?? '';
$filtro_concepto = $_GET['concepto'] ?? '';
$filtro_tipo_pago = $_GET['tipo_pago'] ?? '';

// Si no se envió ningún filtro de fecha, filtrar por el mes actual
if (empty($_GET['fecha_desde']) && empty($_GET['fecha_hasta']) && empty($_GET['periodo'])) {
    $primer_dia = date('Y-m-01');
    $ultimo_dia = date('Y-m-t');
    $filtro_fecha_desde = $primer_dia;
    $filtro_fecha_hasta = $ultimo_dia;
    // Simular que el usuario envió estos filtros para que se reflejen en el formulario
    $_GET['fecha_desde'] = $primer_dia;
    $_GET['fecha_hasta'] = $ultimo_dia;
}

// Manejo de eliminación de pagos
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $pago_id = intval($_GET['delete']);

    // Verificar que el pago existe
    $stmt = $pdo->prepare("SELECT p.*, p.comprobante FROM pagos p WHERE p.id = ?");
    $stmt->execute([$pago_id]);
    $pago_a_eliminar = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pago_a_eliminar) {
        // Eliminar el archivo de comprobante si existe
        if ($pago_a_eliminar['comprobante']) {
            $archivo_comprobante = __DIR__ . '/uploads/' . $pago_a_eliminar['comprobante'];
            if (file_exists($archivo_comprobante)) {
                unlink($archivo_comprobante);
            }
        }

        // Eliminar el pago de la base de datos
        $stmt = $pdo->prepare("DELETE FROM pagos WHERE id = ?");
        if ($stmt->execute([$pago_id])) {
            $message = "Pago eliminado correctamente.";
        } else {
            $errors[] = "Error al eliminar el pago.";
        }
    } else {
        $errors[] = "Pago no encontrado.";
    }
}

// Manejo de exportación a CSV
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    // Aplicar los mismos filtros para la exportación
    $sql_export = "
        SELECT 
            p.id as pago_id,
            p.fecha,
            p.periodo,
            prop.id as propiedad_id,
            prop.nombre as propiedad,
            prop.direccion,
            c.id as contrato_id,
            i.id as inquilino_id,
            i.nombre as inquilino,
            i.telefono,
            p.concepto,
            p.tipo_pago,
            p.importe,
            p.comentario
        FROM pagos p
        JOIN contratos c ON p.contrato_id = c.id
        JOIN propiedades prop ON c.propiedad_id = prop.id
        JOIN inquilinos i ON c.inquilino_id = i.id
        WHERE 1=1
    ";

    $params_export = [];

    if ($filtro_propiedad) {
        $sql_export .= " AND prop.nombre LIKE ?";
        $params_export[] = "%$filtro_propiedad%";
    }
    if ($filtro_propietario) {
        $sql_export .= " AND prop.propietario_id = ?";
        $params_export[] = $filtro_propietario;
    }
    if ($filtro_fecha_desde) {
        $sql_export .= " AND p.fecha >= ?";
        $params_export[] = $filtro_fecha_desde;
    }
    if ($filtro_fecha_hasta) {
        $sql_export .= " AND p.fecha <= ?";
        $params_export[] = $filtro_fecha_hasta;
    }
    if ($filtro_periodo) {
        $sql_export .= " AND p.periodo = ?";
        $params_export[] = $filtro_periodo;
    }
    if ($filtro_concepto) {
        $sql_export .= " AND p.concepto = ?";
        $params_export[] = $filtro_concepto;
    }
    if ($filtro_tipo_pago) {
        $sql_export .= " AND p.tipo_pago = ?";
        $params_export[] = $filtro_tipo_pago;
    }

    $sql_export .= " ORDER BY p.fecha DESC";

    $stmt_export = $pdo->prepare($sql_export);
    $stmt_export->execute($params_export);
    $pagos_export = $stmt_export->fetchAll(PDO::FETCH_ASSOC);

    // Configurar headers para descarga CSV
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="pagos_' . date('Y-m-d_H-i-s') . '.csv"');

    // Crear archivo CSV
    $output = fopen('php://output', 'w');

    // BOM para UTF-8
    fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

    // Headers del CSV
    fputcsv($output, [
        'ID Pago',
        'Fecha',
        'Período',
        'ID Propiedad',
        'Propiedad',
        'Dirección',
        'ID Contrato',
        'ID Inquilino',
        'Inquilino',
        'Teléfono',
        'Concepto',
        'Tipo de Pago',
        'Importe',
        'Comentario'
    ], ';');

    // Datos
    foreach ($pagos_export as $pago) {
        fputcsv($output, [
            $pago['pago_id'],
            $pago['fecha'],
            $pago['periodo'],
            $pago['propiedad_id'],
            $pago['propiedad'],
            $pago['direccion'],
            $pago['contrato_id'],
            $pago['inquilino_id'],
            $pago['inquilino'],
            $pago['telefono'],
            $pago['concepto'],
            $pago['tipo_pago'],
            $pago['importe'],
            $pago['comentario']
        ], ';');
    }

    fclose($output);
    exit();
}

// Construir la consulta base
$sql_base = "
    SELECT 
        p.id,
        p.periodo,
        p.fecha,
        p.importe,
        p.concepto,
        p.tipo_pago,
        p.comentario,
        p.comprobante,
        c.id as contrato_id,
        c.importe as renta_mensual,
        prop.id as propiedad_id,
        prop.nombre as propiedad_nombre,
        prop.direccion as propiedad_direccion,
        i.id as inquilino_id,
        i.nombre as inquilino_nombre,
        i.telefono as inquilino_telefono
    FROM pagos p
    JOIN contratos c ON p.contrato_id = c.id
    JOIN propiedades prop ON c.propiedad_id = prop.id
    JOIN inquilinos i ON c.inquilino_id = i.id
    WHERE 1=1
";

$params = [];

// Aplicar filtros
if ($filtro_propiedad) {
    $sql_base .= " AND prop.nombre LIKE ?";
    $params[] = "%$filtro_propiedad%";
}

if ($filtro_propietario) {
    $sql_base .= " AND prop.propietario_id = ?";
    $params[] = $filtro_propietario;
}

if ($filtro_fecha_desde) {
    $sql_base .= " AND p.fecha >= ?";
    $params[] = $filtro_fecha_desde;
}

if ($filtro_fecha_hasta) {
    $sql_base .= " AND p.fecha <= ?";
    $params[] = $filtro_fecha_hasta;
}

if ($filtro_periodo) {
    $sql_base .= " AND p.periodo = ?";
    $params[] = $filtro_periodo;
}

if ($filtro_concepto) {
    $sql_base .= " AND p.concepto = ?";
    $params[] = $filtro_concepto;
}

if ($filtro_tipo_pago) {
    $sql_base .= " AND p.tipo_pago = ?";
    $params[] = $filtro_tipo_pago;
}

$sql_base .= " ORDER BY p.fecha DESC";

// Ejecutar consulta
$stmt = $pdo->prepare($sql_base);
$stmt->execute($params);
$pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular indicadores
$total_pagos = count($pagos);
$monto_total = array_sum(array_column($pagos, 'importe'));

// Desglose por tipo de pago
$desglose_tipo = [];
foreach ($pagos as $pago) {
    $tipo = $pago['tipo_pago'] ?? 'Sin especificar';
    if (!isset($desglose_tipo[$tipo])) {
        $desglose_tipo[$tipo] = ['cantidad' => 0, 'monto' => 0];
    }
    $desglose_tipo[$tipo]['cantidad']++;
    $desglose_tipo[$tipo]['monto'] += $pago['importe'];
}

// Obtener datos para los filtros
$stmt_propiedades = $pdo->query("SELECT DISTINCT nombre FROM propiedades ORDER BY nombre");
$propiedades = $stmt_propiedades->fetchAll(PDO::FETCH_COLUMN);

$stmt_conceptos = $pdo->query("SELECT DISTINCT concepto FROM pagos WHERE concepto IS NOT NULL ORDER BY concepto");
$conceptos = $stmt_conceptos->fetchAll(PDO::FETCH_COLUMN);

$stmt_tipos = $pdo->query("SELECT DISTINCT tipo_pago FROM pagos WHERE tipo_pago IS NOT NULL ORDER BY tipo_pago");
$tipos_pago = $stmt_tipos->fetchAll(PDO::FETCH_COLUMN);

// Generar períodos para el filtro
$fecha_actual = new DateTime();
$periodos = [];
for ($i = -12; $i <= 3; $i++) {
    $fecha = clone $fecha_actual;
    $fecha->modify($i . ' month');
    $periodos[] = $fecha->format('Y-m');
}

include 'includes/header_nav.php';
?>

<main class="container container-main py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Pagos</h1>
        <a href="pagos.php" class="btn btn-outline-dark" style="font-weight:600;">Agregar Nuevo Pago</a>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Indicadores -->
    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pagos</h5>
                    <h3 class="card-text"><?= number_format($total_pagos) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Monto Total</h5>
                    <h3 class="card-text">$<?= number_format($monto_total, 2, ',', '.') ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Promedio</h5>
                    <h3 class="card-text">$<?= $total_pagos > 0 ? number_format($monto_total / $total_pagos, 2, ',', '.') : '0,00' ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Tipos de Pago</h5>
                    <h3 class="card-text"><?= count($desglose_tipo) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Desglose por tipo de pago -->
    <?php if (!empty($desglose_tipo)): ?>
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Desglose por Tipo de Pago</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-striped align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Tipo de Pago</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                        <th>Porcentaje</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($desglose_tipo as $tipo => $datos): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($tipo) ?></td>
                                            <td><?= $datos['cantidad'] ?></td>
                                            <td>$<?= number_format($datos['monto'], 2, ',', '.') ?></td>
                                            <td><?= $monto_total > 0 ? round(($datos['monto'] / $monto_total) * 100, 2) : 0 ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="propiedad" class="form-label">Propiedad</label>
                    <input type="text" class="form-control" id="propiedad" name="propiedad"
                        value="<?= htmlspecialchars($filtro_propiedad) ?>" placeholder="Buscar propiedad...">
                </div>
                <div class="col-md-3">
                    <label for="propietario" class="form-label">Propietario</label>
                    <select class="form-select" id="propietario" name="propietario">
                        <option value="">Todos los propietarios</option>
                        <?php
                        $stmt_propietarios = $pdo->query("SELECT id, nombre FROM propietarios ORDER BY nombre");
                        $propietarios = $stmt_propietarios->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($propietarios as $propietario): ?>
                            <option value="<?= htmlspecialchars($propietario['id']) ?>" <?= $filtro_propietario == $propietario['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($propietario['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="fecha_desde" class="form-label">Fecha Desde</label>
                    <input type="date" class="form-control" id="fecha_desde" name="fecha_desde"
                        value="<?= htmlspecialchars($filtro_fecha_desde) ?>">
                </div>
                <div class="col-md-2">
                    <label for="fecha_hasta" class="form-label">Fecha Hasta</label>
                    <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta"
                        value="<?= htmlspecialchars($filtro_fecha_hasta) ?>">
                </div>
                <div class="col-md-2">
                    <label for="periodo" class="form-label">Período</label>
                    <select class="form-select" id="periodo" name="periodo">
                        <option value="">Todos</option>
                        <?php foreach ($periodos as $periodo): ?>
                            <option value="<?= $periodo ?>" <?= $filtro_periodo === $periodo ? 'selected' : '' ?>>
                                <?= $periodo ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="concepto" class="form-label">Concepto</label>
                    <select class="form-select" id="concepto" name="concepto">
                        <option value="">Todos</option>
                        <?php foreach ($conceptos as $concepto): ?>
                            <option value="<?= $concepto ?>" <?= $filtro_concepto === $concepto ? 'selected' : '' ?>>
                                <?= htmlspecialchars($concepto) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tipo_pago" class="form-label">Tipo de Pago</label>
                    <select class="form-select" id="tipo_pago" name="tipo_pago">
                        <option value="">Todos</option>
                        <?php foreach ($tipos_pago as $tipo): ?>
                            <option value="<?= $tipo ?>" <?= $filtro_tipo_pago === $tipo ? 'selected' : '' ?>>
                                <?= htmlspecialchars($tipo) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                    <a href="listado_pagos.php" class="btn btn-outline-secondary">Borrar Filtros</a>
                    <a href="listado_pagos.php?export=csv&<?= http_build_query($_GET) ?>" class="btn btn-outline-success float-end"><i class="bi bi-file-earmark-excel"></i>
                        Exportar CSV
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de pagos -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Pagos Recibidos</h5>
            <span class="badge bg-secondary"><?= $total_pagos ?> registros</span>
        </div>
        <div class="card-body">
            <?php if (empty($pagos)): ?>
                <div class="text-center py-4">
                    <p class="text-muted">No se encontraron pagos con los filtros aplicados.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Período</th>
                                <th>Propiedad</th>
                                <th>Inquilino</th>
                                <th>Concepto</th>
                                <th>Tipo</th>
                                <th>Importe</th>
                                <th>Comprobante</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pagos as $pago): ?>
                                <tr>
                                    <td>
                                        <strong><?= date('d/m/Y', strtotime($pago['fecha'])) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary"><?= htmlspecialchars($pago['periodo']) ?></span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>
                                                <a href="propiedades.php?edit=<?= intval($pago['propiedad_id']) ?>" class="text-decoration-none text-dark">
                                                    <?= htmlspecialchars($pago['propiedad_nombre']) ?>
                                                </a>
                                            </strong>
                                            <?php if ($pago['propiedad_direccion']): ?>
                                                <br><small class="text-muted"><?= htmlspecialchars($pago['propiedad_direccion']) ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>
                                                <a href="inquilinos.php?edit=<?= intval($pago['inquilino_id']) ?>" class="text-decoration-none text-dark">
                                                    <?= htmlspecialchars($pago['inquilino_nombre']) ?>
                                                </a>
                                            </strong>
                                            <?php if ($pago['inquilino_telefono']): ?>
                                                <br><small class="text-muted"><?= htmlspecialchars($pago['inquilino_telefono']) ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?= htmlspecialchars($pago['concepto']) ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        // Si el tipo de pago contiene la palabra "efectivo" (sin importar mayúsculas/minúsculas), mostrar en verde, sino en gris
                                        $tipo_pago = $pago['tipo_pago'] ?? '';
                                        $clase_color = stripos($tipo_pago, 'efectivo') !== false ? 'success' : 'secondary';
                                        ?>
                                        <span class="badge bg-<?= $clase_color ?>">
                                            <?= htmlspecialchars($tipo_pago) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong class="text-success">$<?= number_format($pago['importe'], 2, ',', '.') ?></strong>
                                    </td>
                                    <td>
                                        <?php if ($pago['comprobante']): ?>
                                            <a href="uploads/<?= htmlspecialchars($pago['comprobante']) ?>"
                                                target="_blank" class="btn btn-sm btn-outline-secondary">
                                                Comprobante
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">Sin comprobante</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="pagos.php?contrato_id=<?= $pago['contrato_id'] ?>"
                                                class="btn btn-sm btn-outline-success" title="Ver contrato">
                                                Detalle
                                            </a>
                                            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="eliminarPago(<?= $pago['id'] ?>)" title="Eliminar">
                                                    Eliminar
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
    function eliminarPago(pagoId) {
        if (confirm('¿Está seguro de que desea eliminar este pago? Esta acción no se puede deshacer.')) {
            window.location.href = 'listado_pagos.php?delete=' + pagoId;
        }
    }

    // Auto-submit del formulario cuando cambien los filtros
    document.addEventListener('DOMContentLoaded', function() {
        const filterInputs = document.querySelectorAll('select[name], input[name]');
        filterInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Solo auto-submit para selects, no para inputs de texto
                if (this.tagName === 'SELECT') {
                    this.closest('form').submit();
                }
            });
        });
    });
</script>

<?php
include 'includes/footer.php';
?>