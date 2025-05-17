<?php
require_once '../../config/database.php';

// Obtener todos los inquilinos
$stmt = $conn->prepare("SELECT * FROM inquilinos ORDER BY created_at DESC");
$stmt->execute();
$inquilinos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row mb-4">
    <div class="col">
        <h2>Inquilinos</h2>
    </div>
    <div class="col text-end">
        <button type="button" class="btn btn-primary" onclick="nuevoInquilino()">
            Nuevo Inquilino
        </button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Email</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inquilinos as $inquilino): ?>
            <tr class="cursor-pointer" onclick='mostrarDetalleInquilino(<?php echo json_encode($inquilino); ?>)'>
                <td><?php echo htmlspecialchars($inquilino['id']); ?></td>
                <td><?php echo htmlspecialchars($inquilino['nombre']); ?></td>
                <td><?php echo htmlspecialchars($inquilino['dni']); ?></td>
                <td><?php echo htmlspecialchars($inquilino['email']); ?></td>
                <td><?php echo htmlspecialchars($inquilino['telefono']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal para Nuevo/Editar Inquilino -->
<div class="modal fade" id="modalInquilino" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Inquilino</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formInquilino">
                    <input type="hidden" id="inquilino_id" name="id">
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="dni" class="form-label">DNI</label>
                        <input type="text" class="form-control" id="dni" name="dni" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger me-auto d-none" onclick="eliminarInquilino()">Eliminar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarInquilino()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Detalles del Inquilino -->
<div class="modal fade" id="modalDetallesInquilino" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del Inquilino</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col">
                        <h6>Información Personal</h6>
                        <div id="info-inquilino" class="mb-4"></div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="editarInquilino()">
                            Editar Información
                        </button>
                    </div>
                </div>
                <ul class="nav nav-tabs" id="detallesTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="contratos-tab" data-bs-toggle="tab" href="#contratos" role="tab">
                            Contratos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pagos-tab" data-bs-toggle="tab" href="#pagos" role="tab">
                            Historial de Pagos
                        </a>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="detallesTabContent">
                    <div class="tab-pane fade show active" id="contratos" role="tabpanel">
                        <div id="lista-contratos"></div>
                    </div>
                    <div class="tab-pane fade" id="pagos" role="tabpanel">
                        <div id="lista-pagos"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger me-auto" onclick="eliminarInquilino()">Eliminar Inquilino</button>
                <button type="button" class="btn btn-primary" onclick="nuevoContrato()">Nuevo Contrato</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div> 