<?php
require_once 'config.php';
check_login();
$page_title = 'Pagos - Inmobiliaria';

$contrato_id = intval($_GET['contrato_id'] ?? 0);
$add_pago = isset($_GET['add']) && $_GET['add'] === 'true'; // Verificar si se debe mostrar el formulario de nuevo pago

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

$msg = $_GET['msg'] ?? '';
if ($msg) {
  $message = $msg;
}

// Manejo de formulario para agregar un nuevo pago
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_pago'])) {
  $periodo = $_POST['periodo'] ?? '';
  $fecha_pago = $_POST['fecha_pago'] ?? '';
  $importe = floatval($_POST['importe'] ?? 0);
  $comentario = $_POST['comentario'] ?? '';
  $comprobante = $_FILES['comprobante'] ?? null;
  $concepto = $_POST['concepto'] ?? '';

  if (!$periodo) $errors[] = "El período es obligatorio.";
  if (!$fecha_pago) $errors[] = "La fecha es obligatoria.";
  if ($importe <= 0) $errors[] = "El importe debe ser mayor que cero.";
  if (!$concepto) $errors[] = "El concepto es obligatorio.";

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
    // Insert new payment
    $stmt = $pdo->prepare("INSERT INTO pagos (contrato_id, periodo, fecha, importe, comentario, comprobante, concepto) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$contrato_id, $periodo, $fecha_pago, $importe, $comentario, $basename ?? null, $concepto]);
    $message = "Pago registrado correctamente.";
    header("Location: pagos.php?contrato_id=$contrato_id&msg=" . urlencode($message));
    exit();
  }
}

// Obtener pagos para este contrato
$pagos = $pdo->prepare("SELECT * FROM pagos WHERE contrato_id = ? ORDER BY periodo ASC");
$pagos->execute([$contrato_id]);
$pagos_list = $pagos->fetchAll();

// Obtener períodos para el desplegable
$fecha_actual = new DateTime();
$periodos = [];
for ($i = -3; $i <= 3; $i++) {
  $fecha = clone $fecha_actual;
  $fecha->modify($i . ' month');
  $periodos[] = $fecha->format('Y-m');
}

include 'includes/header_nav.php';

?>

<main class="container container-main py-4">

  <h1>Pagos</h1>
  <p>
    Contrato: <a href="contratos.php?edit=<?= $contrato_id ?>" class="text-decoration-none text-dark"><strong>#<?= $contrato_id?></strong></a><br>
    Inquilino: <a href="inquilinos.php?edit=<?= intval($contrato['inquilino_id']) ?>" class="text-decoration-none text-dark"><strong><?= htmlspecialchars($contrato['inquilino_nombre']) ?></strong></a><br>
    Propiedad: <a href="propiedades.php?edit=<?= htmlspecialchars($contrato['propiedad_id'] ?? '') ?>" class="text-decoration-none text-dark"><strong><?= htmlspecialchars($contrato['propiedad_nombre']) ?></strong></a>
  </p>

  <?php if ($message): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul><?php foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?></ul>
    </div>
  <?php endif; ?>

  <!-- Botón para mostrar/ocultar el formulario de nuevo pago -->
  <button class="btn btn-outline-dark mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formPagoCollapse" aria-expanded="<?= $add_pago ? 'true' : 'false' ?>" aria-controls="formPagoCollapse" style="font-weight:600;">
    <?= $add_pago ? 'Ocultar' : 'Agregar Nuevo Pago' ?>
  </button>

  <div class="collapse <?= $add_pago ? 'show' : '' ?>" id="formPagoCollapse">
    <div class="card mb-4">
      <div class="card-header">
        <h5>Registrar Nuevo Pago</h5>
      </div>
      <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="periodo" class="form-label">Período *</label>
            <select name="periodo" id="periodo" class="form-select" required>
              <?php foreach ($periodos as $periodo): ?>
                <option value="<?= $periodo ?>" <?= $periodo === $fecha_actual->format('Y-m') ? 'selected' : '' ?>><?= $periodo ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="fecha_pago" class="form-label">Fecha *</label>
            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="<?= date('Y-m-d') ?>" required>
          </div>
          <div class="mb-3">
            <label for="concepto" class="form-label">Concepto *</label>
            <select name="concepto" id="concepto" class="form-select" required>
              <option value="">Seleccione...</option>
              <option value="Pago mensual">Pago mensual</option>
              <option value="Impuestos">Impuestos</option>
              <option value="Gastos comunes">Gastos comunes</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="importe" class="form-label">Importe *</label>
            <input type="number" step="0.01" min="0" class="form-control" id="importe" name="importe" value="<?= htmlspecialchars($contrato['importe']) ?>" required>
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
  </div>

  <?php if (count($pagos_list) === 0): ?>
    <p>No hay pagos registrados para este contrato.</p>
  <?php else: ?>
    <form method="POST">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Concepto</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pagos_list as $pago): ?>
            <tr>
              <td>
                <b><?= htmlspecialchars($pago['periodo']) ?></b> <br> 
                <small><nobr><?= htmlspecialchars($pago['fecha']) ?></nobr></small>
              </td>
              <td>
                <?= htmlspecialchars($pago['concepto']) ?> <br> $<?= number_format($pago['importe'], 2, ",", ".") ?><br>
                <small><?= htmlspecialchars($pago['comentario']) ?><br>
                <?php if ($pago['comprobante']): ?>
                  <a href="uploads/<?= htmlspecialchars($pago['comprobante']) ?>" target="_blank">Ver Comprobante</a>
                <?php endif; ?>
                </small>
              </td>
              <td>
                <a href="pagos.php?delete=<?= intval($pago['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que desea eliminar este pago?')">Eliminar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <a href="contratos.php" class="btn btn-outline-secondary ms-2">Volver a Contratos</a>
    </form>
  <?php endif; ?>

</main>

<script>
  const collapseInquilino = document.getElementById('formPagoCollapse');
  const toggleBtnInquilino = document.querySelector('button[data-bs-target="#formPagoCollapse"]');
  collapseInquilino.addEventListener('show.bs.collapse', () => toggleBtnInquilino.textContent = 'Ocultar');
  collapseInquilino.addEventListener('hide.bs.collapse', () => toggleBtnInquilino.textContent = 'Agregar Nuevo Pago');
</script>

<?php
include 'includes/footer.php';
?>