<?php
// Habilitar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/error_log.php';
require_once '../../config/database.php';
require_once '../../config/helpers.php';

try {
    // Obtener todos los contratos con información relacionada
    $stmt = $conn->prepare("
        SELECT c.*, 
               p.direccion as propiedad_direccion,
               p.galeria,
               p.local,
               i.nombre as inquilino_nombre,
               i.documento as inquilino_dni
        FROM contratos c
        JOIN propiedades p ON c.propiedad_id = p.id
        JOIN inquilinos i ON c.inquilino_id = i.id
        ORDER BY c.fecha_inicio DESC
    ");
    $stmt->execute();
    $contratos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener propiedades disponibles
    $stmt = $conn->prepare("
        SELECT p.* 
        FROM propiedades p
        WHERE p.estado = 'Disponible' 
        OR p.id NOT IN (
            SELECT c.propiedad_id 
            FROM contratos c 
            WHERE c.estado = 'Activo'
            AND CURRENT_DATE BETWEEN c.fecha_inicio AND c.fecha_fin
        )
        ORDER BY p.galeria, p.local, p.direccion
    ");
    $stmt->execute();
    $propiedades = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener inquilinos
    $stmt = $conn->prepare("SELECT id, nombre, documento as dni FROM inquilinos ORDER BY nombre");
    $stmt->execute();
    $inquilinos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Registrar el error
    error_log("Error en contratos/index.php: " . $e->getMessage());
    // Mostrar mensaje de error
    echo "<div class='alert alert-danger'>
            <h4 class='alert-heading'>Error al cargar los contratos</h4>
            <p>Se produjo un error al cargar la información de contratos.</p>
            <hr>
            <p class='mb-0'>Error: " . htmlspecialchars($e->getMessage()) . "</p>
          </div>";
    exit;
}
?>

<style>
.cursor-pointer {
    cursor: pointer;
}
.cursor-pointer:hover {
    background-color: rgba(0,0,0,0.05);
}

/* Fix for modal stacking */
.modal {
    z-index: 1050 !important;
}
.modal-backdrop {
    z-index: 1040 !important;
}
.modal-backdrop + .modal-backdrop {
    z-index: 1041 !important;
}
.modal.show {
    z-index: 1042 !important;
}
#modalContrato.show {
    z-index: 1052 !important;
}
</style>

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
                <td><?php echo htmlspecialchars(getNombrePropiedad($contrato)); ?></td>
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
                                <?php echo htmlspecialchars(getNombrePropiedad($propiedad)); ?>
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

<script>
// Asegurarse de que las funciones estén disponibles globalmente
window.mostrarDetalleContrato = function(contrato) {
    window.currentContrato = contrato;
    
    // Actualizar la información del contrato
    const infoContrato = document.getElementById('info-contrato');
    infoContrato.innerHTML = `
        <p><strong>Propiedad:</strong> ${getNombrePropiedadJS(contrato)}</p>
        <p><strong>Inquilino:</strong> ${contrato.inquilino_nombre} (DNI: ${contrato.inquilino_dni})</p>
        <p><strong>Fecha Inicio:</strong> ${contrato.fecha_inicio}</p>
        <p><strong>Fecha Fin:</strong> ${contrato.fecha_fin}</p>
        <p><strong>Renta Mensual:</strong> $${parseFloat(contrato.renta_mensual).toFixed(2)}</p>
        <p><strong>Estado:</strong> <span class="badge ${contrato.estado === 'Activo' ? 'bg-success' : 'bg-secondary'}">${contrato.estado}</span></p>
    `;
    
    // Mostrar el modal de detalles
    const modalDetalles = new bootstrap.Modal(document.getElementById('modalDetallesContrato'));
    modalDetalles.show();
    
    // Cargar los pagos del contrato
    cargarPagosContrato(contrato.id);
};

window.editarContrato = function() {
    if (!window.currentContrato) return;
    
    // Llenar el formulario con los datos actuales
    document.getElementById('contrato_id').value = window.currentContrato.id;
    document.getElementById('propiedad_id').value = window.currentContrato.propiedad_id;
    document.getElementById('inquilino_id').value = window.currentContrato.inquilino_id;
    document.getElementById('fecha_inicio').value = window.currentContrato.fecha_inicio;
    document.getElementById('fecha_fin').value = window.currentContrato.fecha_fin;
    document.getElementById('renta_mensual').value = window.currentContrato.renta_mensual;
    document.getElementById('estado').value = window.currentContrato.estado;
    
    // Actualizar título y mostrar botón de eliminar
    document.querySelector('#modalContrato .modal-title').textContent = 'Editar Contrato';
    document.querySelector('#modalContrato .btn-danger').classList.remove('d-none');
    
    // Cerrar el modal de detalles antes de abrir el de edición
    const modalDetalles = bootstrap.Modal.getInstance(document.getElementById('modalDetallesContrato'));
    if (modalDetalles) {
        modalDetalles.hide();
    }
    
    // Mostrar el modal de edición
    const modalEditar = new bootstrap.Modal(document.getElementById('modalContrato'));
    modalEditar.show();
};

window.nuevoContrato = function() {
    // Limpiar el formulario
    document.getElementById('formContrato').reset();
    document.getElementById('contrato_id').value = '';
    
    // Actualizar título y ocultar botón de eliminar
    document.querySelector('#modalContrato .modal-title').textContent = 'Nuevo Contrato';
    document.querySelector('#modalContrato .btn-danger').classList.add('d-none');
    
    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalContrato'));
    modal.show();
};

function guardarContrato() {
    const formData = new FormData(document.getElementById('formContrato'));
    formData.append('action', formData.get('id') ? 'update' : 'create');
    
    fetch('modules/contratos/actions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar el modal y recargar la página
            bootstrap.Modal.getInstance(document.getElementById('modalContrato')).hide();
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar el contrato');
    });
}

