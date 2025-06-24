<?php
require_once 'config.php';
check_login();
$page_title = 'Propiedades - Inmobiliaria';

$edit_id = intval($_GET['edit'] ?? 0);
$delete_id = intval($_GET['delete'] ?? 0);
$message = '';
$errors = [];
$busqueda = clean_input($_GET['search'] ?? '');

// Verificar si se debe mostrar el formulario de nueva propiedad
$show_form = isset($_GET['add']) && $_GET['add'] === 'true';

if ($delete_id) {
  $upload_dir = __DIR__ . '/uploads/';
  $stmt = $pdo->prepare("SELECT imagenes, documentos FROM propiedades WHERE id = ?");
  $stmt->execute([$delete_id]);
  $row = $stmt->fetch();
  if ($row) {
    $images = json_decode($row['imagenes'], true);
    $docs = json_decode($row['documentos'], true);
    foreach ([$images, $docs] as $files) {
      if (is_array($files)) {
        foreach ($files as $file) {
          $path = $upload_dir . basename($file);
          if (is_file($path)) unlink($path);
        }
      }
    }
    $pdo->prepare("DELETE FROM propiedades WHERE id = ?")->execute([$delete_id]);
    $message = "Propiedad eliminada correctamente.";
  }
}

$msg = $_GET['msg'] ?? '';
if ($msg) {
  $message = $msg;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $edit_id = intval($_POST['edit_id'] ?? 0);
  $nombre = clean_input($_POST['nombre'] ?? '');
  $tipo = clean_input($_POST['tipo'] ?? '');
  $direccion = clean_input($_POST['direccion'] ?? '');
  $galeria = clean_input($_POST['galeria'] ?? '');
  $local = clean_input($_POST['local'] ?? '');
  $precio = floatval($_POST['precio'] ?? 0);
  $incluye_gc = isset($_POST['incluye_gc']) && $_POST['incluye_gc'] === '1' ? 1 : 0;
  $gastos_comunes = floatval($_POST['gastos_comunes'] ?? 0);
  $estado = $_POST['estado'] ?? 'libre';
  $anep = clean_input($_POST['anep'] ?? '');
  $contribucion_inmobiliaria = clean_input($_POST['contribucion_inmobiliaria'] ?? '');
  $comentarios = clean_input($_POST['comentarios'] ?? '');
  $ose = clean_input($_POST['ose'] ?? '');
  $ute = clean_input($_POST['ute'] ?? '');
  $padron = clean_input($_POST['padron'] ?? '');
  $imm_tasa_general = clean_input($_POST['imm_tasa_general'] ?? '');
  $imm_tarifa_saneamiento = clean_input($_POST['imm_tarifa_saneamiento'] ?? '');
  $imm_instalaciones = clean_input($_POST['imm_instalaciones'] ?? '');
  $imm_adicional_mercantil = clean_input($_POST['imm_adicional_mercantil'] ?? '');
  $convenios = clean_input($_POST['convenios'] ?? '');

  $gallery_images = json_decode($_POST['existing_images'] ?? '[]', true) ?: [];
  $attached_docs = json_decode($_POST['existing_docs'] ?? '[]', true) ?: [];

  $upload_dir = __DIR__ . '/uploads/';
  if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0755, true);
  }

  if (!empty($_FILES['imagenes']['name'][0])) {
    foreach ($_FILES['imagenes']['name'] as $k => $name) {
      $tmp_name = $_FILES['imagenes']['tmp_name'][$k];
      $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
      if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
        $errors[] = "Solo se permiten imágenes jpg, jpeg, png o gif.";
        break;
      }
      $basename = uniqid() . '.' . $ext;
      if (move_uploaded_file($tmp_name, $upload_dir . $basename)) {
        $gallery_images[] = $basename;
      } else {
        $errors[] = "Error al subir la imagen: $name";
      }
    }
  }

  if (!empty($_FILES['documentos']['name'][0])) {
    foreach ($_FILES['documentos']['name'] as $k => $name) {
      $tmp_name = $_FILES['documentos']['tmp_name'][$k];
      $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
      $basename = uniqid('doc_') . '.' . $ext;
      if (move_uploaded_file($tmp_name, $upload_dir . $basename)) {
        $attached_docs[] = $basename;
      } else {
        $errors[] = "Error al subir el documento: $name";
      }
    }
  }

  if (!$nombre) $errors[] = "El nombre es obligatorio.";
  if (!$tipo) $errors[] = "El tipo es obligatorio.";
  if (!$direccion) $errors[] = "La dirección es obligatoria.";
  if (!$estado || !in_array($estado, ['libre', 'alquilado', 'uso propio', 'en venta'])) $estado = 'libre';

  if (empty($errors)) {
    $imagenes_db = json_encode($gallery_images);
    $documentos_db = json_encode($attached_docs);
    $usuario_id = $_SESSION['user_id'];
    $fecha_hora = date('Y-m-d H:i:s');

    if ($edit_id > 0) {
      $stmt = $pdo->prepare("UPDATE propiedades SET nombre=?, tipo=?, direccion=?, imagenes=?, documentos=?, galeria=?, local=?, precio=?, incluye_gc=?, gastos_comunes=?, estado=?, anep=?, contribucion_inmobiliaria=?, comentarios=?, ose=?, ute=?, padron=?, imm_tasa_general=?, imm_tarifa_saneamiento=?, imm_instalaciones=?, imm_adicional_mercantil=?, convenios=?, usuario_id=?, fecha_modificacion=? WHERE id=?");
      $stmt->execute([$nombre, $tipo, $direccion, $imagenes_db, $documentos_db, $galeria, $local, $precio, $incluye_gc, $gastos_comunes, $estado, $anep, $contribucion_inmobiliaria, $comentarios, $ose, $ute, $padron, $imm_tasa_general, $imm_tarifa_saneamiento, $imm_instalaciones, $imm_adicional_mercantil, $convenios, $usuario_id, $fecha_hora, $edit_id]);
      $message = "Propiedad actualizada correctamente.";
    } else {
      $stmt = $pdo->prepare("INSERT INTO propiedades (nombre,tipo,direccion,imagenes,documentos,galeria,local,precio,incluye_gc,gastos_comunes,estado,anep,contribucion_inmobiliaria,comentarios,ose,ute,padron,imm_tasa_general,imm_tarifa_saneamiento,imm_instalaciones,imm_adicional_mercantil,convenios,usuario_id,fecha_creacion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $stmt->execute([$nombre, $tipo, $direccion, $imagenes_db, $documentos_db, $galeria, $local, $precio, $incluye_gc, $gastos_comunes, $estado, $anep, $contribucion_inmobiliaria, $comentarios, $ose, $ute, $padron, $imm_tasa_general, $imm_tarifa_saneamiento, $imm_instalaciones, $imm_adicional_mercantil, $convenios, $usuario_id, $fecha_hora]);
      $message = "Propiedad creada correctamente.";
    }
    header("Location: propiedades.php?msg=" . urlencode($message));
    exit();
  } else {
    $edit_data = compact('nombre', 'tipo', 'direccion', 'galeria', 'local', 'precio', 'incluye_gc', 'gastos_comunes', 'estado', 'anep', 'contribucion_inmobiliaria', 'comentarios', 'ose', 'ute', 'padron', 'imm_tasa_general', 'imm_tarifa_saneamiento', 'imm_instalaciones', 'imm_adicional_mercantil', 'convenios');
    $edit_data['imagenes_arr'] = $gallery_images;
    $edit_data['documentos_arr'] = $attached_docs;
  }
} else {
  $edit_data = null;
  if ($edit_id) {
    $stmt = $pdo->prepare("SELECT * FROM propiedades WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($edit_data) {
      $edit_data['imagenes_arr'] = json_decode($edit_data['imagenes'], true) ?: [];
      $edit_data['documentos_arr'] = json_decode($edit_data['documentos'], true) ?: [];
    }
  }
}

