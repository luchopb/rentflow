<?php
// Habilitar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../config/error_log.php';
require_once '../../config/database.php';

try {
    // Obtener todos los pagos con información relacionada
    $stmt = $conn->prepare("
        SELECT p.*,
               c.renta_mensual,
               pr.direccion as propiedad_direccion,
               i.nombre as inquilino_nombre,
               i.documento as inquilino_dni
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
               i.documento as inquilino_dni
        FROM contratos c
        JOIN propiedades p ON c.propiedad_id = p.id
        JOIN inquilinos i ON c.inquilino_id = i.id
        WHERE c.estado = 'Activo'
        ORDER BY p.direccion ASC
    ");
    $stmt->execute();
    $contratos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    // Registrar el error
    error_log("Error en pagos/index.php: " . $e->getMessage());
    // Mostrar mensaje de error
    echo "<div class='alert alert-danger'>
            <h4 class='alert-heading'>Error al cargar los pagos</h4>
            <p>Se produjo un error al cargar la información de pagos.</p>
            <hr>
            <p class='mb-0'>Error: " . htmlspecialchars($e->getMessage()) . "</p>
          </div>";
    exit;
}
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

<?php include __DIR__ . '/modal_pago.php'; ?>

<script>
// Asegurarse de que las funciones estén disponibles globalmente
window.mostrarDetallePago = function(pago) {
    window.currentPago = pago;
    
    // Actualizar la información del pago
    const infoPago = document.getElementById('info-pago');
    infoPago.innerHTML = `
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

    // Mostrar el comprobante si existe
    const comprobanteContainer = document.getElementById('comprobante-container');
    if (pago.comprobante) {
        const extension = pago.comprobante.split('.').pop().toLowerCase();
        if (['jpg', 'jpeg', 'png'].includes(extension)) {
            comprobanteContainer.innerHTML = `
                <h6>Comprobante de Pago</h6>
                <img src="uploads/pagos/${pago.comprobante}" class="img-fluid mb-2" alt="Comprobante de pago">
                <div>
                    <a href="uploads/pagos/${pago.comprobante}" class="btn btn-sm btn-secondary" target="_blank">Ver Original</a>
                </div>
            `;
        } else {
            comprobanteContainer.innerHTML = `
                <h6>Comprobante de Pago</h6>
                <div class="mb-2">
                    <i class="bi bi-file-earmark-pdf"></i> Documento PDF
                </div>
                <div>
                    <a href="uploads/pagos/${pago.comprobante}" class="btn btn-sm btn-secondary" target="_blank">Ver Documento</a>
                </div>
            `;
        }
    } else {
        comprobanteContainer.innerHTML = '<p class="text-muted">No hay comprobante adjunto</p>';
    }
    
    // Mostrar el modal de detalles
    const modalDetalles = new bootstrap.Modal(document.getElementById('modalDetallePago'));
    modalDetalles.show();
};

window.editarPago = function() {
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
    
    // Cerrar el modal de detalles antes de abrir el de edición
    const modalDetalles = bootstrap.Modal.getInstance(document.getElementById('modalDetallePago'));
    if (modalDetalles) {
        modalDetalles.hide();
    }
    
    // Mostrar el modal de edición
    const modalEditar = new bootstrap.Modal(document.getElementById('modalPago'));
    modalEditar.show();
};

window.nuevoPago = function() {
    // Limpiar el formulario
    document.getElementById('formPago').reset();
    document.getElementById('pago_id').value = '';
    document.querySelector('#modalPago .modal-title').textContent = 'Nuevo Pago';
    document.querySelector('#modalPago .btn-danger').classList.add('d-none');
    document.getElementById('fecha_pago').value = new Date().toISOString().split('T')[0];
    
    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('modalPago'));
    modal.show();
};

// Inicializar los event listeners cuando se carga el módulo
document.addEventListener('DOMContentLoaded', function() {
    const modalPago = document.getElementById('modalPago');
    const modalDetalles = document.getElementById('modalDetallePago');
    
    if (modalDetalles) {
        modalDetalles.addEventListener('hidden.bs.modal', function() {
            window.currentPago = null;
            // Remover cualquier backdrop extra
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach((backdrop, index) => {
                if (index > 0) backdrop.remove();
            });
        });
    }
    
    if (modalPago) {
        modalPago.addEventListener('hidden.bs.modal', function() {
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach((backdrop, index) => {
                if (index > 0) backdrop.remove();
            });
        });
    }
    
    // Inicializar event listeners para el formulario de pago
    const contratoSelect = document.getElementById('contrato_id');
    if (contratoSelect) {
        contratoSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const renta = selectedOption.getAttribute('data-renta');
            if (renta) {
                document.getElementById('monto').value = renta;
                document.getElementById('monto_pagado').value = renta;
            }
        });
    }
});
</script> 