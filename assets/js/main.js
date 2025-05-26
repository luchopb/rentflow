// Función para mostrar alertas con SweetAlert2
function showAlert(options) {
    const defaultOptions = {
        title: options.success ? '¡Éxito!' : 'Error',
        text: options.message,
        icon: options.success ? 'success' : 'error',
        confirmButtonText: 'Aceptar',
        customClass: {
            confirmButton: 'btn btn-primary'
        }
    };
    return Swal.fire({...defaultOptions, ...options});
}

// Función para mostrar confirmación
function showConfirm(options) {
    const defaultOptions = {
        title: '¿Está seguro?',
        text: options.message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        }
    };
    return Swal.fire({...defaultOptions, ...options});
}

// Función para cargar contenido en el contenedor principal
function cargarModulo(modulo) {
    $.ajax({
        url: `modules/${modulo}/index.php`,
        method: 'GET',
        success: function(data) {
            $('#main-content').html(data);
            
            // Inicializar los modales de Bootstrap después de cargar el contenido
            const modales = document.querySelectorAll('.modal');
            modales.forEach(modal => {
                new bootstrap.Modal(modal);
            });
            
            // Limpiar variables globales al cambiar de módulo
            window.currentContrato = null;
            window.currentPago = null;
            window.currentInquilino = null;
            
            // Remover cualquier backdrop extra que pueda haber quedado
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach((backdrop, index) => {
                if (index > 0) backdrop.remove();
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error al cargar el módulo:', {
                status: jqXHR.status,
                statusText: jqXHR.statusText,
                responseText: jqXHR.responseText,
                textStatus: textStatus,
                errorThrown: errorThrown
            });
            $('#main-content').html(`
                <div class="alert alert-danger">
                    <h4 class="alert-heading">Error al cargar el módulo</h4>
                    <p>Se produjo un error al cargar el módulo ${modulo}.</p>
                    <hr>
                    <p class="mb-0">Detalles técnicos: ${textStatus} - ${errorThrown}</p>
                </div>
            `);
        }
    });
}

// Event listeners para la navegación
$(document).ready(function() {
    $('.nav-link').click(function(e) {
        e.preventDefault();
        const modulo = $(this).data('page');
        cargarModulo(modulo);
    });

    // Cargar el dashboard por defecto
    cargarModulo('dashboard');
});

// Funciones para el módulo de propiedades
function limpiarFormPropiedad() {
    $('#formPropiedad')[0].reset();
    $('#propiedad_id').val('');
    $('.modal-title').text('Nueva Propiedad');
}

function mostrarDetallePropiedad(propiedad) {
    document.getElementById('propiedad_id').value = propiedad.id;
    document.getElementById('nombre').value = propiedad.nombre || '';
    document.getElementById('direccion').value = propiedad.direccion;
    document.getElementById('tipo').value = propiedad.tipo;
    document.getElementById('precio').value = propiedad.precio;
    document.getElementById('gastos_comunes').value = propiedad.gastos_comunes;
    document.getElementById('contribucion_inmobiliaria_cc').value = parseInt(propiedad.contribucion_inmobiliaria_cc) || 0;
    document.getElementById('contribucion_inmobiliaria_padron').value = parseInt(propiedad.contribucion_inmobiliaria_padron) || 0;
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

function editarPropiedad(id) {
    $.post('modules/propiedades/actions.php', {
        action: 'get',
        id: id
    }, function(response) {
        if (response.success) {
            const propiedad = response.data;
            $('#propiedad_id').val(propiedad.id);
            $('#nombre').val(propiedad.nombre || '');
            $('#direccion').val(propiedad.direccion);
            $('#tipo').val(propiedad.tipo);
            $('#precio').val(propiedad.precio);
            $('#estado').val(propiedad.estado);
            $('#caracteristicas').val(propiedad.caracteristicas);
            $('#galeria').val(propiedad.galeria);
            $('#local').val(propiedad.local);
            
            $('.modal-title').text('Editar Propiedad');
            $('#modalPropiedad').modal('show');
        } else {
            showAlert({success: false, message: response.message});
        }
    }, 'json');
}

function guardarPropiedad() {
    const formData = new FormData($('#formPropiedad')[0]);
    formData.append('action', $('#propiedad_id').val() ? 'update' : 'create');

    $.ajax({
        url: 'modules/propiedades/actions.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            try {
                if (typeof response === 'string') {
                    response = JSON.parse(response);
                }
                showAlert({
                    success: response.success,
                    message: response.message || 'Operación completada exitosamente'
                }).then((result) => {
                    if (response.success) {
                        $('#modalPropiedad').modal('hide');
                        cargarModulo('propiedades');
                    }
                });
            } catch (e) {
                console.error('Error al procesar la respuesta:', e);
                showAlert({
                    success: false,
                    message: 'Error al procesar la respuesta del servidor'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud:', error);
            let errorMessage = 'Error al procesar la solicitud';
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.message && response.message.includes('SQLSTATE[23000]')) {
                    errorMessage = 'Error: No se pudo crear la propiedad debido a un problema con la base de datos. Por favor, verifique que todos los datos sean correctos.';
                } else {
                    errorMessage = response.message || errorMessage;
                }
            } catch (e) {}
            showAlert({success: false, message: errorMessage});
        }
    });
}

