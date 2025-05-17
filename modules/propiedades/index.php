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
        <button type="button" class="btn btn-primary" onclick="nuevaPropiedad()">
            Nueva Propiedad
        </button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Dirección</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($propiedades as $propiedad): ?>
            <tr class="cursor-pointer" onclick='mostrarDetallePropiedad(<?php echo json_encode($propiedad); ?>)'>
                <td><?php echo htmlspecialchars($propiedad['id']); ?></td>
                <td><?php echo htmlspecialchars($propiedad['direccion']); ?></td>
                <td><?php echo htmlspecialchars($propiedad['tipo']); ?></td>
                <td>$<?php echo number_format($propiedad['precio'], 2); ?></td>
                <td>
                    <span class="badge <?php echo $propiedad['estado'] == 'Disponible' ? 'bg-success' : 'bg-warning'; ?>">
                        <?php echo htmlspecialchars($propiedad['estado']); ?>
                    </span>
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
                <h5 class="modal-title">Detalles de la Propiedad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formPropiedad">
                    <input type="hidden" id="propiedad_id" name="id">
                    
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo" required onchange="mostrarOcultarCamposLocal()">
                            <option value="Departamento">Departamento</option>
                            <option value="Casa">Casa</option>
                            <option value="Local">Local</option>
                        </select>
                    </div>

                    <div id="camposLocal" style="display:none">
                        <div class="mb-3">
                            <label for="galeria" class="form-label">Galería</label>
                            <input type="text" class="form-control" id="galeria" name="galeria" placeholder="Nombre de la galería">
                        </div>
                        
                        <div class="mb-3">
                            <label for="local" class="form-label">Local</label>
                            <input type="text" class="form-control" id="local" name="local" placeholder="Número de local">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
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
                <button type="button" class="btn btn-danger me-auto" onclick="eliminarPropiedad()">Eliminar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarPropiedad()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<style>
.cursor-pointer {
    cursor: pointer;
}
.cursor-pointer:hover {
    background-color: rgba(0,0,0,0.05);
}
</style>

<script>
// Función simple para mostrar/ocultar campos de Local
function mostrarOcultarCamposLocal() {
    const tipo = document.getElementById('tipo').value;
    const camposLocal = document.getElementById('camposLocal');
    camposLocal.style.display = tipo === 'Local' ? 'block' : 'none';
}

function nuevaPropiedad() {
    // Limpiar el formulario
    document.getElementById('formPropiedad').reset();
    document.getElementById('propiedad_id').value = '';
    document.querySelector('#modalPropiedad .modal-title').textContent = 'Nueva Propiedad';
    document.querySelector('#modalPropiedad .btn-danger').style.display = 'none';
    
    // Mostrar el modal
    new bootstrap.Modal(document.getElementById('modalPropiedad')).show();
    
    // Verificar campos Local
    mostrarOcultarCamposLocal();
}

function mostrarDetallePropiedad(propiedad) {
    // Llenar el formulario con los datos de la propiedad
    document.getElementById('propiedad_id').value = propiedad.id;
    document.getElementById('direccion').value = propiedad.direccion;
    document.getElementById('tipo').value = propiedad.tipo;
    document.getElementById('precio').value = propiedad.precio;
    document.getElementById('estado').value = propiedad.estado;
    document.getElementById('caracteristicas').value = propiedad.caracteristicas || '';
    document.getElementById('galeria').value = propiedad.galeria || '';
    document.getElementById('local').value = propiedad.local || '';
    
    // Actualizar título y mostrar botón de eliminar
    document.querySelector('#modalPropiedad .modal-title').textContent = 'Detalles de la Propiedad';
    document.querySelector('#modalPropiedad .btn-danger').style.display = 'block';
    
    // Mostrar el modal
    new bootstrap.Modal(document.getElementById('modalPropiedad')).show();
    
    // Verificar campos Local
    mostrarOcultarCamposLocal();
}

// Asegurarse de que los campos se actualicen cuando se abre el modal
document.getElementById('modalPropiedad').addEventListener('shown.bs.modal', mostrarOcultarCamposLocal);
</script> 