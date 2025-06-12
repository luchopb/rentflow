<?php
require_once 'config.php';
check_login();
$page_title = 'Inquilinos - Inmobiliaria';

$edit_id = intval($_GET['edit'] ?? 0);
$delete_id = intval($_GET['delete'] ?? 0);
$message = '';
$errors = [];
$inquilino_id = 0; // Initialize inquilino_id at the start

// Verificar si se debe mostrar el formulario de nuevo inquilino
$show_form = isset($_GET['add']) && $_GET['add'] === 'true';

if ($delete_id) {
  $pdo->prepare("DELETE FROM inquilinos WHERE id = ?")->execute([$delete_id]);
  $message = "Inquilino eliminado correctamente.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = clean_input($_POST['nombre'] ?? '');
  $cedula = clean_input($_POST['cedula'] ?? '');
  $telefono = clean_input($_POST['telefono'] ?? '');
  $vehiculo = clean_input($_POST['vehiculo'] ?? '');
  $matricula = clean_input($_POST['matricula'] ?? '');
  $documentos_subidos = [];

  // Documentos anteriores
  $documentos_anteriores = json_decode($_POST['existing_docs'] ?? '[]', true);
  if (!is_array($documentos_anteriores)) $documentos_anteriores = [];

  // Manejo archivos adjuntos documentos
  if (!empty($_FILES['documentos']['name'][0])) {
    $upload_dir = __DIR__ . '/uploads/';
    if (!file_exists($upload_dir)) {
      mkdir($upload_dir, 0755, true);
    }
    foreach ($_FILES['documentos']['name'] as $k => $name) {
      $tmp_name = $_FILES['documentos']['tmp_name'][$k];
      $basename = uniqid() . '-' . basename($name);
      if (move_uploaded_file($tmp_name, $upload_dir . $basename)) {
        $documentos_subidos[] = $basename;
      } else {
        $errors[] = "Error al subir el documento: $name";
      }
    }
  }

  if (!$nombre) $errors[] = "El nombre es obligatorio.";
  if (!$cedula) $errors[] = "La cédula de identidad es obligatoria.";

  if (empty($errors)) {
    $todos_docs = array_merge($documentos_anteriores, $documentos_subidos);
    $docs_json = json_encode($todos_docs);

    if (isset($_POST['edit_id']) && intval($_POST['edit_id']) > 0) {
      $edit_id = intval($_POST['edit_id']);
      $fecha_modificacion = date('Y-m-d H:i:s'); // Fecha y hora actual
      $stmt = $pdo->prepare("UPDATE inquilinos SET nombre=?, cedula=?, telefono=?, vehiculo=?, matricula=?, documentos=?, fecha_modificacion=? WHERE id=?");
      $stmt->execute([$nombre, $cedula, $telefono, $vehiculo, $matricula, $docs_json, $fecha_modificacion, $edit_id]);
      $message = "Inquilino actualizado correctamente.";
      $inquilino_id = $edit_id; // Set inquilino_id to the edited ID
    } else {
      $usuario_id = $_SESSION['user_id'];
      $fecha_creacion = date('Y-m-d H:i:s');
      $stmt = $pdo->prepare("INSERT INTO inquilinos (nombre, cedula, telefono, vehiculo, matricula, documentos, usuario_id, fecha_creacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->execute([$nombre, $cedula, $telefono, $vehiculo, $matricula, $docs_json, $usuario_id, $fecha_creacion]);
      $message = "Inquilino creado correctamente.";
      $inquilino_id = $pdo->lastInsertId(); // Obtener el ID del nuevo inquilino
    }

    // Redirect before any output
    header("Location: inquilinos.php?msg=" . urlencode($message) . "&inquilino_id=" . $inquilino_id);
    exit();
  } else {
    $edit_data = [
      'nombre' => $nombre,
      'cedula' => $cedula,
      'telefono' => $telefono,
      'vehiculo' => $vehiculo,
      'matricula' => $matricula,
      'documentos_arr' => array_merge($documentos_anteriores, $documentos_subidos)
    ];
    $edit_id = intval($_POST['edit_id'] ?? 0);
  }
} else if ($edit_id) {
  $stmt = $pdo->prepare("SELECT * FROM inquilinos WHERE id = ?");
  $stmt->execute([$edit_id]);
  $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($edit_data) {
    $edit_data['documentos_arr'] = json_decode($edit_data['documentos'], true) ?: [];
  } else {
    $edit_id = 0;
    $edit_data = null;
  }
} else {
  $edit_data = null;
}

$msg = $_GET['msg'] ?? '';
if ($msg) {
  $message = $msg;
}

$inquilino_id = intval($_GET['inquilino_id'] ?? 0);

$inquilinos = $pdo->query("SELECT * FROM inquilinos ORDER BY id DESC")->fetchAll();

include 'includes/header_nav.php';
?>

<main class="container container-main py-4">

  <h1>Inquilinos</h1>

  <?php if ($msg): ?>
    <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
    <?php if ($inquilino_id > 0): ?>
      <a href="contratos.php?inquilino_id=<?= $inquilino_id ?>" class="btn btn-success mb-3">Crear Contrato</a>
    <?php endif; ?>
  <?php endif; ?>
  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <ul><?php foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?></ul>
    </div>
  <?php endif; ?>

  <button class="btn btn-outline-dark mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formInquilinoCollapse" aria-expanded="<?= $show_form || $edit_id || !empty($errors) ? 'true' : 'false' ?>" aria-controls="formInquilinoCollapse" style="font-weight:600;">
    <?= $show_form || $edit_id || !empty($errors) ? 'Ocultar' : 'Agregar Nuevo Inquilino' ?>
  </button>

  <div class="collapse <?= $show_form || $edit_id || !empty($errors) ? 'show' : '' ?>" id="formInquilinoCollapse">
    <div class="card p-4 mb-4 mt-3">
      <h3><?= $edit_id ? "Editar Inquilino" : "Nuevo Inquilino" ?></h3>
      <form method="POST" enctype="multipart/form-data" novalidate>
        <input type="hidden" name="edit_id" value="<?= $edit_id ?: '' ?>" />
        <input type="hidden" name="existing_docs" id="existing_docs" value='<?= htmlspecialchars(json_encode($edit_data['documentos_arr'] ?? [])) ?>' />

        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre *</label>
          <input type="text" class="form-control" id="nombre" name="nombre" required value="<?= htmlspecialchars($edit_data['nombre'] ?? '') ?>" />
        </div>
        <div class="mb-3">
          <label for="cedula" class="form-label">Cédula de Identidad *</label>
          <input type="number" class="form-control" id="cedula" name="cedula" required value="<?= htmlspecialchars($edit_data['cedula'] ?? '') ?>" />
        </div>
        <div class="mb-3">
          <label for="telefono" class="form-label">Teléfono</label>
          <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($edit_data['telefono'] ?? '') ?>" />
        </div>
        <div class="mb-3">
          <label for="vehiculo" class="form-label">Vehículo</label>
          <input type="text" class="form-control" id="vehiculo" name="vehiculo" value="<?= htmlspecialchars($edit_data['vehiculo'] ?? '') ?>" />
        </div>
        <div class="mb-3">
          <label for="matricula" class="form-label">Matrícula</label>
          <input type="text" class="form-control" id="matricula" name="matricula" value="<?= htmlspecialchars($edit_data['matricula'] ?? '') ?>" />
        </div>

        <div class="mb-3">
          <label for="documentos" class="form-label">Adjuntar Documentos</label>
          <input type="file" name="documentos[]" multiple class="form-control" />
        </div>

        <?php if (!empty($edit_data['documentos_arr'])): ?>
          <div class="mb-3" id="doc-preview-container">
            <label class="form-label">Documentos adjuntos</label>
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

        <button type="submit" class="btn btn-primary fw-semibold"><?= $edit_id ? "Actualizar" : "Guardar" ?></button>
        <?php if ($edit_id): ?>
          <a href="inquilinos.php" class="btn btn-outline-secondary ms-2">Cancelar</a>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <section>
    <h2 class="fw-semibold mb-3">Listado de Inquilinos</h2>
    <?php if (count($inquilinos) === 0): ?>
      <p>No hay inquilinos registrados.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table align-middle table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Datos</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($inquilinos as $i): ?>
              <tr>
                <td><?= htmlspecialchars($i['id']) ?></td>
                <td><a href="inquilinos.php?edit=<?= intval($i['id']) ?>" class="text-decoration-none text-dark"><b><?= htmlspecialchars($i['nombre']) ?></b><br> <?= htmlspecialchars($i['cedula']) ?></a></td>
                <td>
                  <?= htmlspecialchars($i['telefono']) ?><br>
                  <?= htmlspecialchars($i['vehiculo']) ?>
                  <?= htmlspecialchars($i['matricula']) ?>
                </td>
                <!--<td style="min-width:120px;">
                  <a href="inquilinos.php?edit=<?= intval($i['id']) ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                  <a href="inquilinos.php?delete=<?= intval($i['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que desea eliminar este inquilino?')">Eliminar</a>
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
  const collapseInquilino = document.getElementById('formInquilinoCollapse');
  const toggleBtnInquilino = document.querySelector('button[data-bs-target="#formInquilinoCollapse"]');
  collapseInquilino.addEventListener('show.bs.collapse', () => toggleBtnInquilino.textContent = 'Ocultar');
  collapseInquilino.addEventListener('hide.bs.collapse', () => toggleBtnInquilino.textContent = 'Agregar Nuevo Inquilino');

  function removeDoc(doc) {
    let container = document.getElementById('doc-preview-container');
    let docsValue = JSON.parse(document.getElementById('existing_docs').value);
    docsValue = docsValue.filter(i => i !== doc);
    document.getElementById('existing_docs').value = JSON.stringify(docsValue);
    let elem = container.querySelector('[data-doc="' + doc + '"]');
    if (elem) elem.remove();
  }
</script>

<?php
include 'includes/footer.php';
?>