// Añadimos función estado_label con badges coloreados
function estado_label($e)
{
  switch ($e) {
    case 'libre':
      return '<span class="badge bg-danger">Libre</span>';
    case 'alquilado':
      return '<span class="badge bg-success">Alquilado</span>';
    case 'uso propio':
      return '<span class="badge bg-info">Uso Propio</span>';
    case 'en venta':
      return '<span class="badge bg-warning text-dark">En Venta</span>';
    default:
      return ucfirst($e);
  }
}

// Consulta con búsqueda
$busqueda = clean_input($_GET['search'] ?? '');
$params = [];
$sql = "SELECT p.*, c.id AS contrato_id, i.nombre AS inquilino_nombre, i.id AS inquilino_id
        FROM propiedades p 
        LEFT JOIN contratos c ON c.propiedad_id = p.id 
          AND c.estado = 'activo' 
          AND CURDATE() BETWEEN c.fecha_inicio AND c.fecha_fin 
        LEFT JOIN inquilinos i ON c.inquilino_id = i.id";
if ($busqueda) {
  $sql .= " WHERE p.nombre LIKE ? OR p.direccion LIKE ? OR p.local LIKE ? OR i.nombre LIKE ?";
  $like_search = '%' . $busqueda . '%';
  $params = [$like_search, $like_search, $like_search, $like_search];
}
$sql .= " ORDER BY p.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$propiedades = $stmt->fetchAll();


