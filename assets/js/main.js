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
    $.get(`modules/${modulo}/index.php`, function(data) {
        $('#main-content').html(data);
    });
}

// Event listeners para la navegación
$(document).ready(function() {
    $('.nav-link').click(function(e) {
        e.preventDefault();
        const modulo = $(this).data('page');
        cargarModulo(modulo);
    });

    // Cargar el módulo de propiedades por defecto
    cargarModulo('propiedades');
});

// Funciones para el módulo de propiedades
function limpiarFormPropiedad() {
    $('#formPropiedad')[0].reset();
    $('#propiedad_id').val('');
    $('.modal-title').text('Nueva Propiedad');
}

function editarPropiedad(id) {
    $.post('modules/propiedades/actions.php', {
        action: 'get',
        id: id
    }, function(response) {
        if (response.success) {
            const propiedad = response.data;
            $('#propiedad_id').val(propiedad.id);
            $('#direccion').val(propiedad.direccion);
            $('#tipo').val(propiedad.tipo);
            $('#precio').val(propiedad.precio);
            $('#estado').val(propiedad.estado);
            $('#caracteristicas').val(propiedad.caracteristicas);
            
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

function editarInquilino(id) {
    $.post('modules/inquilinos/actions.php', {
        action: 'get',
        id: id
    }, function(response) {
        if (response.success) {
            const inquilino = response.data;
            $('#inquilino_id').val(inquilino.id);
            $('#nombre').val(inquilino.nombre);
            $('#dni').val(inquilino.dni);
            $('#email').val(inquilino.email);
            $('#telefono').val(inquilino.telefono);
            
            $('.modal-title').text('Editar Inquilino');
            $('#modalInquilino').modal('show');
        } else {
            alert(response.message);
        }
    }, 'json');
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
        success: function(response) {
            if (response.success) {
                $('#modalInquilino').modal('hide');
                cargarModulo('inquilinos');
            }
            alert(response.message);
        },
        error: function() {
            alert('Error al procesar la solicitud');
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

function verDetallesInquilino(id) {
    // Cargar contratos
    $.post('modules/inquilinos/actions.php', {
        action: 'get_contratos',
        id: id
    }, function(response) {
        if (response.success) {
            let html = '<table class="table table-striped">';
            html += '<thead><tr><th>Propiedad</th><th>Fecha Inicio</th><th>Fecha Fin</th><th>Renta</th><th>Estado</th></tr></thead>';
            html += '<tbody>';
            
            response.data.forEach(contrato => {
                html += `<tr>
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
        id: id
    }, function(response) {
        if (response.success) {
            let html = '<table class="table table-striped">';
            html += '<thead><tr><th>Propiedad</th><th>Vencimiento</th><th>Monto</th><th>Fecha Pago</th><th>Estado</th></tr></thead>';
            html += '<tbody>';
            
            response.data.forEach(pago => {
                const estado_class = {
                    'Pendiente': 'bg-warning',
                    'Pagado': 'bg-success',
                    'Vencido': 'bg-danger'
                }[pago.estado];

                html += `<tr>
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

function registrarNuevoPago() {
    // Esta función se implementará cuando creemos el módulo de pagos
    alert('Funcionalidad en desarrollo');
}

// Funciones para el módulo de contratos
function limpiarFormContrato() {
    $('#formContrato')[0].reset();
    $('#contrato_id').val('');
    $('.modal-title').text('Nuevo Contrato');
}

function editarContrato(id) {
    $.post('modules/contratos/actions.php', {
        action: 'get',
        id: id
    }, function(response) {
        if (response.success) {
            const contrato = response.data;
            $('#contrato_id').val(contrato.id);
            $('#propiedad_id').val(contrato.propiedad_id);
            $('#inquilino_id').val(contrato.inquilino_id);
            $('#fecha_inicio').val(contrato.fecha_inicio);
            $('#fecha_fin').val(contrato.fecha_fin);
            $('#renta_mensual').val(contrato.renta_mensual);
            $('#estado').val(contrato.estado);
            
            $('.modal-title').text('Editar Contrato');
            $('#modalContrato').modal('show');
        } else {
            alert(response.message);
        }
    }, 'json');
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
    // Esta función se implementará cuando creemos el módulo de pagos
    alert('Funcionalidad en desarrollo');
}

// Funciones para el módulo de pagos
function limpiarFormPago() {
    $('#formPago')[0].reset();
    $('#pago_id').val('');
    $('.modal-title').text('Nuevo Pago');
}

function editarPago(id) {
    $.post('modules/pagos/actions.php', {
        action: 'get',
        id: id
    }, function(response) {
        if (response.success) {
            const pago = response.data;
            $('#pago_id').val(pago.id);
            $('#contrato_id').val(pago.contrato_id);
            $('#fecha_vencimiento').val(pago.fecha_vencimiento);
            $('#monto').val(pago.monto);
            $('#fecha_pago').val(pago.fecha_pago || '');
            $('#monto_pagado').val(pago.monto_pagado || '');
            $('#estado').val(pago.estado);
            
            $('.modal-title').text('Editar Pago');
            $('#modalPago').modal('show');
        } else {
            alert(response.message);
        }
    }, 'json');
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