function eliminarPropiedad(id) {
    showConfirm({
        message: '¿Está seguro de que desea eliminar esta propiedad?'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post('modules/propiedades/actions.php', {
                action: 'delete',
                id: id
            }, function(response) {
                showAlert({
                    success: response.success,
                    message: response.message
                }).then(() => {
                    if (response.success) {
                        cargarModulo('propiedades');
                    }
                });
            }, 'json');
        }
    });
}

// Funciones para el módulo de inquilinos
function limpiarFormInquilino() {
    $('#formInquilino')[0].reset();
    $('#inquilino_id').val('');
    $('.modal-title').text('Nuevo Inquilino');
}

function nuevoInquilino() {
    document.getElementById('formInquilino').reset();
    document.getElementById('inquilino_id').value = '';
    document.querySelector('#modalInquilino .modal-title').textContent = 'Nuevo Inquilino';
    document.querySelector('#modalInquilino .btn-danger').classList.add('d-none');
    new bootstrap.Modal(document.getElementById('modalInquilino')).show();
}

function mostrarDetalleInquilino(inquilino) {
    // Guardar el inquilino actual en una variable global
    window.currentInquilino = inquilino;

    // Mostrar información del inquilino
    let infoHtml = `
        <dl class="row">
            <dt class="col-sm-3">Nombre</dt>
            <dd class="col-sm-9">${inquilino.nombre}</dd>
            <dt class="col-sm-3">Documento</dt>
            <dd class="col-sm-9">${inquilino.documento}</dd>
            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">${inquilino.email}</dd>
            <dt class="col-sm-3">Teléfono</dt>
            <dd class="col-sm-9">${inquilino.telefono}</dd>
        </dl>
    `;
    document.getElementById('info-inquilino').innerHTML = infoHtml;

    // Cargar contratos
    $.post('modules/inquilinos/actions.php', {
        action: 'get_contratos',
        id: inquilino.id
    }, function(response) {
        if (response.success) {
            let html = '<table class="table table-hover">';
            html += '<thead><tr><th>Propiedad</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Renta</th><th>Estado</th></tr></thead>';
            html += '<tbody>';
            
            response.data.forEach(contrato => {
                html += `<tr class="cursor-pointer" onclick='mostrarDetalleContrato(${JSON.stringify(contrato)})'>
                    <td>${contrato.propiedad_direccion}</td>
                    <td>${contrato.fecha_inicio}</td>
                    <td>${contrato.fecha_fin}</td>
                    <td>$${parseFloat(contrato.renta_mensual).toFixed(2)}</td>
                    <td><span class="badge ${contrato.estado === 'Activo' ? 'bg-success' : 'bg-secondary'}">${contrato.estado}</span></td>
                </tr>`;
            });
            
            html += '</tbody></table>';
            $('#lista-contratos').html(html);
        }
    }, 'json');

    // Cargar pagos
    $.post('modules/inquilinos/actions.php', {
        action: 'get_pagos',
        id: inquilino.id
    }, function(response) {
        if (response.success) {
            let html = '<table class="table table-hover">';
            html += '<thead><tr><th>Propiedad</th><th>Vencimiento</th><th>Monto</th><th>Fecha Pago</th><th>Estado</th></tr></thead>';
            html += '<tbody>';
            
            response.data.forEach(pago => {
                const estado_class = {
                    'Pendiente': 'bg-warning',
                    'Pagado': 'bg-success',
                    'Vencido': 'bg-danger'
                }[pago.estado];

                html += `<tr class="cursor-pointer" onclick='mostrarDetallePago(${JSON.stringify(pago)})'>
                    <td>${pago.propiedad_direccion}</td>
                    <td>${pago.fecha_vencimiento}</td>
                    <td>$${parseFloat(pago.monto).toFixed(2)}</td>
                    <td>${pago.fecha_pago || '-'}</td>
                    <td><span class="badge ${estado_class}">${pago.estado}</span></td>
                </tr>`;
            });
            
            html += '</tbody></table>';
            $('#lista-pagos').html(html);
        }
    }, 'json');

    $('#modalDetallesInquilino').modal('show');
}

