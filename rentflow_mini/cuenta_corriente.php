<?php
// Incluir cabecera y conexión
include 'config.php';
include 'includes/header_nav.php';

// --- Lógica para insertar arqueo de caja ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fecha_arqueo'], $_POST['tipo_arqueo'], $_POST['importe'], $_POST['tipo_pago'])) {
    $fecha = $_POST['fecha_arqueo'];
    $tipo_arqueo = $_POST['tipo_arqueo'];
    $importe = floatval($_POST['importe']);
    $tipo_pago = $_POST['tipo_pago'];
    $usuario_id = 1; // Puedes cambiar esto por el usuario logueado si lo tienes
    $concepto = 'Arqueo de Caja';
    $comprobante = null;

    if ($tipo_arqueo === 'sumar') {
        // Insertar como pago
        $sql = "INSERT INTO pagos (fecha, concepto, tipo_pago, importe, comentario, comprobante, pagado, validado, usuario_id) VALUES (?, ?, ?, ?, ?, ?, 1, 1, ?)";
        $stmt = $pdo->prepare($sql);
        $comentario = 'Arqueo de caja (suma)';
        $stmt->execute([$fecha, $concepto, $tipo_pago, $importe, $comentario, $comprobante, $usuario_id]);
    } else {
        // Insertar como gasto
        $sql = "INSERT INTO gastos (fecha, concepto, importe, forma_pago, observaciones, comprobante, usuario_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $observaciones = 'Arqueo de caja (resta)';
        $stmt->execute([$fecha, $concepto, $importe, $tipo_pago, $observaciones, $comprobante, $usuario_id]);
    }
    // Redirigir para evitar reenvío del formulario
    header('Location: cuenta_corriente.php');
    exit;
}

// --- Consultar propietarios para el filtro ---
$propietarios = $pdo->query("SELECT id, nombre FROM propietarios ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
$propietario_id = isset($_GET['propietario_id']) ? intval($_GET['propietario_id']) : 0;


// --- Consulta de pagos ---
$query_pagos = "SELECT p.fecha, p.concepto, p.tipo_pago AS forma_pago, p.comprobante, p.importe, 'pago' AS tipo
FROM pagos p
LEFT JOIN contratos c ON p.contrato_id = c.id
LEFT JOIN propiedades pr ON c.propiedad_id = pr.id
WHERE 1=1";


// --- Consulta de gastos ---
$query_gastos = "SELECT g.fecha, g.concepto, g.forma_pago, g.comprobante, g.importe, 'gasto' AS tipo
FROM gastos g
LEFT JOIN propiedades pr ON g.propiedad_id = pr.id
WHERE 1=1";

// --- Filtros ---
$fecha_inicio = isset($_GET['fecha_inicio']) && $_GET['fecha_inicio'] ? $_GET['fecha_inicio'] : '2025-01-01';
$fecha_fin = isset($_GET['fecha_fin']) && $_GET['fecha_fin'] ? $_GET['fecha_fin'] : date('Y-m-d');
$filtro_tipo_pago = isset($_GET['filtro_tipo_pago']) ? $_GET['filtro_tipo_pago'] : 'Todos';

$params = [];
$types = '';
if ($fecha_inicio) {
    $query_gastos .= " AND g.fecha >= ?";
    $query_pagos .= " AND p.fecha >= ?";
    $params[] = $fecha_inicio;
    $types .= 's';
}
if ($fecha_fin) {
    $query_gastos .= " AND g.fecha <= ?";
    $query_pagos .= " AND p.fecha <= ?";
    $params[] = $fecha_fin;
    $types .= 's';
}
if ($filtro_tipo_pago && $filtro_tipo_pago !== 'Todos') {
    if ($filtro_tipo_pago == 'Efectivo') {
        $query_gastos .= " AND g.forma_pago LIKE ?";
        $query_pagos .= " AND p.tipo_pago LIKE ?";
        $params[] = '%' . $filtro_tipo_pago . '%';
        $types .= 's';
    } else {
        $query_gastos .= " AND g.forma_pago NOT LIKE ?";
        $query_pagos .= " AND p.tipo_pago NOT LIKE ?";
        $params[] = '%Efectivo%';
        $types .= 's';
    }
}
if ($propietario_id) {
    $query_gastos .= " AND pr.propietario_id = ?";
    $query_pagos .= " AND pr.propietario_id = ?";
    $params[] = $propietario_id;
    $types .= 'i';
}

// Ejecutar consultas
$movimientos = [];
$stmt = $pdo->prepare($query_pagos . " ORDER BY fecha ASC");
if ($types) {
    $stmt->execute($params);
} else {
    $stmt->execute();
}
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $row['credito'] = $row['importe'];
    $row['debito'] = 0;
    $movimientos[] = $row;
}

