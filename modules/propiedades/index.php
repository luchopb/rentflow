<?php
require_once '../../config/database.php';
require_once '../../config/helpers.php';

// Obtener todas las propiedades con información del inquilino actual
$stmt = $conn->prepare("
    SELECT p.*,
           i.nombre as inquilino_actual,
           c.estado as estado_contrato
    FROM propiedades p
    LEFT JOIN (
        SELECT c1.*
        FROM contratos c1
        LEFT JOIN contratos c2 
        ON c1.propiedad_id = c2.propiedad_id 
        AND c1.fecha_inicio < c2.fecha_inicio
        WHERE c2.propiedad_id IS NULL
        AND c1.estado = 'Activo'
        AND CURRENT_DATE BETWEEN c1.fecha_inicio AND c1.fecha_fin
    ) c ON p.id = c.propiedad_id
    LEFT JOIN inquilinos i ON c.inquilino_id = i.id
    ORDER BY p.created_at DESC
");
$stmt->execute();
$propiedades = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row mb-4">
    <div class="col">
        <h2>Propiedades</h2>
    </div>
    <div class="col text-end">
        <a href="https://www.montevideo.gub.uy/fwtc/pages/tributosDomiciliarios.xhtml" target="_blank" class="btn btn-info me-2">
            <i class="bi bi-building"></i> Tributos Domiciliarios
        </a>
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
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Inquilino</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($propiedades as $propiedad): ?>
            <tr class="cursor-pointer" onclick='cargarYMostrarDetallePropiedad(<?php echo $propiedad['id']; ?>)'>
                <td><?php echo htmlspecialchars($propiedad['id']); ?></td>
                <td><?php echo htmlspecialchars($propiedad['nombre'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($propiedad['tipo']); ?></td>
                <td>$<?php echo number_format($propiedad['precio'], 2); ?></td>
                <td>
                    <span class="badge <?php echo $propiedad['estado'] == 'Disponible' ? 'bg-success' : ($propiedad['estado'] == 'Alquilado' ? 'bg-warning' : ($propiedad['estado'] == 'Reservado' ? 'bg-info' : ($propiedad['estado'] == 'En venta' ? 'bg-primary' : 'bg-secondary'))); ?>">
                        <?php echo htmlspecialchars($propiedad['estado']); ?>
                    </span>
                </td>
                <td>
                    <?php if ($propiedad['estado'] == 'Alquilado' && $propiedad['inquilino_actual']): ?>
                        <?php echo htmlspecialchars($propiedad['inquilino_actual']); ?>
                    <?php else: ?>
                        <span class="text-muted">-</span>
                    <?php endif; ?>
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
                <form id="formPropiedad" enctype="multipart/form-data">
                    <input type="hidden" id="propiedad_id" name="id">
                    
                    <div class="mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-select" id="tipo" name="tipo" required onchange="mostrarOcultarCamposLocal()">
                            <option value="Departamento">Departamento</option>
                            <option value="Casa">Casa</option>
                            <option value="Local">Local</option>
                            <option value="Cochera">Cochera</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la propiedad</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" maxlength="255">
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
                        <label for="precio" class="form-label">Precio $</label>
                        <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
                    </div>
                    
                    <div id="camposGastosComunes" style="display:none">
                        <div class="mb-3">
                            <label for="gastos_comunes" class="form-label">Gastos Comunes $</label>
                            <input type="number" class="form-control" id="gastos_comunes" name="gastos_comunes" step="0.01" value="0.00">
                        </div>

                        <div class="mb-3">
                            <label for="contribucion_inmobiliaria_cc" class="form-label">Contribución Inmobiliaria CC</label>
                            <input type="number" class="form-control" id="contribucion_inmobiliaria_cc" name="contribucion_inmobiliaria_cc" value="0" min="0" step="1">
                        </div>

                        <div class="mb-3">
                            <label for="contribucion_inmobiliaria_padron" class="form-label">Contribución Inmobiliaria Padrón</label>
                            <input type="number" class="form-control" id="contribucion_inmobiliaria_padron" name="contribucion_inmobiliaria_padron" value="0" min="0" step="1">
                        </div>
                    </div>
                        
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="Disponible">Disponible</option>
                            <option value="Alquilado">Alquilado</option>
                            <option value="Reservado">Reservado</option>
                            <option value="En venta">En venta</option>
                            <option value="Vendido">Vendido</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="caracteristicas" class="form-label">Características</label>
                        <textarea class="form-control" id="caracteristicas" name="caracteristicas" rows="3"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="imagenes" class="form-label">Imágenes de la Propiedad</label>
                        <input type="file" class="form-control" id="imagenes" name="imagenes[]" accept="image/*" multiple>
                        <div class="form-text">Formatos permitidos: JPG, JPEG, PNG. Tamaño máximo por imagen: 5MB</div>
                    </div>
                    
                    <div id="previewImagenes" class="mb-3"></div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger me-auto" onclick="eliminarPropiedad()">Eliminar</button>
                <button type="button" id="btnCrearContrato" class="btn btn-success me-2 d-none" onclick="crearContratoDesdePropiedad()">Crear Contrato</button>
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
#previewImagenes {
    display: flex;
    flex-direction: row;
    overflow-x: auto;
    gap: 8px;
    padding-bottom: 8px;
}
</style>

<script>
let imagenesGuardadas = [];

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

// Función para mostrar/ocultar el botón de crear contrato según el estado de la propiedad
function actualizarBotonCrearContrato(propiedad) {
    const btnCrearContrato = document.getElementById('btnCrearContrato');
    
    // Mostrar el botón solo si la propiedad está disponible y no tiene contrato vigente
    if (propiedad.estado === 'Disponible') {
        btnCrearContrato.classList.remove('d-none');
    } else {
        btnCrearContrato.classList.add('d-none');
    }
}

// Función para crear un contrato desde la propiedad
function crearContratoDesdePropiedad() {
    const propiedadId = document.getElementById('propiedad_id').value;
    
    // Cerrar el modal de propiedad
    const modalPropiedad = bootstrap.Modal.getInstance(document.getElementById('modalPropiedad'));
    if (modalPropiedad) {
        modalPropiedad.hide();
    }
    
    // Cargar el módulo de contratos y abrir el modal de nuevo contrato
    if (typeof cargarModulo === 'function') {
        cargarModulo('contratos', function() {
            // Una vez cargado el módulo de contratos, abrir el modal con la propiedad preseleccionada
            if (typeof nuevoContrato === 'function') {
                nuevoContrato(propiedadId);
            }
        });
    }
}

// Modificar la función mostrarDetallePropiedad para incluir la actualización del botón
function mostrarDetallePropiedad(propiedad) {
    document.getElementById('propiedad_id').value = propiedad.id;
    document.getElementById('nombre').value = propiedad.nombre || '';
    document.getElementById('direccion').value = propiedad.direccion;
    document.getElementById('tipo').value = propiedad.tipo;
    document.getElementById('precio').value = propiedad.precio;
    document.getElementById('estado').value = propiedad.estado;
    document.getElementById('caracteristicas').value = propiedad.caracteristicas || '';
    document.getElementById('galeria').value = propiedad.galeria || '';
    document.getElementById('local').value = propiedad.local || '';
    
    // Guardar imágenes originales
    imagenesGuardadas = Array.isArray(propiedad.imagenes) ? propiedad.imagenes : [];
    mostrarPreviewImagenesGuardadas();
    
    // Actualizar título y mostrar botón de eliminar
    document.querySelector('#modalPropiedad .modal-title').textContent = 'Detalles de la Propiedad';
    document.querySelector('#modalPropiedad .btn-danger').style.display = 'block';
    
    // Actualizar el botón de crear contrato
    actualizarBotonCrearContrato(propiedad);
    
    // Mostrar el modal
    new bootstrap.Modal(document.getElementById('modalPropiedad')).show();
    
    // Verificar campos Local
    mostrarOcultarCamposLocal();
}

function mostrarPreviewImagenesGuardadas() {
    const preview = document.getElementById('previewImagenes');
    preview.innerHTML = '';
    if (imagenesGuardadas.length > 0) {
        imagenesGuardadas.forEach(function(img) {
            preview.innerHTML += `<img src="uploads/propiedades/${img}" class="img-thumbnail me-2 mb-2" style="max-width:120px;max-height:120px;">`;
        });
    }
}

// Asegurarse de que los campos se actualicen cuando se abre el modal
document.getElementById('modalPropiedad').addEventListener('shown.bs.modal', mostrarOcultarCamposLocal);

function cargarYMostrarDetallePropiedad(id) {
    fetch('modules/propiedades/actions.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=get&id=' + encodeURIComponent(id)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            mostrarDetallePropiedad(data.data);
        } else {
            alert('No se pudo cargar la información de la propiedad.');
        }
    })
    .catch(() => alert('Error de red al cargar la propiedad.'));
}