function editarInquilino() {
    // Usar el inquilino actual guardado
    if (!window.currentInquilino) {
        showAlert({
            success: false,
            message: 'Error: No se pudo obtener la información del inquilino'
        });
        return;
    }

    // Cerrar el modal de detalles
    $('#modalDetallesInquilino').modal('hide');
    
    // Esperar a que se cierre el modal de detalles antes de abrir el de edición
    setTimeout(() => {
        // Llenar el formulario con los datos del inquilino actual
        document.getElementById('inquilino_id').value = window.currentInquilino.id;
        document.getElementById('nombre').value = window.currentInquilino.nombre;
        document.getElementById('documento').value = window.currentInquilino.documento;
        document.getElementById('email').value = window.currentInquilino.email;
        document.getElementById('telefono').value = window.currentInquilino.telefono;
        
        document.querySelector('#modalInquilino .modal-title').textContent = 'Editar Inquilino';
        document.querySelector('#modalInquilino .btn-danger').classList.remove('d-none');
        $('#modalInquilino').modal('show');
    }, 300); // Esperar 300ms para asegurar que el primer modal se haya cerrado
}

function guardarInquilino() {
    const formData = new FormData($('#formInquilino')[0]);
    formData.append('action', $('#inquilino_id').val() ? 'update' : 'create');

    $.ajax({
        url: 'modules/inquilinos/actions.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            try {
                if (typeof response === 'string') {
                    response = JSON.parse(response);
                }
                showAlert({
                    success: response.success,
                    message: response.message || 'Operación completada exitosamente'
                }).then((result) => {
                    if (response.success) {
                        $('#modalInquilino').modal('hide');
                        cargarModulo('inquilinos');
                    }
                });
            } catch (e) {
                console.error('Error al procesar la respuesta:', e);
                showAlert({
                    success: false,
                    message: 'Error al procesar la respuesta del servidor'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud:', error);
            let errorMessage = 'Error al procesar la solicitud';
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.message && response.message.includes('SQLSTATE[23000]')) {
                    errorMessage = 'Error: No se pudo crear el inquilino. El DNI o email ya existe en el sistema.';
                } else {
                    errorMessage = response.message || errorMessage;
                }
            } catch (e) {}
            showAlert({success: false, message: errorMessage});
        }
    });
}

function eliminarInquilino(id) {
    if (confirm('¿Está seguro de que desea eliminar este inquilino?')) {
        $.post('modules/inquilinos/actions.php', {
            action: 'delete',
            id: id
        }, function(response) {
            alert(response.message);
            if (response.success) {
                cargarModulo('inquilinos');
            }
        }, 'json');
    }
}

// Funciones para el módulo de contratos
function limpiarFormContrato() {
    $('#formContrato')[0].reset();
    $('#contrato_id').val('');
    $('.modal-title').text('Nuevo Contrato');
}

function nuevoContrato() {
    document.getElementById('formContrato').reset();
    document.getElementById('contrato_id').value = '';
    document.querySelector('#modalContrato .modal-title').textContent = 'Nuevo Contrato';
    document.querySelector('#modalContrato .btn-danger').classList.add('d-none');
    new bootstrap.Modal(document.getElementById('modalContrato')).show();
}

