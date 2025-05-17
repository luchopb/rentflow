<?php
require_once '../../config/database.php';

// Obtener todos los pagos con información relacionada
$stmt = $conn->prepare("
    SELECT p.*,
           c.renta_mensual,
           pr.direccion as propiedad_direccion,
           i.nombre as inquilino_nombre,
           i.dni as inquilino_dni
    FROM pagos p
    JOIN contratos c ON p.contrato_id = c.id
    JOIN propiedades pr ON c.propiedad_id = pr.id
    JOIN inquilinos i ON c.inquilino_id = i.id
    ORDER BY p.fecha_vencimiento DESC
");
$stmt->execute();
$pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener contratos activos para el formulario de nuevo pago
$stmt = $conn->prepare("
    SELECT c.id, c.renta_mensual, 
           p.direccion as propiedad_direccion,
           i.nombre as inquilino_nombre,
           i.dni as inquilino_dni
    FROM contratos c
    JOIN propiedades p ON c.propiedad_id = p.id
    JOIN inquilinos i ON c.inquilino_id = i.id
    WHERE c.estado = 'Activo'
    ORDER BY p.direccion ASC
");
$stmt->execute();
$contratos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row mb-4">
    <div class="col">
        <h2>Pagos</h2>
    </div>
    <div class="col text-end">
        <button type="button" class="btn btn-primary" onclick="nuevoPago()">
            Nuevo Pago
        </button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Propiedad</th>
                <th>Inquilino</th>
                <th>Vencimiento</th>
                <th>Monto</th>
                <th>Fecha Pago</th>
                <th>Monto Pagado</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pagos as $pago): ?>
            <tr class="cursor-pointer" onclick='mostrarDetallePago(<?php echo json_encode($pago); ?>)'>
                <td><?php echo htmlspecialchars($pago['id']); ?></td>
                <td><?php echo htmlspecialchars($pago['propiedad_direccion']); ?></td>
                <td>
                    <?php echo htmlspecialchars($pago['inquilino_nombre']); ?>
                    <br>
                    <small class="text-muted">DNI: <?php echo htmlspecialchars($pago['inquilino_dni']); ?></small>
                </td>
                <td><?php echo htmlspecialchars($pago['fecha_vencimiento']); ?></td>
                <td>$<?php echo number_format($pago['monto'], 2); ?></td>
                <td><?php echo $pago['fecha_pago'] ? htmlspecialchars($pago['fecha_pago']) : '-'; ?></td>
                <td>$<?php echo $pago['monto_pagado'] ? number_format($pago['monto_pagado'], 2) : '-'; ?></td>
                <td>
                    <span class="badge <?php 
                        echo $pago['estado'] == 'Pagado' ? 'bg-success' : 
                            ($pago['estado'] == 'Vencido' ? 'bg-danger' : 'bg-warning'); 
                    ?>">
                        <?php echo htmlspecialchars($pago['estado']); ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal para Nuevo/Editar Pago -->
<div class="modal fade" id="modalPago" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formPago">
                    <input type="hidden" id="pago_id" name="id">
                    
                    <div class="mb-3">
                        <label for="contrato_id" class="form-label">Contrato</label>
                        <select class="form-select" id="contrato_id" name="contrato_id" required>
                            <option value="">Seleccione un contrato</option>
                            <?php foreach ($contratos as $contrato): ?>
                            <option value="<?php echo $contrato['id']; ?>" data-renta="<?php echo $contrato['renta_mensual']; ?>">
                                <?php echo htmlspecialchars($contrato['propiedad_direccion'] . ' - ' . $contrato['inquilino_nombre'] . ' (DNI: ' . $contrato['inquilino_dni'] . ')'); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto</label>
                        <input type="number" class="form-control" id="monto" name="monto" step="0.01" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                        <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" required value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="monto_pagado" class="form-label">Monto Pagado</label>
                        <input type="number" class="form-control" id="monto_pagado" name="monto_pagado" step="0.01" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger me-auto d-none" onclick="eliminarPago()">Eliminar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarPago()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Detalles del Pago -->
<div class="modal fade" id="modalDetallePago" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col">
                        <h6>Información del Pago</h6>
                        <div id="info-pago" class="mb-4"></div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="editarPago()">
                            Editar Pago
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger me-auto" onclick="eliminarPago()">Eliminar Pago</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div> 