function eliminarContrato() {
    if (!confirm('¿Está seguro de que desea eliminar este contrato?')) return;
    
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('id', document.getElementById('contrato_id').value);
    
    fetch('modules/contratos/actions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar los modales y recargar la página
            bootstrap.Modal.getInstance(document.getElementById('modalContrato')).hide();
            bootstrap.Modal.getInstance(document.getElementById('modalDetallesContrato')).hide();
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar el contrato');
    });
}

function cargarPagosContrato(contratoId) {
    const formData = new FormData();
    formData.append('action', 'get_pagos');
    formData.append('id', contratoId);
    
    fetch('modules/contratos/actions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarPagosContrato(data.data);
        } else {
            document.getElementById('lista-pagos-contrato').innerHTML = 
                '<div class="alert alert-warning">No se pudieron cargar los pagos</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('lista-pagos-contrato').innerHTML = 
            '<div class="alert alert-danger">Error al cargar los pagos</div>';
    });
}

function mostrarPagosContrato(pagos) {
    const listaPagos = document.getElementById('lista-pagos-contrato');
    if (!pagos || pagos.length === 0) {
        listaPagos.innerHTML = '<div class="alert alert-info">No hay pagos registrados</div>';
        return;
    }
    
    let html = '<div class="table-responsive"><table class="table table-sm">';
    html += '<thead><tr><th>Fecha</th><th>Monto</th><th>Estado</th></tr></thead><tbody>';
    
    pagos.forEach(pago => {
        const estado = pago.estado === 'Pagado' ? 'success' : 'warning';
        html += `
            <tr>
                <td>${pago.fecha_vencimiento}</td>
                <td>$${parseFloat(pago.monto).toFixed(2)}</td>
                <td><span class="badge bg-${estado}">${pago.estado}</span></td>
            </tr>
        `;
    });
    
    html += '</tbody></table></div>';
    listaPagos.innerHTML = html;
}

// Inicializar los event listeners cuando se carga el módulo
document.addEventListener('DOMContentLoaded', function() {
    const modalContrato = document.getElementById('modalContrato');
    const modalDetalles = document.getElementById('modalDetallesContrato');
    
    if (modalDetalles) {
        modalDetalles.addEventListener('hidden.bs.modal', function() {
            window.currentContrato = null;
            // Remover cualquier backdrop extra
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach((backdrop, index) => {
                if (index > 0) backdrop.remove();
            });
        });
    }
    
    if (modalContrato) {
        modalContrato.addEventListener('hidden.bs.modal', function() {
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach((backdrop, index) => {
                if (index > 0) backdrop.remove();
            });
        });
    }
});

// Add the JavaScript version of getNombrePropiedad
function getNombrePropiedadJS(propiedad) {
    const partes = [];
    
    if (propiedad.galeria) {
        partes.push(`Galería ${propiedad.galeria}`);
    }
    
    if (propiedad.local) {
        partes.push(`Local ${propiedad.local}`);
    }
    
    if (propiedad.direccion) {
        partes.push(propiedad.direccion);
    }
    
    return partes.join(' - ');
}
</script> 