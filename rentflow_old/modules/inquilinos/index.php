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
                <th>Documento</th>
                <th>Email</th>
                <th>Teléfono</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inquilinos as $inquilino): ?>
            <tr class="cursor-pointer" onclick='mostrarDetalleInquilino(<?php echo json_encode($inquilino); ?>)'>
                <td><?php echo htmlspecialchars($inquilino['id']); ?></td>
                <td><?php echo htmlspecialchars($inquilino['nombre']); ?></td>
                <td><?php echo htmlspecialchars($inquilino['documento']); ?></td>
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
                        <label for="documento" class="form-label">Documento</label>
                        <input type="text" class="form-control" id="documento" name="documento" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    
                    <button type="button" class="btn btn-outline-secondary mb-2" id="btnAgregarVehiculo" onclick="mostrarCamposVehiculo()">Agregar detalles vehículo</button>
                    <div id="camposVehiculo" style="display:none;">
                        <div class="mb-3">
                            <label for="vehiculo" class="form-label">Vehículo</label>
                            <input type="text" class="form-control" id="vehiculo" name="vehiculo" maxlength="100">
                        </div>
                        <div class="mb-3">
                            <label for="matricula" class="form-label">Matrícula</label>
                            <input type="text" class="form-control" id="matricula" name="matricula" maxlength="20">
                        </div>
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

<script>
function mostrarDetalleInquilino(inquilino) {
    window.currentInquilino = inquilino;
    
    // Actualizar la información del inquilino
    const infoInquilino = document.getElementById('info-inquilino');
    infoInquilino.innerHTML = `
        <p><strong>Nombre:</strong> ${inquilino.nombre}</p>
        <p><strong>Documento:</strong> ${inquilino.documento}</p>
        <p><strong>Email:</strong> ${inquilino.email}</p>
        <p><strong>Teléfono:</strong> ${inquilino.telefono}</p>
    `;
    
    // Mostrar el modal de detalles
    const modalDetalles = new bootstrap.Modal(document.getElementById('modalDetallesInquilino'));
    modalDetalles.show();
    
    // Cargar contratos y pagos
    cargarContratosInquilino(inquilino.id);
    cargarPagosInquilino(inquilino.id);
    
    // Al editar, si hay datos de vehiculo o matricula, mostrar los campos y rellenar
    document.getElementById('vehiculo').value = inquilino.vehiculo || '';
    document.getElementById('matricula').value = inquilino.matricula || '';
    if (inquilino.vehiculo || inquilino.matricula) {
        mostrarCamposVehiculo();
    }
}

function editarInquilino() {
    if (!window.currentInquilino) return;
    
    // Llenar el formulario con los datos actuales
    document.getElementById('inquilino_id').value = window.currentInquilino.id;
    document.getElementById('nombre').value = window.currentInquilino.nombre;
    document.getElementById('documento').value = window.currentInquilino.documento;
    document.getElementById('email').value = window.currentInquilino.email;
    document.getElementById('telefono').value = window.currentInquilino.telefono;
    
    // Actualizar título y mostrar botón de eliminar
    document.querySelector('#modalInquilino .modal-title').textContent = 'Editar Inquilino';
    document.querySelector('#modalInquilino .btn-danger').classList.remove('d-none');
    
    // Mostrar el modal de edición
    const modalEditar = new bootstrap.Modal(document.getElementById('modalInquilino'));
    modalEditar.show();
}

function nuevoInquilino() {
    // Limpiar el formulario
    document.getElementById('formInquilino').reset();
    document.getElementById('inquilino_id').value = '';
    
    // Actualizar título y ocultar botón de eliminar
    document.querySelector('#modalInquilino .modal-title').textContent = 'Nuevo Inquilino';
    document.querySelector('#modalInquilino .btn-danger').classList.add('d-none');
    
    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalInquilino'));
    modal.show();
}