function mostrarDetalleContrato(contrato) {
    // Guardar el contrato actual en una variable global
    window.currentContrato = contrato;

    // Mostrar información del contrato
    let infoHtml = `
        <dl class="row">
            <dt class="col-sm-3">Propiedad</dt>
            <dd class="col-sm-9">${contrato.propiedad_direccion}</dd>
            <dt class="col-sm-3">Inquilino</dt>
            <dd class="col-sm-9">${contrato.inquilino_nombre} (DNI: ${contrato.inquilino_dni})</dd>
            <dt class="col-sm-3">Fecha Inicio</dt>
            <dd class="col-sm-9">${contrato.fecha_inicio}</dd>
            <dt class="col-sm-3">Fecha Fin</dt>
            <dd class="col-sm-9">${contrato.fecha_fin}</dd>
            <dt class="col-sm-3">Renta Mensual</dt>
            <dd class="col-sm-9">$${parseFloat(contrato.renta_mensual).toFixed(2)}</dd>
            <dt class="col-sm-3">Estado</dt>
            <dd class="col-sm-9">
                <span class="badge ${contrato.estado === 'Activo' ? 'bg-success' : 'bg-secondary'}">
                    ${contrato.estado}
                </span>
            </dd>
        </dl>
    `;
    document.getElementById('info-contrato').innerHTML = infoHtml;
    document.getElementById('contrato_id').value = contrato.id;

    // Cargar pagos del contrato
    $.post('modules/contratos/actions.php', {
        action: 'get_pagos',
        id: contrato.id
    }, function(response) {
        if (response.success) {
            let html = '<table class="table table-hover">';
            html += '<thead><tr><th>Fecha Vencimiento</th><th>Monto</th><th>Fecha Pago</th><th>Monto Pagado</th><th>Estado</th></tr></thead>';
            html += '<tbody>';
            
            response.data.forEach(pago => {
                const estado_class = {
                    'Pendiente': 'bg-warning',
                    'Pagado': 'bg-success',
                    'Vencido': 'bg-danger'
                }[pago.estado];

                html += `<tr class="cursor-pointer" onclick='mostrarDetallePago(${JSON.stringify(pago)})'>
                    <td>${pago.fecha_vencimiento}</td>
                    <td>$${parseFloat(pago.monto).toFixed(2)}</td>
                    <td>${pago.fecha_pago || '-'}</td>
                    <td>$${pago.monto_pagado ? parseFloat(pago.monto_pagado).toFixed(2) : '-'}</td>
                    <td><span class="badge ${estado_class}">${pago.estado}</span></td>
                </tr>`;
            });
            
            html += '</tbody></table>';
            $('#lista-pagos-contrato').html(html);
        }
    }, 'json');

    $('#modalDetallesContrato').modal('show');
}

function editarContrato() {
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
    
    // Mostrar el modal de edición
    const modalEditar = new bootstrap.Modal(document.getElementById('modalContrato'));
    modalEditar.show();
}

function guardarContrato() {
    // Validar fechas
    const fechaInicio = new Date($('#fecha_inicio').val());
    const fechaFin = new Date($('#fecha_fin').val());
    
    if (fechaInicio >= fechaFin) {
        showAlert({
            success: false,
            message: 'La fecha de fin debe ser posterior a la fecha de inicio'
        });
        return;
    }

    const formData = new FormData($('#formContrato')[0]);
    formData.append('action', $('#contrato_id').val() ? 'update' : 'create');

    $.ajax({
        url: 'modules/contratos/actions.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            try {
                if (typeof response === 'string') {
                    response = JSON.parse(response);
                }
                showAlert({
                    success: response.success,
                    message: response.message || 'Operación completada exitosamente'
                }).then((result) => {
                    if (response.success) {
                        $('#modalContrato').modal('hide');
                        cargarModulo('contratos');
                    }
                });
            } catch (e) {
                console.error('Error al procesar la respuesta:', e);
                showAlert({
                    success: false,
                    message: 'Error al procesar la respuesta del servidor'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud:', error);
            let errorMessage = 'Error al procesar la solicitud';
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.message && response.message.includes('SQLSTATE[23000]')) {
                    errorMessage = 'Error: No se pudo crear el contrato debido a un problema con la base de datos. Por favor, verifique que todos los datos sean correctos.';
                } else {
                    errorMessage = response.message || errorMessage;
                }
            } catch (e) {}
            showAlert({success: false, message: errorMessage});
        }
    });
}

