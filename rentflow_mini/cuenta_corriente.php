<?php
// Incluir cabecera y conexión
include 'config.php';

// --- Lógica para insertar arqueo de caja ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fecha_arqueo'], $_POST['tipo_arqueo'], $_POST['importe'], $_POST['tipo_pago'])) {
    $fecha = $_POST['fecha_arqueo'];
    $tipo_arqueo = $_POST['tipo_arqueo'];
    $importe = floatval($_POST['importe']);
    $tipo_pago = $_POST['tipo_pago'];
    $usuario_id = 1; // Puedes cambiar esto por el usuario logueado si lo tienes
    $comprobante = null;
    $comentario = $_POST['comentario'];
    $fecha_creacion = date('Y-m-d H:i:s');

    if ($tipo_arqueo === 'sumar') {
        // Insertar como pago
        $concepto = 'Arqueo de Caja (suma)';
        $sql = "INSERT INTO pagos (fecha, concepto, tipo_pago, importe, comentario, comprobante, pagado, validado, usuario_id, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?, 1, 0, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$fecha, $concepto, $tipo_pago, $importe, $comentario, $comprobante, $usuario_id, $fecha_creacion]);
    } else {
        // Insertar como gasto
        $concepto = 'Arqueo de Caja (resta)';
        $sql = "INSERT INTO gastos (fecha, concepto, importe, forma_pago, observaciones, comprobante, usuario_id, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$fecha, $concepto, $importe, $tipo_pago, $comentario, $comprobante, $usuario_id, $fecha_creacion]);
    }
    // Redirigir para evitar reenvío del formulario
    header('Location: cuenta_corriente.php');
    exit;
}