function guardarInquilino() {
    const formData = new FormData(document.getElementById('formInquilino'));
    formData.append('action', formData.get('id') ? 'update' : 'create');
    
    fetch('modules/inquilinos/actions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar el modal y recargar la página
            bootstrap.Modal.getInstance(document.getElementById('modalInquilino')).hide();
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar el inquilino');
    });
}

function eliminarInquilino() {
    if (!confirm('¿Está seguro de que desea eliminar este inquilino?')) return;
    
    const formData = new FormData();
    formData.append('action', 'delete');
    formData.append('id', document.getElementById('inquilino_id').value);
    
    fetch('modules/inquilinos/actions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar los modales y recargar la página
            bootstrap.Modal.getInstance(document.getElementById('modalInquilino')).hide();
            bootstrap.Modal.getInstance(document.getElementById('modalDetallesInquilino')).hide();
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar el inquilino');
    });
}

function cargarContratosInquilino(inquilinoId) {
    const formData = new FormData();
    formData.append('action', 'get_contratos');
    formData.append('id', inquilinoId);
    
    fetch('modules/inquilinos/actions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarContratosInquilino(data.data);
        } else {
            document.getElementById('lista-contratos').innerHTML = 
                '<div class="alert alert-warning">No se pudieron cargar los contratos</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('lista-contratos').innerHTML = 
            '<div class="alert alert-danger">Error al cargar los contratos</div>';
    });
}

function cargarPagosInquilino(inquilinoId) {
    const formData = new FormData();
    formData.append('action', 'get_pagos');
    formData.append('id', inquilinoId);
    
    fetch('modules/inquilinos/actions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarPagosInquilino(data.data);
        } else {
            document.getElementById('lista-pagos').innerHTML = 
                '<div class="alert alert-warning">No se pudieron cargar los pagos</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('lista-pagos').innerHTML = 
            '<div class="alert alert-danger">Error al cargar los pagos</div>';
    });
}

function mostrarContratosInquilino(contratos) {
    const listaContratos = document.getElementById('lista-contratos');
    if (!contratos || contratos.length === 0) {
        listaContratos.innerHTML = '<div class="alert alert-info">No hay contratos registrados</div>';
        return;
    }
    
    let html = '<div class="table-responsive"><table class="table table-sm">';
    html += '<thead><tr><th>Propiedad</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Renta</th><th>Estado</th></tr></thead><tbody>';
    
    contratos.forEach(contrato => {
        const estado = contrato.estado === 'Activo' ? 'success' : 'secondary';
        html += `
            <tr>
                <td>${contrato.propiedad_direccion}</td>
                <td>${contrato.fecha_inicio}</td>
                <td>${contrato.fecha_fin}</td>
                <td>$${parseFloat(contrato.renta_mensual).toFixed(2)}</td>
                <td><span class="badge bg-${estado}">${contrato.estado}</span></td>
            </tr>
        `;
    });
    
    html += '</tbody></table></div>';
    listaContratos.innerHTML = html;
}

function mostrarPagosInquilino(pagos) {
    const listaPagos = document.getElementById('lista-pagos');
    if (!pagos || pagos.length === 0) {
        listaPagos.innerHTML = '<div class="alert alert-info">No hay pagos registrados</div>';
        return;
    }
    
    let html = '<div class="table-responsive"><table class="table table-sm">';
    html += '<thead><tr><th>Propiedad</th><th>Fecha</th><th>Monto</th><th>Estado</th></tr></thead><tbody>';
    
    pagos.forEach(pago => {
        const estado = pago.estado === 'Pagado' ? 'success' : 'warning';
        html += `
            <tr>
                <td>${pago.propiedad_direccion}</td>
                <td>${pago.fecha_vencimiento}</td>
                <td>$${parseFloat(pago.monto).toFixed(2)}</td>
                <td><span class="badge bg-${estado}">${pago.estado}</span></td>
            </tr>
        `;
    });
    
    html += '</tbody></table></div>';
    listaPagos.innerHTML = html;
}

function mostrarCamposVehiculo() {
    document.getElementById('camposVehiculo').style.display = 'block';
    document.getElementById('btnAgregarVehiculo').style.display = 'none';
}
</script> 