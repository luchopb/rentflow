<?php
require_once '../../config/database.php';

// Obtener todos los contratos con información relacionada
$stmt = $conn->prepare("
    SELECT c.*, 
           p.direccion as propiedad_direccion,
           i.nombre as inquilino_nombre,
           i.dni as inquilino_dni
    FROM contratos c
    JOIN propiedades p ON c.propiedad_id = p.id
    JOIN inquilinos i ON c.inquilino_id = i.id
    ORDER BY c.fecha_inicio DESC
");
$stmt->execute();
$contratos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener propiedades disponibles
$stmt = $conn->prepare("SELECT id, direccion FROM propiedades WHERE estado = 'Disponible' OR id IN (SELECT propiedad_id FROM contratos)");
$stmt->execute();
$propiedades = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener inquilinos
$stmt = $conn->prepare("SELECT id, nombre, dni FROM inquilinos");
$stmt->execute();
$inquilinos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row mb-4">
    <div class="col">
        <h2>Contratos</h2>
    </div>
    <div class="col text-end">
        <button type="button" class="btn btn-primary" onclick="nuevoContrato()">
            Nuevo Contrato
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
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Renta Mensual</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contratos as $contrato): ?>
            <tr class="cursor-pointer" onclick='mostrarDetalleContrato(<?php echo json_encode($contrato); ?>)'>
                <td><?php echo htmlspecialchars($contrato['id']); ?></td>
                <td><?php echo htmlspecialchars($contrato['propiedad_direccion']); ?></td>
                <td>
                    <?php echo htmlspecialchars($contrato['inquilino_nombre']); ?>
                    <br>
                    <small class="text-muted">DNI: <?php echo htmlspecialchars($contrato['inquilino_dni']); ?></small>
                </td>
                <td><?php echo htmlspecialchars($contrato['fecha_inicio']); ?></td>
                <td><?php echo htmlspecialchars($contrato['fecha_fin']); ?></td>
                <td>$<?php echo number_format($contrato['renta_mensual'], 2); ?></td>
                <td>
                    <span class="badge <?php echo $contrato['estado'] == 'Activo' ? 'bg-success' : 'bg-secondary'; ?>">
                        <?php echo htmlspecialchars($contrato['estado']); ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal para Nuevo/Editar Contrato -->
<div class="modal fade" id="modalContrato" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Contrato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formContrato">
                    <input type="hidden" id="contrato_id" name="id">
                    
                    <div class="mb-3">
                        <label for="propiedad_id" class="form-label">Propiedad</label>
                        <select class="form-select" id="propiedad_id" name="propiedad_id" required>
                            <option value="">Seleccione una propiedad</option>
                            <?php foreach ($propiedades as $propiedad): ?>
                            <option value="<?php echo $propiedad['id']; ?>">
                                <?php echo htmlspecialchars($propiedad['direccion']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="inquilino_id" class="form-label">Inquilino</label>
                        <select class="form-select" id="inquilino_id" name="inquilino_id" required>
                            <option value="">Seleccione un inquilino</option>
                            <?php foreach ($inquilinos as $inquilino): ?>
                            <option value="<?php echo $inquilino['id']; ?>">
                                <?php echo htmlspecialchars($inquilino['nombre'] . ' (DNI: ' . $inquilino['dni'] . ')'); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="fecha_fin" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="renta_mensual" class="form-label">Renta Mensual</label>
                        <input type="number" class="form-control" id="renta_mensual" name="renta_mensual" step="0.01" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="Activo">Activo</option>
                            <option value="Finalizado">Finalizado</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger me-auto d-none" onclick="eliminarContrato()">Eliminar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarContrato()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Detalles del Contrato -->
<div class="modal fade" id="modalDetallesContrato" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del Contrato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col">
                        <h6>Información del Contrato</h6>
                        <div id="info-contrato" class="mb-4"></div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="editarContrato()">
                            Editar Contrato
                        </button>
                    </div>
                </div>
                <h6>Pagos del Contrato</h6>
                <div id="lista-pagos-contrato"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger me-auto" onclick="eliminarContrato()">Eliminar Contrato</button>
                <button type="button" class="btn btn-primary" onclick="registrarPagoContrato()">Registrar Pago</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div> 