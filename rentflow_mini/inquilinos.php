<?php
require_once 'config.php';
check_login();
$page_title = 'Dashboard - Inmobiliaria';
include 'includes/header_nav.php';

$edit_id = intval($_GET['edit'] ?? 0);
$delete_id = intval($_GET['delete'] ?? 0);
$message = '';
$errors = [];

if ($delete_id) {
  $pdo->prepare("DELETE FROM inquilinos WHERE id = ?")->execute([$delete_id]);
  $message = "Inquilino eliminado correctamente.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = clean_input($_POST['nombre'] ?? '');
  $telefono = clean_input($_POST['telefono'] ?? '');
  $vehiculo = clean_input($_POST['vehiculo'] ?? '');
  $matricula = clean_input($_POST['matricula'] ?? '');

  if (!$nombre) $errors[] = "El nombre es obligatorio.";

  if (empty($errors)) {
    if (isset($_POST['edit_id']) && intval($_POST['edit_id']) > 0) {
      $edit_id = intval($_POST['edit_id']);
      $stmt = $pdo->prepare("UPDATE inquilinos SET nombre=?, telefono=?, vehiculo=?, matricula=? WHERE id=?");
      $stmt->execute([$nombre, $telefono, $vehiculo, $matricula, $edit_id]);
      $message = "Inquilino actualizado correctamente.";
    } else {
      $stmt = $pdo->prepare("INSERT INTO inquilinos (nombre, telefono, vehiculo, matricula) VALUES (?, ?, ?, ?)");
      $stmt->execute([$nombre, $telefono, $vehiculo, $matricula]);
      $message = "Inquilino creado correctamente.";
    }
    header("Location: inquilinos.php?msg=" . urlencode($message));
    exit();
  } else {
    $edit_data = [
      'nombre' => $nombre,
      'telefono' => $telefono,
      'vehiculo' => $vehiculo,
      'matricula' => $matricula,
    ];
    $edit_id = intval($_POST['edit_id'] ?? 0);
  }
} else if ($edit_id) {
  $stmt = $pdo->prepare("SELECT * FROM inquilinos WHERE id = ?");
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

$inquilinos = $pdo->query("SELECT * FROM inquilinos ORDER BY id DESC")->fetchAll();

?>


<main class="container container-main py-4">
  <h1>Inquilinos</h1>

  <?php if ($msg): ?>
    <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>
  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <ul><?php foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?></ul>
    </div>
  <?php endif; ?>

  <button class="btn btn-outline-dark mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formInquilinoCollapse" aria-expanded="<?= $edit_id || !empty($errors) ? 'true' : 'false' ?>" aria-controls="formInquilinoCollapse" style="font-weight:600;">
    <?= $edit_id || !empty($errors) ? 'Ocultar' : 'Agregar Nuevo Inquilino' ?>
  </button>

  <div class="collapse <?= $edit_id || !empty($errors) ? 'show' : '' ?>" id="formInquilinoCollapse">
    <div class="card p-4 mb-4 mt-3">
      <h3><?= $edit_id ? "Editar Inquilino" : "Nuevo Inquilino" ?></h3>
      <form method="POST" novalidate>
        <input type="hidden" name="edit_id" value="<?= $edit_id ?: '' ?>" />
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre *</label>
          <input type="text" class="form-control" id="nombre" name="nombre" required value="<?= htmlspecialchars($edit_data['nombre'] ?? '') ?>" />
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
              <th>Nombre</th>
              <th>Teléfono</th>
              <th>Vehículo</th>
              <th>Matrícula</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($inquilinos as $i): ?>
              <tr>
                <td><?= htmlspecialchars($i['nombre']) ?></td>
                <td><?= htmlspecialchars($i['telefono']) ?></td>
                <td><?= htmlspecialchars($i['vehiculo']) ?></td>
                <td><?= htmlspecialchars($i['matricula']) ?></td>
                <td style="min-width:120px;">
                  <a href="inquilinos.php?edit=<?= intval($i['id']) ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                  <a href="inquilinos.php?delete=<?= intval($i['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que desea eliminar este inquilino?')">Eliminar</a>
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
  const collapseInquilino = document.getElementById('formInquilinoCollapse');
  const toggleBtnInquilino = document.querySelector('button[data-bs-target="#formInquilinoCollapse"]');
  collapseInquilino.addEventListener('show.bs.collapse', () => toggleBtnInquilino.textContent = 'Ocultar');
  collapseInquilino.addEventListener('hide.bs.collapse', () => toggleBtnInquilino.textContent = 'Agregar Nuevo Inquilino');
</script>

<?php
include 'includes/footer.php';
?>