<?php
require_once 'config.php';
check_login();
$page_title = 'Propiedades - Inmobiliaria';
include 'includes/header_nav.php';

$edit_id = intval($_GET['edit'] ?? 0);
$search = clean_input($_GET['search'] ?? '');

// Manejo eliminación propiedad
$delete_id = intval($_GET['delete'] ?? 0);
$message = '';
if ($delete_id) {
  // Borrar imágenes asociadas
  $upload_dir = __DIR__ . '/uploads/';
  $stmt = $pdo->prepare("SELECT imagenes FROM propiedades WHERE id = ?");
  $stmt->execute([$delete_id]);
  $row = $stmt->fetch();
  if ($row) {
    $images = json_decode($row['imagenes'], true);
    if (is_array($images)) {
      foreach ($images as $img) {
        $file = $upload_dir . basename($img);
        if (is_file($file)) unlink($file);
      }
    }
    // Borrar propiedad
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
  $estado = $_POST['estado'] ?? 'disponible';
  $garantia = floatval($_POST['garantia'] ?? 0);
  $corredor = clean_input($_POST['corredor'] ?? '');
  $anep = clean_input($_POST['anep'] ?? '');
  $contribucion_inmobiliaria = floatval($_POST['contribucion_inmobiliaria'] ?? 0);
  $comentarios = clean_input($_POST['comentarios'] ?? '');

  $gallery_images = [];
  if (isset($_POST['existing_images'])) {
    $gallery_images = json_decode($_POST['existing_images'], true);
    if (!is_array($gallery_images)) $gallery_images = [];
  }
  if (!empty($_FILES['imagenes']['name'][0])) {
    $upload_dir = __DIR__ . '/uploads/';
    if (!file_exists($upload_dir)) {
      mkdir($upload_dir, 0755, true);
    }
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

  $errors = [];
  if (!$nombre) {
    $errors[] = "El nombre es obligatorio.";
  }
  if (!$tipo) {
    $errors[] = "El tipo es obligatorio.";
  }
  if (!$direccion) {
    $errors[] = "La dirección es obligatoria.";
  }
  if (!$estado || !in_array($estado, ['libre', 'alquilado', 'uso propio', 'enventa'])) {
    $estado = 'libre';
  }

  if (empty($errors)) {
    $imagenes_db = json_encode($gallery_images);
    if ($edit_id > 0) {
      $stmt = $pdo->prepare("UPDATE propiedades SET nombre=?, tipo=?, direccion=?, imagenes=?, galeria=?, local=?, precio=?, incluye_gc=?, gastos_comunes=?, estado=?, garantia=?, corredor=?, anep=?, contribucion_inmobiliaria=?, comentarios=? WHERE id=?");
      $stmt->execute([$nombre, $tipo, $direccion, $imagenes_db, $galeria, $local, $precio, $incluye_gc, $gastos_comunes, $estado, $garantia, $corredor, $anep, $contribucion_inmobiliaria, $comentarios, $edit_id]);
      $message = "Propiedad actualizada correctamente.";
    } else {
      $stmt = $pdo->prepare("INSERT INTO propiedades (nombre,tipo,direccion,imagenes,galeria,local,precio,incluye_gc,gastos_comunes,estado,garantia,corredor,anep,contribucion_inmobiliaria,comentarios) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $stmt->execute([$nombre, $tipo, $direccion, $imagenes_db, $galeria, $local, $precio, $incluye_gc, $gastos_comunes, $estado, $garantia, $corredor, $anep, $contribucion_inmobiliaria, $comentarios]);
      $message = "Propiedad creada correctamente.";
    }
    header("Location: propiedades.php?msg=" . urlencode($message));
    exit();
  } else {
    $edit_data = [
      'nombre' => $nombre,
      'tipo' => $tipo,
      'direccion' => $direccion,
      'galeria' => $galeria,
      'local' => $local,
      'precio' => $precio,
      'incluye_gc' => $incluye_gc,
      'gastos_comunes' => $gastos_comunes,
      'estado' => $estado,
      'anep' => $anep,
      'contribucion_inmobiliaria' => $contribucion_inmobiliaria,
      'comentarios' => $comentarios,
      'imagenes_arr' => $gallery_images,
    ];
    $edit_id = $edit_id;
  }
} else {
  $edit_data = null;
  if ($edit_id) {
    $stmt = $pdo->prepare("SELECT * FROM propiedades WHERE id = ?");
    $stmt->execute([$edit_id]);
    $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($edit_data) {
      $edit_data['imagenes_arr'] = json_decode($edit_data['imagenes'], true) ?: [];
    }
  }
}

function estado_label($e)
{
  return match ($e) {
    'libre' => 'Libre',
    'alquilado' => 'Alquilado',
    'enventa' => 'En venta',
    'usopropio' => 'Uso propio',
    default => ucfirst($e)
  };
}

// Consulta con búsqueda
$search = clean_input($_GET['search'] ?? '');
$params = [];
$sql = "SELECT p.*, c.id AS contrato_id, i.nombre AS inquilino_nombre 
        FROM propiedades p 
        LEFT JOIN contratos c ON c.propiedad_id = p.id 
          AND c.estado = 'activo' 
          AND CURDATE() BETWEEN c.fecha_inicio AND c.fecha_fin 
        LEFT JOIN inquilinos i ON c.inquilino_id = i.id";
if ($search) {
  $sql .= " WHERE p.nombre LIKE ? OR p.direccion LIKE ? OR p.local LIKE ? OR i.nombre LIKE ?";
  $like_search = '%' . $search . '%';
  $params = [$like_search, $like_search, $like_search, $like_search];
}
$sql .= " ORDER BY p.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$propiedades = $stmt->fetchAll();
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
        value="<?= htmlspecialchars($search) ?>"
        aria-label="Buscar propiedades" autocomplete="off" />
      <button class="btn btn-primary" type="submit" aria-label="Buscar">
        Buscar
      </button>
      <?php if ($search): ?>
        <a href="propiedades.php" class="btn btn-outline-secondary" aria-label="Limpiar búsqueda">Limpiar</a>
      <?php endif; ?>
    </div>
  </form>

  <button class="btn btn-outline-dark mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formPropiedadCollapse" aria-expanded="<?= $edit_id || !empty($errors) ? 'true' : 'false' ?>" aria-controls="formPropiedadCollapse" style="font-weight:600;">
    <?= $edit_id || !empty($errors) ? 'Ocultar' : 'Agregar Nueva Propiedad' ?>
  </button>

  <div class="collapse <?= $edit_id || !empty($errors) ? 'show' : '' ?>" id="formPropiedadCollapse">
    <div class="card p-4 mb-4 mt-3">
      <h3><?= $edit_id ? "Editar Propiedad" : "Nueva Propiedad" ?></h3>
      <form method="POST" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="edit_id" value="<?= $edit_id ?: '' ?>" />
        <input type="hidden" name="existing_images" id="existing_images" value='<?= htmlspecialchars(json_encode($edit_data['imagenes_arr'] ?? [])) ?>' />

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
              'en venta' => 'En venta',
              'uso propio' => 'Uso propio'
            ];
            foreach ($estados as $key => $val) {
              $sel = ($edit_data['estado'] ?? '') === $key ? "selected" : "";
              echo "<option value=\"$key\" $sel>$val</option>";
            }
            ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="anep" class="form-label">ANEP</label>
          <input type="text" class="form-control" id="anep" name="anep" value="<?= htmlspecialchars($edit_data['anep'] ?? '') ?>" />
        </div>

        <div class="mb-3">
          <label for="contribucion_inmobiliaria" class="form-label">Contribución Inmobiliaria</label>
          <input type="number" class="form-control" step="0.01" id="contribucion_inmobiliaria" name="contribucion_inmobiliaria" value="<?= htmlspecialchars($edit_data['contribucion_inmobiliaria'] ?? '') ?>" />
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

        <button type="submit" class="btn btn-primary fw-semibold"><?= $edit_id ? "Actualizar" : "Guardar" ?></button>
        <?php if ($edit_id): ?>
          <a href="propiedades.php" class="btn btn-outline-secondary ms-2">Cancelar</a>
        <?php endif; ?>
      </form>
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
              <th>Nombre</th>
              <th>Tipo</th>
              <th>Dirección</th>
              <th>Precio</th>
              <th>Estado</th>
              <th>Contrato</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($propiedades as $p): ?>
              <tr>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td><?= htmlspecialchars($p['tipo']) ?></td>
                <td><?= htmlspecialchars($p['direccion']) ?></td>
                <td>$ <?= number_format($p['precio'], 2, ",", ".") ?></td>
                <td><?= estado_label($p['estado']) ?></td>
                <td>
                  <?php if ($p['contrato_id'] && $p['inquilino_nombre']): ?>
                    <?= htmlspecialchars($p['inquilino_nombre']) ?>
                  <?php else: ?>
                    <a href="contratos.php?propiedad_id=<?= intval($p['id']) ?>" class="btn btn-sm btn-outline-success" style="white-space: nowrap;">Crear contrato</a>
                  <?php endif; ?>
                </td>
                <td>
                  <a href="propiedades.php?edit=<?= intval($p['id']) ?>" class="btn btn-sm btn-outline-primary me-1">Editar</a>
                  <a href="propiedades.php?delete=<?= intval($p['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que desea eliminar esta propiedad?')">Eliminar</a>
                </td>
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

  const collapseEl = document.getElementById('formPropiedadCollapse');
  const toggleBtn = document.querySelector('button[data-bs-toggle="collapse"]');
  collapseEl.addEventListener('show.bs.collapse', () => toggleBtn.textContent = 'Ocultar');
  collapseEl.addEventListener('hide.bs.collapse', () => toggleBtn.textContent = 'Agregar Nueva Propiedad');
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php
include 'includes/footer.php';
?>