<?php
require_once 'config.php';
check_login();
$page_title = 'Pagos - Inmobiliaria';
include 'includes/header_nav.php';

$contrato_id = intval($_GET['contrato_id'] ?? 0);
if (!$contrato_id) {
  header("Location: contratos.php");
  exit();
}

$message = '';
$errors = [];

// Obtener información del contrato
$stmt = $pdo->prepare("SELECT c.*, i.nombre as inquilino_nombre, p.nombre as propiedad_nombre FROM contratos c JOIN inquilinos i ON c.inquilino_id = i.id JOIN propiedades p ON c.propiedad_id = p.id WHERE c.id = ?");
$stmt->execute([$contrato_id]);
$contrato = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$contrato) {
  header("Location: contratos.php");
  exit();
}

// Manejo de formulario para agregar un nuevo pago
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_pago'])) {
  $fecha_pago = $_POST['fecha_pago'] ?? '';
  $monto = floatval($_POST['monto'] ?? 0);
  $comentario = $_POST['comentario'] ?? '';
  $comprobante = $_FILES['comprobante'] ?? null;

  if (!$fecha_pago) $errors[] = "La fecha es obligatoria.";
  if ($monto <= 0) $errors[] = "El monto debe ser mayor que cero.";

  // Manejo de archivo de comprobante
  if ($comprobante && $comprobante['error'] === UPLOAD_ERR_OK) {
    $upload_dir = __DIR__ . '/uploads/';
    if (!file_exists($upload_dir)) {
      mkdir($upload_dir, 0755, true);
    }
    $basename = uniqid() . '-' . basename($comprobante['name']);
    if (!move_uploaded_file($comprobante['tmp_name'], $upload_dir . $basename)) {
      $errors[] = "Error al subir el comprobante.";
    }
  }

  if (empty($errors)) {
    // Insertar nuevo pago
    $stmt = $pdo->prepare("INSERT INTO pagos (contrato_id, fecha, monto, comentario, comprobante) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$contrato_id, $fecha_pago, $monto, $comentario, $basename ?? null]);
    $message = "Pago registrado correctamente.";
    header("Location: pagos.php?contrato_id=$contrato_id&msg=" . urlencode($message));
    exit();
  }
}

// Obtener pagos para este contrato
$pagos = $pdo->prepare("SELECT * FROM pagos WHERE contrato_id = ? ORDER BY fecha DESC");
$pagos->execute([$contrato_id]);
$pagos_list = $pagos->fetchAll();

function month_name($m)
{
  $months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
  return $months[$m - 1] ?? "";
}

?>

<main class="container container-main py-4">

  <h1>Pagos - Contrato #<?= $contrato_id ?></h1>
  <p><strong>Inquilino:</strong> <?= htmlspecialchars($contrato['inquilino_nombre']) ?> &nbsp;&nbsp;&nbsp; <strong>Propiedad:</strong> <?= htmlspecialchars($contrato['propiedad_nombre']) ?></p>

  <?php if ($message): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul><?php foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?></ul>
    </div>
  <?php endif; ?>

  <!-- Formulario para agregar un nuevo pago -->
  <div class="card mb-4">
    <div class="card-header">
      <h5>Registrar Nuevo Pago</h5>
    </div>
    <div class="card-body">
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="fecha_pago" class="form-label">Fecha *</label>
          <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" required>
        </div>
        <div class="mb-3">
          <label for="monto" class="form-label">Monto *</label>
          <input type="number" step="0.01" min="0" class="form-control" id="monto" name="monto" required>
        </div>
        <div class="mb-3">
          <label for="comentario" class="form-label">Comentario</label>
          <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
        </div>
        <div class="mb-3">
          <label for="comprobante" class="form-label">Comprobante</label>
          <input type="file" class="form-control" id="comprobante" name="comprobante" accept="image/*,application/pdf">
        </div>
        <button type="submit" name="nuevo_pago" class="btn btn-primary">Registrar Pago</button>
      </form>
    </div>
  </div>

  <?php if (count($pagos_list) === 0): ?>
    <p>No hay pagos registrados para este contrato.</p>
  <?php else: ?>
    <form method="POST">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Monto</th>
            <th>Comentario</th>
            <th>Comprobante</th>
            <th>Pagar</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pagos_list as $pago): ?>
            <tr>
              <td><?= htmlspecialchars($pago['fecha']) ?></td>
              <td>$ <?= number_format($pago['monto'], 2, ",", ".") ?></td>
              <td><?= htmlspecialchars($pago['comentario']) ?></td>
              <td>
                <?php if ($pago['comprobante']): ?>
                  <a href="uploads/<?= htmlspecialchars($pago['comprobante']) ?>" target="_blank">Ver Comprobante</a>
                <?php else: ?>
                  Sin comprobante
                <?php endif; ?>
              </td>
              <td>
                <select class="form-select" name="pago_<?= $pago['id'] ?>">
                  <option value="0" <?= $pago['pagado'] == 0 ? "selected" : "" ?>>Pendiente</option>
                  <option value="1" <?= $pago['pagado'] == 1 ? "selected" : "" ?>>Pagado</option>
                </select>
              </td>
              <td>
                <?= $pago['pagado'] ? '<span class="badge bg-success">Pagado</span>' : '<span class="badge bg-warning text-dark">Pendiente</span>' ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <button type="submit" class="btn btn-primary fw-semibold">Guardar cambios</button>
      <a href="contratos.php" class="btn btn-outline-secondary ms-2">Volver a Contratos</a>
    </form>
  <?php endif; ?>

</main>

<?php
include 'includes/footer.php';
?>