include 'includes/header_nav.php';

?>

<main class="container container-main py-4">
  <h1>Propiedades</h1>

  <?php if ($message): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <form method="GET" class="mb-4" role="search" aria-label="Buscar propiedades">
    <div class="input-group" style="max-width:480px;">
      <input
        type="search"
        name="search"
        class="form-control"
        placeholder="Buscar por nombre, dirección, local o inquilino"
        value="<?= htmlspecialchars($busqueda) ?>"
        aria-label="Buscar propiedades" autocomplete="off" />
      <button class="btn btn-primary" type="submit" aria-label="Buscar">Buscar</button>
      <?php if ($busqueda): ?>
        <a href="propiedades.php" class="btn btn-outline-secondary" aria-label="Limpiar búsqueda">Limpiar</a>
      <?php endif; ?>
    </div>
  </form>

  <button class="btn btn-outline-dark mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formPropiedadCollapse" aria-expanded="<?= $edit_id || !empty($errors) ? 'true' : 'false' ?>" aria-controls="formPropiedadCollapse" style="font-weight:600;">
    <?= $show_form || $edit_id || !empty($errors) ? 'Ocultar' : 'Agregar Nueva Propiedad' ?>
  </button>

  <div class="collapse <?= $show_form || $edit_id || !empty($errors) ? 'show' : '' ?>" id="formPropiedadCollapse">
    <div class="card mb-4 mt-3">
      <div class="card-header">
        <h5><?= $edit_id? "Editar Propiedad" : "Nueva Propiedad"?></h5>
      </div>
      <div class="card-body">
        <form method="POST" enctype="multipart/form-data" novalidate>
          <input type="hidden" name="edit_id" value="<?= $edit_id ?: '' ?>" />
          <input type="hidden" name="existing_images" id="existing_images" value='<?= htmlspecialchars(json_encode($edit_data['imagenes_arr'] ?? [])) ?>' />
          <input type="hidden" name="existing_docs" id="existing_docs" value='<?= htmlspecialchars(json_encode($edit_data['documentos_arr'] ?? [])) ?>' />

          <!-- Main Data Section - Always visible -->
          <div class="mb-4">
            
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre *</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required value="<?= htmlspecialchars($edit_data['nombre'] ?? '') ?>" />
            </div>

            <div class="mb-3">
              <label for="tipo" class="form-label">Tipo *</label>
              <select class="form-select" id="tipo" name="tipo" required>
                <?php
                $tipos = [
                  'Local' => 'Local',
                  'Apartamento' => 'Apartamento',
                  'Cochera' => 'Cochera',
                  'Depósito' => 'Depósito',
                ];
                foreach ($tipos as $key => $val) {
                  $sel = ($edit_data['tipo'] ?? '') === $key ? "selected" : "";
                  echo "<option value=\"$key\" $sel>$val</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="direccion" class="form-label">Dirección *</label>
              <input type="text" class="form-control" id="direccion" name="direccion" required value="<?= htmlspecialchars($edit_data['direccion'] ?? '') ?>" />
            </div>

            <div class="mb-3">
              <label for="galeria" class="form-label">Galería</label>
              <input type="text" class="form-control" id="galeria" name="galeria" value="<?= htmlspecialchars($edit_data['galeria'] ?? '') ?>" />
            </div>

            <div class="mb-3">
              <label for="local" class="form-label">Local</label>
              <input type="text" class="form-control" id="local" name="local" value="<?= htmlspecialchars($edit_data['local'] ?? '') ?>" />
            </div>

            <div class="mb-3">
              <label for="precio" class="form-label">Precio *</label>
              <input type="number" class="form-control" step="0.01" id="precio" name="precio" required value="<?= htmlspecialchars($edit_data['precio'] ?? '') ?>" />
            </div>

            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="incluye_gc" name="incluye_gc" value="1" <?= ($edit_data['incluye_gc'] ?? 0) ? 'checked' : '' ?>>
              <label class="form-check-label" for="incluye_gc">Incluye gastos comunes</label>
            </div>

            <div class="mb-3">
              <label for="gastos_comunes" class="form-label">Gastos comunes</label>
              <input type="number" class="form-control" step="0.01" id="gastos_comunes" name="gastos_comunes" value="<?= htmlspecialchars($edit_data['gastos_comunes'] ?? '') ?>" />
            </div>

            <div class="mb-3">
              <label for="estado" class="form-label">Estado *</label>
              <select class="form-select" id="estado" name="estado" required>
                <?php
                $estados = [
                  'libre' => 'Libre',
                  'alquilado' => 'Alquilado',
                  'uso propio' => 'Uso Propio',
                  'en venta' => 'En Venta'
                ];
                foreach ($estados as $key => $val) {
                  $sel = ($edit_data['estado'] ?? '') === $key ? "selected" : "";
                  echo "<option value=\"$key\" $sel>$val</option>";
                }
                ?>
              </select>
            </div>

            <div class="mb-3">
              <label for="comentarios" class="form-label">Comentarios</label>
              <textarea class="form-control" id="comentarios" name="comentarios" rows="3"><?= htmlspecialchars($edit_data['comentarios'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Galería de imágenes</label>
              <input type="file" name="imagenes[]" multiple accept="image/*" class="form-control" />
            </div>

            <?php if (!empty($edit_data['imagenes_arr'])): ?>
              <div class="mb-3" id="image-preview-container">
                <?php foreach ($edit_data['imagenes_arr'] as $img): ?>
                  <div class="img-preview" data-img="<?= htmlspecialchars($img) ?>">
                    <button type="button" class="btn-remove-image" title="Eliminar imagen" onclick="removeImage('<?= htmlspecialchars($img) ?>')">&times;</button>
                    <img src="uploads/<?= htmlspecialchars($img) ?>" alt="" style="max-height:80px; max-width:100px; border-radius:0.5rem;" />
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <div class="mb-3">
              <label class="form-label">Documentos adjuntos</label>
              <input type="file" name="documentos[]" multiple class="form-control" />
            </div>

            <?php if (!empty($edit_data['documentos_arr'])): ?>
              <div class="mb-3" id="doc-preview-container">
                <ul class="list-group">
                  <?php foreach ($edit_data['documentos_arr'] as $doc): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center" data-doc="<?= htmlspecialchars($doc) ?>">
                      <a href="uploads/<?= htmlspecialchars($doc) ?>" target="_blank">
                        <?= htmlspecialchars($doc) ?>
                      </a>
                      <button type="button" class="btn btn-sm btn-outline-danger" title="Eliminar documento" onclick="removeDoc('<?= htmlspecialchars($doc) ?>')">&times;</button>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>
          </div>

          <!-- Additional Data Section - In Accordion -->
          <div class="accordion accordion-flush mb-4" id="additionalDataAccordion">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#additionalDataContent">
                  Ver más datos...
                </button>
              </h2>
              <div id="additionalDataContent" class="accordion-collapse collapse" data-bs-parent="#additionalDataAccordion">
                <div class="accordion-body px-1">
                  <div class="mb-3">
                    <label for="ose" class="form-label">OSE</label>
                    <input type="number" class="form-control" id="ose" name="ose" step="1" min="0" value="<?= htmlspecialchars($edit_data['ose'] ?? '') ?>" />
                  </div>

                  <div class="mb-3">
                    <label for="ute" class="form-label">UTE</label>
                    <input type="number" class="form-control" id="ute" name="ute" step="1" min="0" value="<?= htmlspecialchars($edit_data['ute'] ?? '') ?>" />
                  </div>

                  <div class="mb-3">
                    <label for="anep" class="form-label">ANEP</label>
                    <input type="text" class="form-control" id="anep" name="anep" value="<?= htmlspecialchars($edit_data['anep'] ?? '') ?>" />
                  </div>

                  <div class="mb-3">
                    <label for="padron" class="form-label">Padrón</label>
                    <input type="number" class="form-control" id="padron" name="padron" step="1" min="0" value="<?= htmlspecialchars($edit_data['padron'] ?? '') ?>" />
                  </div>

                  <div class="mb-3">
                    <label for="contribucion_inmobiliaria" class="form-label">IMM Contribución Inmobiliaria</label>
                    <input type="number" class="form-control" step="1" id="contribucion_inmobiliaria" name="contribucion_inmobiliaria" value="<?= htmlspecialchars($edit_data['contribucion_inmobiliaria'] ?? '') ?>" />
                  </div>
                  
                  <div class="mb-3">
                    <label for="imm_tasa_general" class="form-label">IMM Tasa general</label>
                    <input type="number" class="form-control" id="imm_tasa_general" name="imm_tasa_general" step="1" min="0" value="<?= htmlspecialchars($edit_data['imm_tasa_general'] ?? '') ?>" />
                  </div>

                  <div class="mb-3">
                    <label for="imm_tarifa_saneamiento" class="form-label">IMM Tarifa de saneamiento</label>
                    <input type="number" class="form-control" id="imm_tarifa_saneamiento" name="imm_tarifa_saneamiento" step="1" min="0" value="<?= htmlspecialchars($edit_data['imm_tarifa_saneamiento'] ?? '') ?>" />
                  </div>

                  <div class="mb-3">
                    <label for="imm_instalaciones" class="form-label">IMM Instalaciones mecánicas eléctricas</label>
                    <input type="number" class="form-control" id="imm_instalaciones" name="imm_instalaciones" step="1" min="0" value="<?= htmlspecialchars($edit_data['imm_instalaciones'] ?? '') ?>" />
                  </div>

                  <div class="mb-3">
                    <label for="imm_adicional_mercantil" class="form-label">IMM Adicional mercantil</label>
                    <input type="number" class="form-control" id="imm_adicional_mercantil" name="imm_adicional_mercantil" step="1" min="0" value="<?= htmlspecialchars($edit_data['imm_adicional_mercantil'] ?? '') ?>" />
                  </div>

                  <div class="mb-3">
                    <label for="convenios" class="form-label">Convenios</label>
                    <input type="number" class="form-control" id="convenios" name="convenios" step="1" min="0" value="<?= htmlspecialchars($edit_data['convenios'] ?? '') ?>" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-primary fw-semibold"><?= $edit_id ? "Actualizar" : "Guardar" ?></button>
          <?php if ($edit_id): ?>
            <a href="propiedades.php" class="btn btn-outline-secondary ms-2">Cancelar</a>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>

  <section>
    <h2 class="fw-semibold mb-3">Listado de Propiedades</h2>
    <?php if (count($propiedades) === 0): ?>
      <p>No hay propiedades registradas.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table align-middle table-striped">
          <thead>
            <tr>
              <td>ID</td>
              <th>Propiedad</th>
              <th>Contrato</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($propiedades as $p): ?>
              <tr>
                <td><?= intval($p['id'])?></td>
                <td>
                  <b><a href="propiedades.php?edit=<?= intval($p['id']) ?>" class="text-decoration-none text-dark">
                      <?= htmlspecialchars($p['nombre']) ?></b> (<?= htmlspecialchars($p['tipo']) ?>)</a><br>
                  <?= htmlspecialchars($p['direccion']) ?><br>
                  <?= estado_label($p['estado']) ?> <small>
                    <nobr>$ <?= number_format($p['precio'], 2, ",", ".") ?></nobr>
                  </small>
                </td>
                <td>
                  <?php if ($p['contrato_id'] && $p['inquilino_nombre']): ?>
                    <a href="inquilinos.php?edit=<?= intval($p['inquilino_id']) ?>" class="text-decoration-none text-dark">
                      <b><?= htmlspecialchars($p['inquilino_nombre']) ?></b>
                    </a><br>
                    <a href="pagos.php?contrato_id=<?= intval($p['contrato_id']) ?>" class="btn btn-sm btn-outline-success">
                      Pagos
                    </a>
                    <a href="contratos.php?edit=<?= intval($p['contrato_id']) ?>" class="btn btn-sm btn-outline-success">
                      Contrato
                    </a>
                  <?php else: ?>
                    <a href="contratos.php?propiedad_id=<?= intval($p['id']) ?>" class="btn btn-success btn-sm" style="white-space: nowrap;">Crear contrato</a>
                  <?php endif; ?>
                </td>
                <!--<td>
                  <a href="propiedades.php?edit=<?= intval($p['id']) ?>" class="btn btn-sm btn-outline-primary me-1">Editar</a>
                  <a href="propiedades.php?delete=<?= intval($p['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que desea eliminar esta propiedad?')">Eliminar</a>
                </td>-->
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>

</main>

<script>
  function removeImage(img) {
    let container = document.getElementById('image-preview-container');
    let imgsValue = JSON.parse(document.getElementById('existing_images').value);
    imgsValue = imgsValue.filter(i => i !== img);
    document.getElementById('existing_images').value = JSON.stringify(imgsValue);
    let elem = container.querySelector('[data-img="' + img + '"]');
    if (elem) elem.remove();
  }

  function removeDoc(doc) {
    let container = document.getElementById('doc-preview-container');
    let docsValue = JSON.parse(document.getElementById('existing_docs').value);
    docsValue = docsValue.filter(i => i !== doc);
    document.getElementById('existing_docs').value = JSON.stringify(docsValue);
    let elem = container.querySelector('[data-doc="' + doc + '"]');
    if (elem) elem.remove();
  }

  const collapseEl = document.getElementById('formPropiedadCollapse');
  const toggleBtn = document.querySelector('button[data-bs-target="#formPropiedadCollapse"]');
  collapseEl.addEventListener('show.bs.collapse', () => toggleBtn.textContent = 'Ocultar');
  collapseEl.addEventListener('hide.bs.collapse', () => toggleBtn.textContent = 'Agregar Nueva Propiedad');
</script>

<?php
include 'includes/footer.php';
?>