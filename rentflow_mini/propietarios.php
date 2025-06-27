<?php
require_once 'config.php';
check_login();
$page_title = 'Propietarios - Inmobiliaria';

$edit_id = intval($_GET['edit'] ?? 0);
$delete_id = intval($_GET['delete'] ?? 0);
$message = '';
$errors = [];
$propietario_id = 0;

// Verificar si se debe mostrar el formulario de nuevo propietario
$show_form = isset($_GET['add']) && $_GET['add'] === 'true';

if ($delete_id) {
  $pdo->prepare("DELETE FROM propietarios WHERE id = ?")->execute([$delete_id]);
  $message = "Propietario eliminado correctamente.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = clean_input($_POST['nombre'] ?? '');

  if (!$nombre) $errors[] = "El nombre es obligatorio.";

  if (empty($errors)) {
    if (isset($_POST['edit_id']) && intval($_POST['edit_id']) > 0) {
      $edit_id = intval($_POST['edit_id']);
      $stmt = $pdo->prepare("UPDATE propietarios SET nombre=? WHERE id=?");
      $stmt->execute([$nombre, $edit_id]);
      $message = "Propietario actualizado correctamente.";
      $propietario_id = $edit_id;
    } else {
      $stmt = $pdo->prepare("INSERT INTO propietarios (nombre) VALUES (?)");
      $stmt->execute([$nombre]);
      $message = "Propietario creado correctamente.";
      $propietario_id = $pdo->lastInsertId();
    }
    header("Location: propietarios.php?msg=" . urlencode($message) . "&propietario_id=" . $propietario_id);
    exit();
  } else {
    $edit_data = [ 'nombre' => $nombre ];
    $edit_id = intval($_POST['edit_id'] ?? 0);
  }
} else if ($edit_id) {
  $stmt = $pdo->prepare("SELECT * FROM propietarios WHERE id = ?");
  $stmt->execute([$edit_id]);
  $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$edit_data) {
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

$propietario_id = intval($_GET['propietario_id'] ?? 0);

$propietarios = $pdo->query("SELECT * FROM propietarios ORDER BY id DESC")->fetchAll();

include 'includes/header_nav.php';
?>

<main class="container container-main py-4">
  <h1>Propietarios</h1>

  <?php if ($msg): ?>
    <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>
  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <ul><?php foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?></ul>
    </div>
  <?php endif; ?>

  <button class="btn btn-outline-dark mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formPropietarioCollapse" aria-expanded="<?= $show_form || $edit_id || !empty($errors) ? 'true' : 'false' ?>" aria-controls="formPropietarioCollapse" style="font-weight:600;">
    <?= $show_form || $edit_id || !empty($errors) ? 'Ocultar' : 'Agregar Nuevo Propietario' ?>
  </button>

  <div class="collapse <?= $show_form || $edit_id || !empty($errors) ? 'show' : '' ?>" id="formPropietarioCollapse">
    <div class="card p-4 mb-4 mt-3">
      <h3><?= $edit_id ? "Editar Propietario" : "Nuevo Propietario" ?></h3>
      <form method="POST" novalidate>
        <input type="hidden" name="edit_id" value="<?= $edit_id ?: '' ?>" />
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre *</label>
          <input type="text" class="form-control" id="nombre" name="nombre" required value="<?= htmlspecialchars($edit_data['nombre'] ?? '') ?>" />
        </div>
        <button type="submit" class="btn btn-primary fw-semibold"><?= $edit_id ? "Actualizar" : "Guardar" ?></button>
        <?php if ($edit_id): ?>
          <a href="propietarios.php" class="btn btn-outline-secondary ms-2">Cancelar</a>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <section>
    <h2 class="fw-semibold mb-3">Listado de Propietarios</h2>
    <?php if (count($propietarios) === 0): ?>
      <p>No hay propietarios registrados.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table align-middle table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($propietarios as $p): ?>
              <tr>
                <td><?= htmlspecialchars($p['id']) ?></td>
                <td><?= htmlspecialchars($p['nombre']) ?></td>
                <td>
                  <a href="propietarios.php?edit=<?= intval($p['id']) ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                  <a href="propietarios.php?delete=<?= intval($p['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que desea eliminar este propietario?')">Eliminar</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </section>
</main>

<?php
include 'includes/footer.php';
?> 