<?php
require_once 'config.php';
check_login();
$page_title = 'Dashboard - Inmobiliaria';
include 'includes/header_nav.php';

$contrato_id = intval($_GET['contrato_id'] ?? 0);
if (!$contrato_id) {
  header("Location: contratos.php");
  exit();
}

$message = '';
$errors = [];

$stmt = $pdo->prepare("SELECT c.*, i.nombre as inquilino_nombre, p.nombre as propiedad_nombre FROM contratos c JOIN inquilinos i ON c.inquilino_id = i.id JOIN propiedades p ON c.propiedad_id = p.id WHERE c.id = ?");
$stmt->execute([$contrato_id]);
$contrato = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$contrato) {
  header("Location: contratos.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Marcar pago pagado / no pagado
  foreach ($_POST as $key => $value) {
    if (strpos($key, 'pago_') === 0) {
      $pago_id = intval(str_replace('pago_', '', $key));
      $pagado = $value === '1' ? 1 : 0;
      $pdo->prepare("UPDATE pagos SET pagado = ? WHERE id = ?")->execute([$pagado, $pago_id]);
    }
  }
  $message = "Pagos actualizados correctamente.";
  header("Location: pagos.php?contrato_id=$contrato_id&msg=" . urlencode($message));
  exit();
}

$msg = $_GET['msg'] ?? '';

// Obtener pagos para este contrato
$pagos = $pdo->prepare("SELECT * FROM pagos WHERE contrato_id = ? ORDER BY anio DESC, mes DESC");
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

  <?php if ($msg): ?>
    <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
  <?php endif; ?>

  <?php if (count($pagos_list) === 0): ?>
    <p>No hay pagos registrados para este contrato.</p>
  <?php else: ?>
    <form method="POST">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Mes</th>
            <th>Año</th>
            <th>Pagar</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pagos_list as $pago): ?>
            <tr>
              <td><?= month_name(intval($pago['mes'])) ?></td>
              <td><?= $pago['anio'] ?></td>
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