$stmt = $pdo->prepare($query_gastos . " ORDER BY fecha ASC");
if ($types) {
    $stmt->execute($params);
} else {
    $stmt->execute();
}
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
    $row['credito'] = 0;
    $row['debito'] = $row['importe'];
    $movimientos[] = $row;
}

// Ordenar todos los movimientos por fecha y luego por tipo (pago antes que gasto en la misma fecha)
usort($movimientos, function ($a, $b) {
    if ($a['fecha'] == $b['fecha']) {
        return strcmp($a['tipo'], $b['tipo']);
    }
    return strcmp($a['fecha'], $b['fecha']);
});

// Calcular saldo acumulado
$saldo = 0;
foreach ($movimientos as $i => $mov) {
    $saldo += $mov['credito'] - $mov['debito'];
    $movimientos[$i]['saldo'] = $saldo;
}
?>

<div class="container mt-4">
    <h2>Cuenta Corriente</h2>
    <div class="card d-none">
        <div class="card-header">
            <h5 class="mb-0">Arqueo de Caja</h5>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="row mb-2">
                    <div class="col-md-3">
                        <label for="fecha_arqueo">Fecha:</label>
                        <input type="date" class="form-control" name="fecha_arqueo" required>
                    </div>
                    <div class="col-md-3">
                        <label>Tipo de arqueo:</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_arqueo" id="sumar" value="sumar" checked>
                            <label class="form-check-label" for="sumar">Sumar</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_arqueo" id="restar" value="restar">
                            <label class="form-check-label" for="restar">Restar</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="importe">Importe:</label>
                        <input type="number" step="0.01" class="form-control" name="importe" required>
                    </div>
                    <div class="col-md-3">
                        <label for="tipo_pago">Tipo de Pago:</label>
                        <select class="form-control" name="tipo_pago" required>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Agregar Arqueo</button>
            </form>
        </div>
    </div>
</div>

<div class="container mt-4">

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Filtros</h5>
        </div>
        <div class="card-body">
            <!-- Filtros del reporte -->
            <form method="get" class="row mb-3">
                <div class="col-md-3">
                    <label for="fecha_inicio">Desde:</label>
                    <input type="date" class="form-control" name="fecha_inicio" value="<?php echo htmlspecialchars($fecha_inicio); ?>">
                </div>
                <div class="col-md-3">
                    <label for="fecha_fin">Hasta:</label>
                    <input type="date" class="form-control" name="fecha_fin" value="<?php echo htmlspecialchars($fecha_fin); ?>">
                </div>
                <div class="col-md-3">
                    <label for="filtro_tipo_pago">Tipo de Pago:</label>
                    <select class="form-control" name="filtro_tipo_pago">
                        <option value="Todos" <?php if ($filtro_tipo_pago == 'Todos') echo 'selected'; ?>>Todos</option>
                        <option value="Efectivo" <?php if ($filtro_tipo_pago == 'Efectivo') echo 'selected'; ?>>Efectivo</option>
                        <option value="Transferencia" <?php if ($filtro_tipo_pago == 'Transferencia') echo 'selected'; ?>>Transferencia</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="propietario_id">Propietario:</label>
                    <select class="form-control" name="propietario_id">
                        <option value="0">Todos</option>
                        <?php foreach ($propietarios as $prop): ?>
                            <option value="<?php echo $prop['id']; ?>" <?php if ($propietario_id == $prop['id']) echo 'selected'; ?>><?php echo htmlspecialchars($prop['nombre']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Aplicar filtros</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive mt-4">
        <!-- Tabla de cuenta corriente -->
        <table class="table table-bordered table-sm table-hover tabla-cuentacorriente">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Detalle</th>
                    <th>Tipo de pago</th>
                    <th>Crédito</th>
                    <th>Débito</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movimientos as $mov): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($mov['fecha']); ?></td>
                        <td>
                            <?php if (!empty($mov['comprobante'])): ?>
                                <a href="uploads/<?php echo urlencode($mov['comprobante']); ?>" target="_blank" class="badge bg-info">
                                    Comprobante
                                </a>
                            <?php else: ?>
                                <small class="badge bg-secondary">Sin comprobante</small>
                            <?php endif; ?>
                            <?php echo htmlspecialchars($mov['concepto']); ?>
                        </td>
                        <td><?php echo htmlspecialchars($mov['forma_pago']); ?></td>
                        <td><?php echo $mov['credito'] ? number_format($mov['credito'], 2, ',', '.') : ''; ?></td>
                        <td><?php echo $mov['debito'] ? number_format($mov['debito'], 2, ',', '.') : ''; ?></td>
                        <td><?php echo number_format($mov['saldo'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php
// Incluir pie de página
include 'includes/footer.php';
