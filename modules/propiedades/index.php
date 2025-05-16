<?php
require_once '../../config/database.php';

// Obtener todas las propiedades
$stmt = $conn->prepare("SELECT * FROM propiedades ORDER BY created_at DESC");
$stmt->execute();
$propiedades = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row mb-4">
    <div class="col">
        <h2>Propiedades</h2>
    </div>
    <div class="col text-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPropiedad">
            Nueva Propiedad
        </button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Dirección</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($propiedades as $propiedad): ?>
            <tr>
                <td><?php echo htmlspecialchars($propiedad['id']); ?></td>
                <td><?php echo htmlspecialchars($propiedad['direccion']); ?></td>
                <td><?php echo htmlspecialchars($propiedad['tipo']); ?></td>
                <td>$<?php echo number_format($propiedad['precio'], 2); ?></td>
                <td>
                    <span class="badge <?php echo $propiedad['estado'] == 'Disponible' ? 'bg-success' : 'bg-warning'; ?>">
                        <?php echo htmlspecialchars($propiedad['estado']); ?>
                    </span>
                </td>
                <td>
                    <button class="btn btn-sm btn-info" onclick="editarPropiedad(<?php echo $propiedad['id']; ?>)">
                        Editar
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="eliminarPropiedad(<?php echo $propiedad['id']; ?>)">
                        Eliminar
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal para Nueva/Editar Propiedad -->
<div class="modal fade" id="modalPropiedad" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Propiedad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formPropiedad">
                    <input type="hidden" id="propiedad_id" name="id">
                    
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo" required>
                            <option value="Departamento">Departamento</option>
                            <option value="Casa">Casa</option>
                            <option value="Local">Local</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="Disponible">Disponible</option>
                            <option value="Alquilado">Alquilado</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="caracteristicas" class="form-label">Características</label>
                        <textarea class="form-control" id="caracteristicas" name="caracteristicas" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarPropiedad()">Guardar</button>
            </div>
        </div>
    </div>
</div> 