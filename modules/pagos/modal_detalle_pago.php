<!-- Modal para Detalles del Pago extraído -->
<div class="modal fade" id="modalDetallePago" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col">
                        <h6>Información del Pago</h6>
                        <div id="info-pago" class="mb-4"></div>
                        <div id="comprobante-container" class="mb-3">
                            <!-- El contenedor del comprobante se llenará dinámicamente -->
                        </div>
                        <button type="button" class="btn btn-primary btn-sm" onclick="editarPago()">
                            Editar Pago
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger me-auto" onclick="eliminarPago()">Eliminar Pago</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div> 