// Vista previa instantánea de imágenes seleccionadas
const inputImagenes = document.getElementById('imagenes');
const previewImagenes = document.getElementById('previewImagenes');
if (inputImagenes) {
    inputImagenes.addEventListener('change', function() {
        // Mostrar primero las imágenes guardadas
        mostrarPreviewImagenesGuardadas();
        // Luego, agregar las nuevas seleccionadas
        if (this.files && this.files.length > 0) {
            Array.from(this.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail me-2 mb-2';
                        img.style.maxWidth = '120px';
                        img.style.maxHeight = '120px';
                        previewImagenes.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
}

function guardarPropiedad() {
    const form = document.getElementById('formPropiedad');
    const formData = new FormData(form);

    // Determinar si es create o update
    const id = document.getElementById('propiedad_id').value;
    formData.append('action', id ? 'update' : 'create');
    if (id) formData.append('id', id);

    fetch('modules/propiedades/actions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Cerrar modal y mostrar la sección de Propiedades
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalPropiedad'));
            if (modal) modal.hide();
            if (typeof cargarModulo === 'function') {
                cargarModulo('propiedades');
            }
        } else {
            alert(data.message || 'Error al guardar la propiedad');
        }
    })
    .catch(() => alert('Error de red al guardar la propiedad'));
}

document.getElementById('formPropiedad').addEventListener('submit', function(e) {
    e.preventDefault();
    guardarPropiedad();
});

$(document).ready(function() {
    // Función para mostrar/ocultar campos según el tipo de propiedad
    function toggleFields() {
        var tipo = $('#tipo').val();
        if (tipo === 'Cochera') {
            $('#camposGastosComunes').hide();
        } else {
            $('#camposGastosComunes').show();
        }
    }

    // Ejecutar al cargar la página
    toggleFields();

    // Ejecutar cuando cambie el tipo de propiedad
    $('#tipo').change(toggleFields);
});
</script>