// --- Consultar propietarios para el filtro ---
$propietarios = $pdo->query("SELECT id, nombre FROM propietarios ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);

// --- Filtros ---
$propietario_id = isset($_GET['propietario_id']) ? intval($_GET['propietario_id']) : 1;
$fecha_inicio = isset($_GET['fecha_inicio']) && $_GET['fecha_inicio'] ? $_GET['fecha_inicio'] : '2025-01-01';
$fecha_fin = isset($_GET['fecha_fin']) && $_GET['fecha_fin'] ? $_GET['fecha_fin'] : date('Y-m-d');
$filtro_tipo_pago = isset($_GET['filtro_tipo_pago']) ? $_GET['filtro_tipo_pago'] : 'Efectivo';
$filtro_validado = isset($_GET['filtro_validado']) ? $_GET['filtro_validado'] : '';

// --- Consulta de pagos ---
// Levantar también el nombre del inquilino (alias: nombre_inquilino)
$query_pagos = "SELECT 
    p.id AS pago_id,
    p.fecha, 
    p.concepto, 
    p.tipo_pago AS forma_pago, 
    p.comprobante, 
    p.importe, 
    'pago' AS tipo, 
    comentario, 
    pr.nombre AS propiedad, 
    pr.id AS propiedad_id,
    i.nombre AS nombre_inquilino,
    validado
FROM pagos p
LEFT JOIN contratos c ON p.contrato_id = c.id
LEFT JOIN propiedades pr ON c.propiedad_id = pr.id
LEFT JOIN inquilinos i ON c.inquilino_id = i.id
WHERE 1=1";


// --- Consulta de gastos ---
// Levantar también el nombre del inquilino (alias: nombre_inquilino)
$query_gastos = "SELECT 
    g.id AS gasto_id,
    g.fecha, 
    g.concepto, 
    g.forma_pago, 
    g.comprobante, 
    g.importe, 
    'gasto' AS tipo, 
    observaciones AS comentario, 
    pr.nombre AS propiedad, 
    pr.id AS propiedad_id,
    i.nombre AS nombre_inquilino,
    validado
FROM gastos g
LEFT JOIN propiedades pr ON g.propiedad_id = pr.id
LEFT JOIN contratos c ON c.propiedad_id = pr.id
    AND g.fecha BETWEEN c.fecha_inicio AND c.fecha_fin
LEFT JOIN inquilinos i ON c.inquilino_id = i.id
WHERE 1=1";


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
    $propietario_todos = "";
    $propietario_todos_gastos = "";
    if ($propietario_id === 1) {
        // Si filtro por propietario id 1 (todos) agrego los pagos y gastos sin propíetario y de 
        $propietario_todos = " OR pr.propietario_id = 2 OR pr.propietario_id = 9 OR pr.propietario_id IS NULL";
        // para los gastos agrego los gastos de todos porque salen de nuestra cuenta 
        $propietario_todos_gastos = " OR pr.propietario_id = 2 OR pr.propietario_id = 5 OR pr.propietario_id = 6 OR pr.propietario_id = 9 OR pr.propietario_id IS NULL";
    }
    $query_gastos .= " AND (pr.propietario_id = ? $propietario_todos_gastos )";
    $query_pagos .= " AND (pr.propietario_id = ? $propietario_todos )";
    $params[] = $propietario_id;
    $types .= 'i';
}
if ($filtro_validado !== '') {
    $query_gastos .= " AND g.validado = ?";
    $query_pagos .= " AND p.validado = ?";
    $params[] = $filtro_validado === '1' ? 1 : 0;
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

include 'includes/header_nav.php';
?>


<div class="container mt-4">
    <h2>Cuenta Corriente</h2>

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
                <div class="col-md-3">
                    <label for="filtro_validado">Estado de Validación:</label>
                    <select class="form-control" name="filtro_validado">
                        <option value="" <?php if ($filtro_validado === '') echo 'selected'; ?>>Todos</option>
                        <option value="1" <?php if ($filtro_validado === '1') echo 'selected'; ?>>Validados</option>
                        <option value="0" <?php if ($filtro_validado === '0') echo 'selected'; ?>>Pendientes</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Aplicar filtros</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Saldo final: $<?php echo number_format($saldo, 2, ',', '.'); ?></h3>
            <button class="btn btn-success" onclick="exportarCuentaCorriente()">
                <i class="bi bi-file-excel"></i> Exportar a Excel
            </button>
        </div>
        <!-- Tabla de cuenta corriente -->
        <table class="table table-bordered table-sm table-hover tabla-cuentacorriente" id="tabla_cuenta_corriente">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Detalle</th>
                    <th>Tipo de pago</th>
                    <th>Ingreso</th>
                    <th>Egreso</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movimientos as $mov): ?>
                    <tr class="<?php 
                        if ($mov['concepto'] === 'Arqueo de Caja (suma)') {
                            echo 'table-success';
                        } elseif ($mov['concepto'] === 'Arqueo de Caja (resta)') {
                            echo 'table-danger';
                        }
                    ?>">
                        <td><?php echo htmlspecialchars($mov['fecha']); ?></td>
                        <td>
                            <div class="d-flex align-items-center mb-2">
                                <?php if ($mov['tipo'] == 'pago'): ?>
                                    <input type="checkbox" 
                                           class="form-check-input checkbox-validacion-pago" 
                                           id="validado_pago_<?php echo $mov['pago_id']; ?>"
                                           data-pago-id="<?php echo $mov['pago_id']; ?>"
                                           <?php echo $mov['validado'] ? 'checked' : ''; ?>>
                                    <label for="validado_pago_<?php echo $mov['pago_id']; ?>" class="form-check-label ms-2">
                                        <?php if ($mov['validado'] == 1): ?>
                                            <small class="text-success">
                                                <i class="bi bi-check-circle-fill"></i> Validado
                                            </small>
                                        <?php else: ?>
                                            <small class="text-muted">Pendiente</small>
                                        <?php endif; ?>
                                    </label>
                                <?php else: ?>
                                    <input type="checkbox" 
                                           class="form-check-input checkbox-validacion-gasto" 
                                           id="validado_gasto_<?php echo $mov['gasto_id']; ?>"
                                           data-gasto-id="<?php echo $mov['gasto_id']; ?>"
                                           <?php echo $mov['validado'] ? 'checked' : ''; ?>>
                                    <label for="validado_gasto_<?php echo $mov['gasto_id']; ?>" class="form-check-label ms-2">
                                        <?php if ($mov['validado'] == 1): ?>
                                            <small class="text-success">
                                                <i class="bi bi-check-circle-fill"></i> Validado
                                            </small>
                                        <?php else: ?>
                                            <small class="text-muted">Pendiente</small>
                                        <?php endif; ?>
                                    </label>
                                <?php endif; ?>
                            </div>
                            <?php if (!is_null($mov['propiedad'])): ?>
                                <a href="propiedades.php?edit=<?= $mov['propiedad_id'] ?>" class="text-decoration-none text-dark">
                                    <strong><?php echo htmlspecialchars($mov['propiedad']); ?></strong>
                                </a>
                            <?php endif; ?>
                            <?php if (!is_null($mov['nombre_inquilino'])): ?>
                                <strong><?php echo htmlspecialchars($mov['nombre_inquilino']); ?></strong><br>
                            <?php endif; ?>
                            <?php echo htmlspecialchars($mov['concepto']); ?>
                            <?php if (!is_null($mov['comentario']) && $mov['comentario'] !== ''): ?>
                                <?php
                                $comentario = htmlspecialchars($mov['comentario']);
                                if (mb_strlen($comentario) > 120) {
                                    $comentario = mb_substr($comentario, 0, 120) . '...';
                                }
                                ?>
                                <small><?php echo $comentario; ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($mov['comprobante'])): ?>
                                <a href="uploads/<?php echo ($mov['comprobante']); ?>" target="_blank" class="badge bg-info">
                                    Comprobante
                                </a>
                            <?php else: ?>
                                <small class="badge bg-secondary">Sin comprobante</small>
                            <?php endif; ?><br>
                            <?php echo htmlspecialchars($mov['forma_pago']); ?>
                        </td>
                        <td class="text-success fw-bold"><?php echo $mov['credito'] ? number_format($mov['credito'], 2, ',', '.') : ''; ?></td>
                        <td class="text-danger fw-bold"><?php echo $mov['debito'] ? '-' . number_format($mov['debito'], 2, ',', '.') : ''; ?></td>
                        <td><?php echo number_format($mov['saldo'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Saldo final: $<?php echo number_format($saldo, 2, ',', '.'); ?></h3>
    </div>
</div>


<div class="container mt-4 mb-4">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Arqueo de Caja</h5>
        </div>
        <div class="card-body">
            <form method="post" action="">
                <div class="row mb-2">
                    <div class="col-md-2">
                        <label for="fecha_arqueo">Fecha:</label>
                        <input type="date" class="form-control" name="fecha_arqueo" required>
                    </div>
                    <div class="col-md-2">
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
                    <div class="col-md-2">
                        <label for="importe">Importe $:</label>
                        <input type="number" step="0.01" class="form-control" name="importe" required>
                    </div>
                    <div class="col-md-3">
                        <label for="tipo_pago">Tipo de Pago:</label>
                        <select class="form-control" name="tipo_pago" required>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Transferencia">Transferencia</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="importe">Comentario:</label>
                        <input type="text" class="form-control" name="comentario" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Agregar Arqueo</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Manejar cambios en los checkboxes de validación de pagos
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxesValidacionPago = document.querySelectorAll('.checkbox-validacion-pago');
        checkboxesValidacionPago.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const pagoId = this.getAttribute('data-pago-id');
                const validado = this.checked;
                this.disabled = true;
                validarPago(pagoId, validado);
                setTimeout(() => {
                    this.disabled = false;
                }, 1000);
            });
        });

        // Manejar cambios en los checkboxes de validación de gastos
        const checkboxesValidacionGasto = document.querySelectorAll('.checkbox-validacion-gasto');
        checkboxesValidacionGasto.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const gastoId = this.getAttribute('data-gasto-id');
                const validado = this.checked;
                this.disabled = true;
                validarGasto(gastoId, validado);
                setTimeout(() => {
                    this.disabled = false;
                }, 1000);
            });
        });
    });

    // Función para validar/desvalidar pagos
    function validarPago(pagoId, validado) {
        const formData = new FormData();
        formData.append('pago_id', pagoId);
        formData.append('validado', validado);

        fetch('validar_pago.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar mensaje de éxito
                    const mensaje = document.createElement('div');
                    mensaje.className = 'alert alert-success alert-dismissible fade show position-fixed';
                    mensaje.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                    mensaje.innerHTML = `
                    ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                    document.body.appendChild(mensaje);

                    // Remover el mensaje después de 3 segundos
                    setTimeout(() => {
                        mensaje.remove();
                    }, 3000);

                    // Actualizar la etiqueta del checkbox
                    const checkbox = document.getElementById(`validado_pago_${pagoId}`);
                    const label = checkbox.nextElementSibling;

                    if (validado) {
                        label.innerHTML = `
                        <small class="text-success">
                            <i class="bi bi-check-circle-fill"></i> Validado
                            <br><small>${data.fecha_validacion ? new Date(data.fecha_validacion).toLocaleString('es-ES', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            }) : ''}</small>
                        </small>
                    `;
                    } else {
                        label.innerHTML = '<small class="text-muted">Pendiente</small>';
                    }
                } else {
                    // Mostrar mensaje de error
                    const mensaje = document.createElement('div');
                    mensaje.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                    mensaje.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                    mensaje.innerHTML = `
                    Error: ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                    document.body.appendChild(mensaje);

                    // Remover el mensaje después de 5 segundos
                    setTimeout(() => {
                        mensaje.remove();
                    }, 5000);

                    // Revertir el checkbox
                    const checkbox = document.getElementById(`validado_pago_${pagoId}`);
                    checkbox.checked = !validado;
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // Mostrar mensaje de error
                const mensaje = document.createElement('div');
                mensaje.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                mensaje.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                mensaje.innerHTML = `
                Error de conexión. Intente nuevamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
                document.body.appendChild(mensaje);

                // Remover el mensaje después de 5 segundos
                setTimeout(() => {
                    mensaje.remove();
                }, 5000);

                // Revertir el checkbox
                const checkbox = document.getElementById(`validado_pago_${pagoId}`);
                checkbox.checked = !validado;
            });
    }

    // Función para validar/desvalidar gastos
    function validarGasto(gastoId, validado) {
        const formData = new FormData();
        formData.append('gasto_id', gastoId);
        formData.append('validado', validado);
        fetch('validar_gasto.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const mensaje = document.createElement('div');
                    mensaje.className = 'alert alert-success alert-dismissible fade show position-fixed';
                    mensaje.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                    mensaje.innerHTML = `
                    ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                    document.body.appendChild(mensaje);
                    setTimeout(() => {
                        mensaje.remove();
                    }, 3000);
                    const checkbox = document.getElementById(`validado_gasto_${gastoId}`);
                    const label = checkbox.nextElementSibling;
                    if (validado) {
                        label.innerHTML = `
                        <small class="text-success">
                            <i class="bi bi-check-circle-fill"></i> Validado
                            <br><small>${data.fecha_validacion ? new Date(data.fecha_validacion).toLocaleString('es-ES', {
                                day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit'
                            }) : ''}</small>
                        </small>
                    `;
                    } else {
                        label.innerHTML = '<small class="text-muted">Pendiente</small>';
                    }
                } else {
                    const mensaje = document.createElement('div');
                    mensaje.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                    mensaje.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                    mensaje.innerHTML = `
                    Error: ${data.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                    document.body.appendChild(mensaje);
                    setTimeout(() => {
                        mensaje.remove();
                    }, 5000);
                    const checkbox = document.getElementById(`validado_gasto_${gastoId}`);
                    checkbox.checked = !validado;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                const mensaje = document.createElement('div');
                mensaje.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                mensaje.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                mensaje.innerHTML = `
                Error de conexión. Intente nuevamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
                document.body.appendChild(mensaje);
                setTimeout(() => {
                    mensaje.remove();
                }, 5000);
                const checkbox = document.getElementById(`validado_gasto_${gastoId}`);
                checkbox.checked = !validado;
            });
    }

    // Función para exportar la cuenta corriente a Excel
    function exportarCuentaCorriente() {
        const tabla = document.getElementById('tabla_cuenta_corriente');
        const fechaFin = document.querySelector('input[name="fecha_fin"]').value;
        const propietarioSelect = document.querySelector('select[name="propietario_id"]');
        const propietarioNombre = propietarioSelect.options[propietarioSelect.selectedIndex].text;
        const tipoPagoSelect = document.querySelector('select[name="filtro_tipo_pago"]');
        const tipoPago = tipoPagoSelect.options[tipoPagoSelect.selectedIndex].text;
        
        // Crear nombre de archivo con formato: CC_tipodepago_propietario_hasta_fecha_hoy
        let nombreArchivo = 'CC';
        
        // Agregar tipo de pago
        if (tipoPago && tipoPago !== 'Todos') {
            nombreArchivo += `_${tipoPago}`;
        } else {
            nombreArchivo += '_Todos';
        }
        
        // Agregar propietario
        if (propietarioNombre && propietarioNombre !== 'Todos') {
            nombreArchivo += `_${propietarioNombre.replace(/\s+/g, '_')}`;
        } else {
            nombreArchivo += '_Todos';
        }
        
        // Agregar fecha hasta
        if (fechaFin) {
            nombreArchivo += `_hasta_${fechaFin}`;
        }
        
        // Agregar fecha de hoy
        const fechaHoy = new Date().toISOString().slice(0, 10);
        nombreArchivo += `_${fechaHoy}`;
        
        exportarTablaAExcel(tabla, nombreArchivo);
    }

    // Función genérica para exportar tabla a Excel
    function exportarTablaAExcel(tabla, nombreArchivo = '') {
        const tipoDatos = 'application/vnd.ms-excel';
        const htmlTabla = tabla.outerHTML;
        const nombreArchivoFinal = nombreArchivo ? nombreArchivo + '.xls' : 'excel_data.xls';
        const utf8BOM = '\uFEFF';
        const blob = new Blob([utf8BOM + htmlTabla], { type: tipoDatos });
        const enlaceDescarga = document.createElement('a');
        enlaceDescarga.href = URL.createObjectURL(blob);
        enlaceDescarga.download = nombreArchivoFinal;
        document.body.appendChild(enlaceDescarga);
        enlaceDescarga.click();
        document.body.removeChild(enlaceDescarga);
    }
</script>

<?php
// Incluir pie de página
include 'includes/footer.php';
