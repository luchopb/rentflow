<!-- Modal para Nuevo/Editar Pago extraído -->
<div class="modal fade" id="modalPago" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formPago" enctype="multipart/form-data">
                    <input type="hidden" id="pago_id" name="id">
                    <div class="mb-3">
                        <label for="contrato_id" class="form-label">Contrato</label>
                        <select class="form-select" id="contrato_id" name="contrato_id" required>
                            <option value="">Seleccione un contrato</option>
                            <?php 
                            $contratos_select = isset($contratos_activos) ? $contratos_activos : (isset($contratos) ? $contratos : []);
                            foreach ($contratos_select as $contrato): ?>
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
                    <div class="mb-3">
                        <label for="concepto" class="form-label">Concepto</label>
                        <select class="form-select" id="concepto" name="concepto" required>
                            <option value="Alquiler">Alquiler</option>
                            <option value="Gastos Comunes">Gastos Comunes</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="comprobante" class="form-label">Comprobante de Pago</label>
                        <input type="file" class="form-control" id="comprobante" name="comprobante" accept=".pdf,.jpg,.jpeg,.png">
                        <div class="form-text">Formatos permitidos: PDF, JPG, JPEG, PNG. Tamaño máximo: 5MB</div>
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