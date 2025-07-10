<?php
require_once 'config.php';
require_once 'includes/email_helper.php';
check_login();
$page_title = 'Gastos - Inmobiliaria';

$edit_id = intval($_GET['edit'] ?? 0);
$delete_id = intval($_GET['delete'] ?? 0);
$message = '';
$errors = [];
$busqueda = clean_input($_GET['search'] ?? '');
$filtro_concepto = clean_input($_GET['filtro_concepto'] ?? '');
$propiedad_id = intval($_GET['propiedad_id'] ?? 0);

// Verificar si se debe mostrar el formulario de nuevo gasto
$show_form = (isset($_GET['add']) && $_GET['add'] === 'true') || $edit_id > 0;

// Eliminar gasto
if ($delete_id) {
    $upload_dir = __DIR__ . '/uploads/';
    $stmt = $pdo->prepare("SELECT comprobante FROM gastos WHERE id = ?");
    $stmt->execute([$delete_id]);
    $row = $stmt->fetch();
    if ($row && $row['comprobante']) {
        $path = $upload_dir . basename($row['comprobante']);
        if (is_file($path)) unlink($path);
    }
    $pdo->prepare("DELETE FROM gastos WHERE id = ?")->execute([$delete_id]);
    $message = "Gasto eliminado correctamente.";
}

$msg = $_GET['msg'] ?? '';
if ($msg) {
    $message = $msg;
}