function eliminarContrato(id) {
    if (confirm('¿Está seguro de que desea eliminar este contrato? Se eliminarán también todos los pagos asociados.')) {
        $.post('modules/contratos/actions.php', {
            action: 'delete',
            id: id
        }, function(response) {
            alert(response.message);
            if (response.success) {
                cargarModulo('contratos');
            }
        }, 'json');
    }
}

function verPagosContrato(id) {
    $.post('modules/contratos/actions.php', {
        action: 'get_pagos',
        id: id
    }, function(response) {
        if (response.success) {
            let html = '<table class="table table-striped">';
            html += '<thead><tr><th>Fecha Vencimiento</th><th>Monto</th><th>Fecha Pago</th><th>Monto Pagado</th><th>Estado</th></tr></thead>';
            html += '<tbody>';
            
            response.data.forEach(pago => {
                const estado_class = {
                    'Pendiente': 'bg-warning',
                    'Pagado': 'bg-success',
                    'Vencido': 'bg-danger'
                }[pago.estado];

                html += `<tr>
                    <td>${pago.fecha_vencimiento}</td>
                    <td>$${parseFloat(pago.monto).toFixed(2)}</td>
                    <td>${pago.fecha_pago || '-'}</td>
                    <td>$${pago.monto_pagado ? parseFloat(pago.monto_pagado).toFixed(2) : '-'}</td>
                    <td><span class="badge ${estado_class}">${pago.estado}</span></td>
                </tr>`;
            });
            
            html += '</tbody></table>';
            $('#lista-pagos-contrato').html(html);
            $('#modalPagosContrato').modal('show');
        }
    }, 'json');
}

function registrarPagoContrato() {
    window.nuevoPago();
}

// Funciones para el módulo de pagos
function limpiarFormPago() {
    $('#formPago')[0].reset();
    $('#pago_id').val('');
    $('.modal-title').text('Nuevo Pago');
}

function nuevoPago() {
    var form = document.getElementById('formPago');
    var modal = document.getElementById('modalPago');
    if (!form || !modal) {
        showAlert({
            success: false,
            message: 'El formulario de pago no está disponible en esta sección.'
        });
        return;
    }
    form.reset();
    document.getElementById('pago_id').value = '';
    document.querySelector('#modalPago .modal-title').textContent = 'Nuevo Pago';
    document.querySelector('#modalPago .btn-danger').classList.add('d-none');
    document.getElementById('fecha_pago').value = new Date().toISOString().split('T')[0];
    new bootstrap.Modal(modal).show();
}

function mostrarDetallePago(pago) {
    // Guardar el pago actual en una variable global
    window.currentPago = pago;

    // Mostrar información del pago
    let infoHtml = `
        <dl class="row">
            <dt class="col-sm-3">Propiedad</dt>
            <dd class="col-sm-9">${pago.propiedad_direccion}</dd>
            <dt class="col-sm-3">Inquilino</dt>
            <dd class="col-sm-9">${pago.inquilino_nombre} (DNI: ${pago.inquilino_dni})</dd>
            <dt class="col-sm-3">Vencimiento</dt>
            <dd class="col-sm-9">${pago.fecha_vencimiento}</dd>
            <dt class="col-sm-3">Monto</dt>
            <dd class="col-sm-9">$${parseFloat(pago.monto).toFixed(2)}</dd>
            <dt class="col-sm-3">Fecha Pago</dt>
            <dd class="col-sm-9">${pago.fecha_pago || '-'}</dd>
            <dt class="col-sm-3">Monto Pagado</dt>
            <dd class="col-sm-9">${pago.monto_pagado ? '$' + parseFloat(pago.monto_pagado).toFixed(2) : '-'}</dd>
            <dt class="col-sm-3">Estado</dt>
            <dd class="col-sm-9">
                <span class="badge ${pago.estado === 'Pagado' ? 'bg-success' : (pago.estado === 'Vencido' ? 'bg-danger' : 'bg-warning')}">
                    ${pago.estado}
                </span>
            </dd>
        </dl>
    `;
    document.getElementById('info-pago').innerHTML = infoHtml;
    document.getElementById('pago_id').value = pago.id;

    $('#modalDetallePago').modal('show');
}