// Manejo del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $edit_id = intval($_POST['edit_id'] ?? 0);
    $fecha = $_POST['fecha'] ?? '';
    $concepto = clean_input($_POST['concepto'] ?? '');
    $importe = floatval($_POST['importe'] ?? 0);
    $forma_pago = clean_input($_POST['forma_pago'] ?? '');
    $observaciones = clean_input($_POST['observaciones'] ?? '');
    $propiedad_id_form = intval($_POST['propiedad_id'] ?? 0);

    // Validaciones
    if (!$fecha) $errors[] = "La fecha es obligatoria.";
    if (!$concepto) $errors[] = "El concepto es obligatorio.";
    if ($importe <= 0) $errors[] = "El importe debe ser mayor que cero.";
    if (!$forma_pago) $errors[] = "La forma de pago es obligatoria.";

    // Manejo de archivo de comprobante
    $comprobante = null;
    if (!empty($_FILES['comprobante']['name'])) {
        $upload_dir = __DIR__ . '/uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file = $_FILES['comprobante'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];

        if (!in_array($ext, $allowed_extensions)) {
            $errors[] = "Solo se permiten archivos jpg, jpeg, png, gif o pdf.";
        } else {
            $basename = uniqid() . '-' . basename($file['name']);
            if (move_uploaded_file($file['tmp_name'], $upload_dir . $basename)) {
                $comprobante = $basename;
            } else {
                $errors[] = "Error al subir el comprobante.";
            }
        }
    }

    if (empty($errors)) {
        $usuario_id = $_SESSION['user_id'];
        $fecha_hora = date('Y-m-d H:i:s');

        if ($edit_id > 0) {
            // Actualizar gasto existente
            $sql = "UPDATE gastos SET fecha=?, concepto=?, importe=?, forma_pago=?, observaciones=?, propiedad_id=?, usuario_id=?, fecha_modificacion=?";
            $params = [$fecha, $concepto, $importe, $forma_pago, $observaciones, $propiedad_id_form ?: null, $usuario_id, $fecha_hora];

            if ($comprobante) {
                $sql .= ", comprobante=?";
                $params[] = $comprobante;
            }

            $sql .= " WHERE id=?";
            $params[] = $edit_id;

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $message = "Gasto actualizado correctamente.";
        } else {
            // Insertar nuevo gasto
            $stmt = $pdo->prepare("INSERT INTO gastos (fecha, concepto, importe, forma_pago, observaciones, comprobante, propiedad_id, usuario_id, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$fecha, $concepto, $importe, $forma_pago, $observaciones, $comprobante, $propiedad_id_form ?: null, $usuario_id, $fecha_hora]);
            $message = "Gasto registrado correctamente.";
        }

        // Enviar email a los emails del propietario id=1
        $stmt = $pdo->prepare("SELECT email, nombre FROM propietarios WHERE id = 1");
        $stmt->execute();
        $prop = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($prop && $prop['email']) {
            $destinatarios = array_filter(explode(',', $prop['email']));
            $asunto = 'Nuevo Gasto registrado en RentFlow';
            $cuerpo = '<h2>Detalle del Gasto</h2>';
            $cuerpo .= '<b>Concepto:</b> ' . htmlspecialchars($concepto) . '<br>';
            $cuerpo .= '<b>Importe:</b> $' . number_format($importe, 2, ',', '.') . '<br>';
            $cuerpo .= '<b>Forma de pago:</b> ' . htmlspecialchars($forma_pago) . '<br>';
            if ($propiedad_id_form) {
                $stmt2 = $pdo->prepare("SELECT nombre, direccion FROM propiedades WHERE id = ?");
                $stmt2->execute([$propiedad_id_form]);
                $pinfo = $stmt2->fetch(PDO::FETCH_ASSOC);
                if ($pinfo) {
                    $cuerpo .= '<b>Propiedad:</b> ' . htmlspecialchars($pinfo['nombre']) . ' (' . htmlspecialchars($pinfo['direccion']) . ')<br>';
                }
            }
            if ($observaciones) $cuerpo .= '<b>Observaciones:</b> ' . htmlspecialchars($observaciones) . '<br>';
            enviar_email($destinatarios, $asunto, $cuerpo);
        }
        header("Location: gastos.php?msg=" . urlencode($message));
        exit();
    } else {
        $edit_data = compact('fecha', 'concepto', 'importe', 'forma_pago', 'observaciones', 'propiedad_id_form');
    }
} else {
    $edit_data = null;
    if ($edit_id) {
        $stmt = $pdo->prepare("SELECT * FROM gastos WHERE id = ?");
        $stmt->execute([$edit_id]);
        $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Obtener propiedades para el formulario
$stmt = $pdo->prepare("SELECT id, nombre, direccion FROM propiedades ORDER BY nombre");
$stmt->execute();
$propiedades = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Filtros de fecha
$fecha_desde = $_GET['fecha_desde'] ?? date('Y-m-01');
$fecha_hasta = $_GET['fecha_hasta'] ?? date('Y-m-t');

// Consulta con búsqueda y filtros
$params = [];
$sql = "SELECT g.*, p.nombre as propiedad_nombre, p.direccion as propiedad_direccion, u.username as usuario_nombre 
        FROM gastos g 
        LEFT JOIN propiedades p ON g.propiedad_id = p.id 
        LEFT JOIN usuarios u ON g.usuario_id = u.id";

$where_conditions = [];
if ($busqueda) {
    $where_conditions[] = "(g.concepto LIKE ? OR g.observaciones LIKE ? OR p.nombre LIKE ? OR p.direccion LIKE ?)";
    $like_search = '%' . $busqueda . '%';
    $params = array_merge($params, [$like_search, $like_search, $like_search, $like_search]);
}
if ($filtro_concepto) {
    $where_conditions[] = "g.concepto = ?";
    $params[] = $filtro_concepto;
}
if ($propiedad_id) {
    $where_conditions[] = "g.propiedad_id = ?";
    $params[] = $propiedad_id;
}
if ($fecha_desde) {
    $where_conditions[] = "g.fecha >= ?";
    $params[] = $fecha_desde;
}
if ($fecha_hasta) {
    $where_conditions[] = "g.fecha <= ?";
    $params[] = $fecha_hasta;
}
if (!empty($where_conditions)) {
    $sql .= " WHERE " . implode(' AND ', $where_conditions);
}
$sql .= " ORDER BY g.fecha DESC, g.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$gastos = $stmt->fetchAll();

// Estadísticas
$total_gastos = array_sum(array_column($gastos, 'importe'));
$cantidad_gastos = count($gastos);
$promedio_gastos = $cantidad_gastos > 0 ? $total_gastos / $cantidad_gastos : 0;
$tipos_concepto = count(array_unique(array_column($gastos, 'concepto')));

include 'includes/header_nav.php';
?>

<main class="container container-main py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gastos</h1>
        <button class="btn btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#formGastoCollapse" aria-expanded="<?= $show_form ? 'true' : 'false' ?>" aria-controls="formGastoCollapse" style="font-weight:600;">
            <?= $show_form ? 'Ocultar' : 'Agregar Nuevo Gasto' ?>
        </button>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul><?php foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?></ul>
        </div>
    <?php endif; ?>

    <!-- Formulario de gasto -->
    <div class="collapse <?= $show_form ? 'show' : '' ?>" id="formGastoCollapse">
        <div class="card mb-4">
            <div class="card-header">
                <h5><?= $edit_id ? 'Editar Gasto' : 'Registrar Nuevo Gasto' ?></h5>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="edit_id" value="<?= $edit_id ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha *</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" value="<?= htmlspecialchars($edit_data['fecha'] ?? date('Y-m-d')) ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="concepto" class="form-label">Concepto *</label>
                                <select name="concepto" id="concepto" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Pago de Gastos comunes" <?= ($edit_data['concepto'] ?? '') === 'Pago de Gastos comunes' ? 'selected' : '' ?>>Pago de Gastos comunes</option>
                                    <option value="Pago de Impuestos" <?= ($edit_data['concepto'] ?? '') === 'Pago de Impuestos' ? 'selected' : '' ?>>Pago de Impuestos</option>
                                    <option value="Pago de Servicios" <?= ($edit_data['concepto'] ?? '') === 'Pago de Servicios' ? 'selected' : '' ?>>Pago de Servicios</option>
                                    <option value="Pago de Reparaciones" <?= ($edit_data['concepto'] ?? '') === 'Pago de Reparaciones' ? 'selected' : '' ?>>Pago de Reparaciones</option>
                                    <option value="Pago de Mantenimiento" <?= ($edit_data['concepto'] ?? '') === 'Pago de Mantenimiento' ? 'selected' : '' ?>>Pago de Mantenimiento</option>
                                    <option value="Pago de Convenios" <?= ($edit_data['concepto'] ?? '') === 'Pago de Convenios' ? 'selected' : '' ?>>Pago de Convenios</option>
                                    <option value="Otros" <?= ($edit_data['concepto'] ?? '') === 'Otros' ? 'selected' : '' ?>>Otros</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="importe" class="form-label">Importe *</label>
                                <input type="number" step="1" min="0" class="form-control" id="importe" name="importe" value="<?= htmlspecialchars($edit_data['importe'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="forma_pago" class="form-label">Forma de Pago *</label>
                                <select name="forma_pago" id="forma_pago" class="form-select" required>
                                    <option value="">Seleccione...</option>
                                    <option value="Efectivo" <?= ($edit_data['forma_pago'] ?? '') === 'Efectivo' ? 'selected' : '' ?>>Efectivo</option>
                                    <option value="Transferencia" <?= ($edit_data['forma_pago'] ?? '') === 'Transferencia' ? 'selected' : '' ?>>Transferencia</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="propiedad_id_form" class="form-label">Propiedad (opcional)</label>
                        <select name="propiedad_id" id="propiedad_id_form" class="form-select">
                            <option value="">Sin propiedad específica</option>
                            <?php foreach ($propiedades as $prop): ?>
                                <option value="<?= $prop['id'] ?>" <?= ($edit_data['propiedad_id'] ?? '') == $prop['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($prop['nombre']) ?> - <?= htmlspecialchars($prop['direccion']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"><?= htmlspecialchars($edit_data['observaciones'] ?? '') ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="comprobante" class="form-label">Comprobante</label>
                        <input type="file" class="form-control" id="comprobante" name="comprobante" accept="image/*,application/pdf">
                        <?php if ($edit_data && $edit_data['comprobante']): ?>
                            <small class="form-text text-muted">Comprobante actual: <?= htmlspecialchars($edit_data['comprobante']) ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <?= $edit_id ? 'Actualizar Gasto' : 'Registrar Gasto' ?>
                        </button>
                        <?php if ($edit_id): ?>
                            <a href="gastos.php" class="btn btn-outline-secondary">Cancelar</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Indicadores estadísticos -->
    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h5 class="card-text">Total Gastos</h3>
                        <h3 class="card-title"><?= $cantidad_gastos ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <h5 class="card-text">Monto Total</h3>
                        <h3 class="card-title">$<?= number_format($total_gastos, 2, ',', '.') ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-white bg-info h-100">
                <div class="card-body">
                    <h5 class="card-text">Promedio</h3>
                        <h3 class="card-title">$<?= number_format($promedio_gastos, 2, ',', '.') ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card text-dark bg-warning h-100">
                <div class="card-body">
                    <h5 class="card-text">Tipos de Concepto</h5>
                    <h3 class="card-title"><?= $tipos_concepto ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de búsqueda y filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="fecha_desde" class="form-label">Fecha desde</label>
                    <input type="date" class="form-control" id="fecha_desde" name="fecha_desde" value="<?= htmlspecialchars($fecha_desde) ?>">
                </div>
                <div class="col-md-3">
                    <label for="fecha_hasta" class="form-label">Fecha hasta</label>
                    <input type="date" class="form-control" id="fecha_hasta" name="fecha_hasta" value="<?= htmlspecialchars($fecha_hasta) ?>">
                </div>
                <div class="col-md-3">
                    <label for="filtro_concepto" class="form-label">Concepto</label>
                    <select class="form-select" id="filtro_concepto" name="filtro_concepto">
                        <option value="">Todos los conceptos</option>
                        <option value="Pago de Gastos comunes" <?= $filtro_concepto === 'Pago de Gastos comunes' ? 'selected' : '' ?>>Pago de Gastos comunes</option>
                        <option value="Pago de Impuestos" <?= $filtro_concepto === 'Pago de Impuestos' ? 'selected' : '' ?>>Pago de Impuestos</option>
                        <option value="Pago de Servicios" <?= $filtro_concepto === 'Pago de Servicios' ? 'selected' : '' ?>>Pago de Servicios</option>
                        <option value="Pago de Reparaciones" <?= $filtro_concepto === 'Pago de Reparaciones' ? 'selected' : '' ?>>Pago de Reparaciones</option>
                        <option value="Pago de Mantenimiento" <?= $filtro_concepto === 'Pago de Mantenimiento' ? 'selected' : '' ?>>Pago de Mantenimiento</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="propiedad_id" class="form-label">Propiedad</label>
                    <select class="form-select" id="propiedad_id" name="propiedad_id">
                        <option value="">Todas las propiedades</option>
                        <?php foreach ($propiedades as $prop): ?>
                            <option value="<?= $prop['id'] ?>" <?= $propiedad_id == $prop['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($prop['nombre']) ?> - <?= htmlspecialchars($prop['direccion']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-12 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                    <a href="gastos.php" class="btn btn-outline-secondary">Borrar Filtros</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de gastos -->
    <?php if (count($gastos) === 0): ?>
        <div class="alert alert-info">No hay gastos registrados.</div>
    <?php else: ?>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Listado de Gastos</h5>
                <div class="text-end">
                    <strong>Total: $<?= number_format($total_gastos, 2, ',', '.') ?></strong>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Concepto</th>
                                <th>Importe</th>
                                <th>Forma de Pago</th>
                                <th>Propiedad</th>
                                <th>Comprobante</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($gastos as $gasto): ?>
                                <tr>
                                    <td>
                                        <strong><?= date('d/m/Y', strtotime($gasto['fecha'])) ?></strong>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($gasto['concepto']) ?></strong>
                                        <?php if ($gasto['observaciones']): ?>
                                            <br><small class="text-muted"><?= htmlspecialchars($gasto['observaciones']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong class="text-danger">-$<?= number_format($gasto['importe'], 2, ',', '.') ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $gasto['forma_pago'] === 'Efectivo' ? 'success' : 'info' ?>">
                                            <?= htmlspecialchars($gasto['forma_pago']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($gasto['propiedad_nombre']): ?>
                                            <strong>
                                                <a href="propiedades.php?edit=<?= $gasto['propiedad_id'] ?>" class="text-decoration-none text-dark">
                                                    <?= htmlspecialchars($gasto['propiedad_nombre']) ?>
                                                </a>
                                            </strong>
                                            <br><small class="text-muted"><?= htmlspecialchars($gasto['propiedad_direccion']) ?></small>
                                        <?php else: ?>
                                            <small class="text-muted">Sin propiedad</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($gasto['comprobante']): ?>
                                            <a href="uploads/<?= htmlspecialchars($gasto['comprobante']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="Ver comprobante">
                                                Comprobante
                                            </a><br>
                                        <?php endif; ?>
                                        <small><?= htmlspecialchars($gasto['usuario_nombre'] ?? 'Usuario') ?></small><br>
                                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($gasto['fecha_creacion'])) ?></small>

                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                                <a href="gastos.php?edit=<?= $gasto['id'] ?>" class="btn btn-outline-primary" title="Editar">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="gastos.php?delete=<?= $gasto['id'] ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar este gasto?')">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>