function editarPago() {
    if (!window.currentPago) return;
    
    // Llenar el formulario con los datos actuales
    document.getElementById('pago_id').value = window.currentPago.id;
    document.getElementById('contrato_id').value = window.currentPago.contrato_id;
    document.getElementById('monto').value = window.currentPago.monto;
    document.getElementById('fecha_pago').value = window.currentPago.fecha_pago || new Date().toISOString().split('T')[0];
    document.getElementById('monto_pagado').value = window.currentPago.monto_pagado || window.currentPago.monto;
    
    // Actualizar título y mostrar botón de eliminar
    document.querySelector('#modalPago .modal-title').textContent = 'Editar Pago';
    document.querySelector('#modalPago .btn-danger').classList.remove('d-none');
    $('#modalPago').modal('show');
}

function guardarPago() {
    // Validar fechas
    const fechaPago = $('#fecha_pago').val();
    if (fechaPago && new Date(fechaPago) > new Date()) {
        showAlert({
            success: false,
            message: 'La fecha de pago no puede ser futura'
        });
        return;
    }

    const formData = new FormData($('#formPago')[0]);
    formData.append('action', $('#pago_id').val() ? 'update' : 'create');

    $.ajax({
        url: 'modules/pagos/actions.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            try {
                if (typeof response === 'string') {
                    response = JSON.parse(response);
                }
                showAlert({
                    success: response.success,
                    message: response.message || 'Operación completada exitosamente'
                }).then((result) => {
                    if (response.success) {
                        $('#modalPago').modal('hide');
                        cargarModulo('pagos');
                    }
                });
            } catch (e) {
                console.error('Error al procesar la respuesta:', e);
                showAlert({
                    success: false,
                    message: 'Error al procesar la respuesta del servidor'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud:', error);
            let errorMessage = 'Error al procesar la solicitud';
            try {
                const response = JSON.parse(xhr.responseText);
                errorMessage = response.message || errorMessage;
            } catch (e) {}
            showAlert({success: false, message: errorMessage});
        }
    });
}

function eliminarPago(id) {
    if (confirm('¿Está seguro de que desea eliminar este pago?')) {
        $.post('modules/pagos/actions.php', {
            action: 'delete',
            id: id
        }, function(response) {
            alert(response.message);
            if (response.success) {
                cargarModulo('pagos');
            }
        }, 'json');
    }
}

// Event listeners para el módulo de pagos
$(document).on('change', '#contrato_id', function() {
    const option = $(this).find('option:selected');
    const renta = option.data('renta');
    if (renta) {
        $('#monto').val(renta);
        $('#monto_pagado').val(renta);
    }
});

$(document).on('change', '#fecha_pago, #monto_pagado', function() {
    const fechaPago = $('#fecha_pago').val();
    const montoPagado = $('#monto_pagado').val();
    
    if (fechaPago && montoPagado) {
        $('#estado').val('Pagado');
    } else if (!fechaPago && !montoPagado) {
        const fechaVencimiento = $('#fecha_vencimiento').val();
        if (fechaVencimiento && new Date(fechaVencimiento) < new Date()) {
            $('#estado').val('Vencido');
        } else {
            $('#estado').val('Pendiente');
        }
    }
});

// Función para actualizar estados de pagos
function actualizarEstadosPagos() {
    $.post('modules/pagos/actions.php', {
        action: 'actualizar_estados'
    }, function(response) {
        if (response.success) {
            cargarModulo('pagos');
        }
    }, 'json');
}

// Actualizar estados de pagos cada hora
setInterval(actualizarEstadosPagos, 3600000);

// Función para mostrar notificaciones
function mostrarNotificacion(mensaje, tipo = 'success') {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    Toast.fire({
        icon: tipo,
        title: mensaje
    });
} 