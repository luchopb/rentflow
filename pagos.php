<?php
require_once 'config.php';
require_once 'includes/email_helper.php';
check_login();
$page_title = 'Pagos - Inmobiliaria';

$contrato_id = intval($_GET['contrato_id'] ?? 0);
$propiedad_id = intval($_GET['propiedad_id'] ?? 0);
$edit_id = intval($_GET['edit'] ?? 0);
$add_pago = isset($_GET['add']) && $_GET['add'] === 'true';
$show_form = $add_pago || $edit_id > 0;

$message = '';
$errors = [];
$contrato = null;
$propiedad = null;
$sin_contrato = false;

if ($contrato_id) {
  // Obtener información del contrato
  $stmt = $pdo->prepare("SELECT c.*, i.nombre as inquilino_nombre, i.vehiculo, i.matricula, i.telefono, p.nombre as propiedad_nombre, p.tipo as propiedad_tipo, p.direccion as propiedad_direccion, p.precio as propiedad_precio FROM contratos c JOIN inquilinos i ON c.inquilino_id = i.id JOIN propiedades p ON c.propiedad_id = p.id WHERE c.id = ?");
  $stmt->execute([$contrato_id]);
  $contrato = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$contrato) {
    header("Location: contratos.php");
    exit();
  }
  $propiedad_id = intval($contrato['propiedad_id']);
} elseif ($propiedad_id) {
  // Pago asociado solo a la propiedad (sin contrato)
  $sin_contrato = true;
  $stmt = $pdo->prepare("SELECT p.*, pr.nombre as propietario_nombre FROM propiedades p LEFT JOIN propietarios pr ON p.propietario_id = pr.id WHERE p.id = ?");
  $stmt->execute([$propiedad_id]);
  $propiedad = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$propiedad) {
    header("Location: propiedades.php");
    exit();
  }
} else {
  header("Location: propiedades.php");
  exit();
}

// URL base para redirecciones y enlaces de esta pantalla
$url_base = $sin_contrato
  ? "pagos.php?propiedad_id=$propiedad_id"
  : "pagos.php?contrato_id=$contrato_id";

$msg = $_GET['msg'] ?? '';
if ($msg) {
  $message = $msg;
}

// Cargar datos de edición si existe
$edit_data = null;
if ($edit_id) {
  if ($sin_contrato) {
    $stmt = $pdo->prepare("SELECT * FROM pagos WHERE id = ? AND propiedad_id = ? AND contrato_id IS NULL");
    $stmt->execute([$edit_id, $propiedad_id]);
  } else {
    $stmt = $pdo->prepare("SELECT * FROM pagos WHERE id = ? AND contrato_id = ?");
    $stmt->execute([$edit_id, $contrato_id]);
  }
  $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
  if (!$edit_data) {
    header("Location: $url_base");
    exit();
  }
}

// Manejo de formulario para agregar/editar pago
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nuevo_pago'])) {
  $edit_id_form = intval($_POST['edit_id'] ?? 0);
  $periodo = $_POST['periodo'] ?? '';
  $fecha_pago = $_POST['fecha_pago'] ?? '';
  $importe = floatval($_POST['importe'] ?? 0);
  $comentario = $_POST['comentario'] ?? '';
  $comprobante = $_FILES['comprobante'] ?? null;
  $concepto = $_POST['concepto'] ?? '';
  $tipo_pago = $_POST['tipo_pago'] ?? '';
  $usuario_id = $_SESSION['user_id'] ?? null;
  $fecha_creacion = date('Y-m-d H:i:s');

  if (!$periodo) $errors[] = "El período es obligatorio.";
  if (!$fecha_pago) $errors[] = "La fecha es obligatoria.";
  if ($importe <= 0) $errors[] = "El importe debe ser mayor que cero.";
  if (!$concepto) $errors[] = "El concepto es obligatorio.";
  if (!$tipo_pago) $errors[] = "El tipo de pago es obligatorio.";

  // Manejo de archivo de comprobante
  $basename = null; // Inicializar variable para evitar errores
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
    if ($edit_id_form > 0) {
      // Actualizar pago existente
      $sql = "UPDATE pagos SET periodo=?, fecha=?, importe=?, comentario=?, concepto=?, tipo_pago=?";
      $params = [$periodo, $fecha_pago, $importe, $comentario, $concepto, $tipo_pago];

      if ($basename) {
        $sql .= ", comprobante=?";
        $params[] = $basename;
      }

      if ($sin_contrato) {
        $sql .= " WHERE id=? AND propiedad_id=? AND contrato_id IS NULL";
        $params[] = $edit_id_form;
        $params[] = $propiedad_id;
      } else {
        $sql .= " WHERE id=? AND contrato_id=?";
        $params[] = $edit_id_form;
        $params[] = $contrato_id;
      }

      $stmt = $pdo->prepare($sql);
      $stmt->execute($params);
      $message = "Pago actualizado correctamente.";
    } else {
      // Insertar nuevo pago (con o sin contrato)
      $contrato_id_insert = $sin_contrato ? null : $contrato_id;
      $stmt = $pdo->prepare("INSERT INTO pagos (contrato_id, propiedad_id, usuario_id, periodo, fecha, fecha_creacion, importe, comentario, comprobante, concepto, tipo_pago) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->execute([$contrato_id_insert, $propiedad_id, $usuario_id, $periodo, $fecha_pago, $fecha_creacion, $importe, $comentario, $basename ?? null, $concepto, $tipo_pago]);
      $message = "Pago registrado correctamente.";
    }

    // Solo enviar email cuando se crea un nuevo pago, no cuando se edita
    if ($edit_id_form == 0) {
      if (!$sin_contrato) {
        $stmt = $pdo->prepare("SELECT c.*, i.email as inquilino_email, i.nombre as inquilino_nombre, p.propietario_id, p.nombre as propiedad_nombre, p.direccion, pr.email as propietario_email, pr.nombre as propietario_nombre FROM contratos c JOIN inquilinos i ON c.inquilino_id = i.id JOIN propiedades p ON c.propiedad_id = p.id JOIN propietarios pr ON p.propietario_id = pr.id WHERE c.id = ?");
        $stmt->execute([$contrato_id]);
        $info = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($info) {
          $destinatarios = array_filter(array_merge(
            explode(',', $info['inquilino_email']),
            explode(',', $info['propietario_email'])
          ));
          $asunto = 'Nuevo Pago registrado en RentFlow';
          $cuerpo = '<h2>Detalle del Pago</h2>';
          $cuerpo .= '<b>Propiedad:</b> ' . htmlspecialchars($info['propiedad_nombre']) . ' (' . htmlspecialchars($info['direccion']) . ')<br>';
          $cuerpo .= '<b>Inquilino:</b> ' . htmlspecialchars($info['inquilino_nombre']) . '<br>';
          $cuerpo .= '<b>Propietario:</b> ' . htmlspecialchars($info['propietario_nombre']) . '<br>';
          $cuerpo .= '<b>Período:</b> ' . htmlspecialchars($periodo) . '<br>';
          $cuerpo .= '<b>Fecha de pago:</b> ' . htmlspecialchars($fecha_pago) . '<br>';
          $cuerpo .= '<b>Importe:</b> $' . number_format($importe, 2, ',', '.') . '<br>';
          $cuerpo .= '<b>Concepto:</b> ' . htmlspecialchars($concepto) . '<br>';
          $cuerpo .= '<b>Tipo de pago:</b> ' . htmlspecialchars($tipo_pago) . '<br>';
          if ($comentario) $cuerpo .= '<b>Comentario:</b> ' . nl2br(htmlspecialchars($comentario)) . '<br>';
          enviar_email($destinatarios, $asunto, $cuerpo);
        }
      } else {
        // Notificar solo al propietario cuando no hay contrato/inquilino
        $stmt = $pdo->prepare("SELECT p.nombre as propiedad_nombre, p.direccion, pr.email as propietario_email, pr.nombre as propietario_nombre FROM propiedades p LEFT JOIN propietarios pr ON p.propietario_id = pr.id WHERE p.id = ?");
        $stmt->execute([$propiedad_id]);
        $info = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($info && !empty($info['propietario_email'])) {
          $destinatarios = array_filter(explode(',', $info['propietario_email']));
          $asunto = 'Nuevo Pago registrado en RentFlow';
          $cuerpo = '<h2>Detalle del Pago</h2>';
          $cuerpo .= '<b>Propiedad:</b> ' . htmlspecialchars($info['propiedad_nombre']) . ' (' . htmlspecialchars($info['direccion']) . ')<br>';
          $cuerpo .= '<b>Propietario:</b> ' . htmlspecialchars($info['propietario_nombre'] ?? '') . '<br>';
          $cuerpo .= '<b>Sin contrato asociado</b><br>';
          $cuerpo .= '<b>Período:</b> ' . htmlspecialchars($periodo) . '<br>';
          $cuerpo .= '<b>Fecha de pago:</b> ' . htmlspecialchars($fecha_pago) . '<br>';
          $cuerpo .= '<b>Importe:</b> $' . number_format($importe, 2, ',', '.') . '<br>';
          $cuerpo .= '<b>Concepto:</b> ' . htmlspecialchars($concepto) . '<br>';
          $cuerpo .= '<b>Tipo de pago:</b> ' . htmlspecialchars($tipo_pago) . '<br>';
          if ($comentario) $cuerpo .= '<b>Comentario:</b> ' . nl2br(htmlspecialchars($comentario)) . '<br>';
          enviar_email($destinatarios, $asunto, $cuerpo);
        }
      }
    }
    header("Location: $url_base&msg=" . urlencode($message));
    exit();
  }
}

// Manejo de exportación a CSV
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    if ($sin_contrato) {
      $stmt_export = $pdo->prepare("
          SELECT 
              p.id, p.periodo, p.fecha, p.concepto, p.tipo_pago, p.importe,
              p.comentario, p.comprobante, p.validado, p.fecha_validacion,
              NULL as inquilino_nombre,
              prop.nombre as propiedad_nombre,
              prop.direccion as propiedad_direccion
          FROM pagos p
          JOIN propiedades prop ON p.propiedad_id = prop.id
          WHERE p.propiedad_id = ? AND p.contrato_id IS NULL
          ORDER BY p.fecha DESC, p.periodo DESC
      ");
      $stmt_export->execute([$propiedad_id]);
      $nombre_archivo = 'pagos_propiedad_' . $propiedad_id;
    } else {
      $stmt_export = $pdo->prepare("
          SELECT 
              p.id, p.periodo, p.fecha, p.concepto, p.tipo_pago, p.importe,
              p.comentario, p.comprobante, p.validado, p.fecha_validacion,
              i.nombre as inquilino_nombre,
              prop.nombre as propiedad_nombre,
              prop.direccion as propiedad_direccion
          FROM pagos p
          JOIN contratos c ON p.contrato_id = c.id
          JOIN inquilinos i ON c.inquilino_id = i.id
          JOIN propiedades prop ON c.propiedad_id = prop.id
          WHERE p.contrato_id = ?
          ORDER BY p.fecha DESC, p.periodo DESC
      ");
      $stmt_export->execute([$contrato_id]);
      $nombre_archivo = 'pagos_contrato_' . $contrato_id;
    }
    $pagos_export = $stmt_export->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $nombre_archivo . '_' . date('Y-m-d_H-i-s') . '.csv"');

    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

    fputcsv($output, [
        'ID', 'Período', 'Fecha', 'Concepto', 'Tipo de Pago', 'Importe',
        'Comentario', 'Comprobante', 'Validado', 'Fecha Validación',
        'Inquilino', 'Propiedad', 'Dirección'
    ], ';');

    foreach ($pagos_export as $pago) {
        fputcsv($output, [
            $pago['id'],
            $pago['periodo'],
            $pago['fecha'],
            $pago['concepto'],
            $pago['tipo_pago'],
            $pago['importe'],
            $pago['comentario'],
            $pago['comprobante'] ?? '',
            $pago['validado'] ? 'Sí' : 'No',
            $pago['fecha_validacion'] ?? '',
            $pago['inquilino_nombre'] ?? '',
            $pago['propiedad_nombre'],
            $pago['propiedad_direccion']
        ], ';');
    }

    fclose($output);
    exit();
}

// Obtener pagos (por contrato o por propiedad sin contrato)
if ($sin_contrato) {
  $pagos = $pdo->prepare("SELECT * FROM pagos WHERE propiedad_id = ? AND contrato_id IS NULL ORDER BY fecha DESC, periodo DESC");
  $pagos->execute([$propiedad_id]);
} else {
  $pagos = $pdo->prepare("SELECT * FROM pagos WHERE contrato_id = ? ORDER BY fecha DESC, periodo DESC");
  $pagos->execute([$contrato_id]);
}
$pagos_list = $pagos->fetchAll();

// Obtener períodos para el desplegable (desde el día 1 para evitar duplicados el 31)
$fecha_actual = new DateTime('first day of this month');
$periodos = [];
for ($i = -9; $i <= 2; $i++) {
  $fecha = clone $fecha_actual;
  $fecha->modify($i . ' month');
  $periodos[] = $fecha->format('Y-m');
}

// Manejo de eliminación de pago
if (isset($_GET['delete']) && $_SESSION['user_role'] === 'admin') {
  $delete_id = intval($_GET['delete']);
  if ($sin_contrato) {
    $stmt = $pdo->prepare("SELECT comprobante FROM pagos WHERE id = ? AND propiedad_id = ? AND contrato_id IS NULL");
    $stmt->execute([$delete_id, $propiedad_id]);
  } else {
    $stmt = $pdo->prepare("SELECT comprobante FROM pagos WHERE id = ? AND contrato_id = ?");
    $stmt->execute([$delete_id, $contrato_id]);
  }
  $row = $stmt->fetch();
  if ($row && $row['comprobante']) {
    $upload_dir = __DIR__ . '/uploads/';
    $path = $upload_dir . basename($row['comprobante']);
    if (is_file($path)) unlink($path);
  }
  if ($sin_contrato) {
    $pdo->prepare("DELETE FROM pagos WHERE id = ? AND propiedad_id = ? AND contrato_id IS NULL")->execute([$delete_id, $propiedad_id]);
  } else {
    $pdo->prepare("DELETE FROM pagos WHERE id = ? AND contrato_id = ?")->execute([$delete_id, $contrato_id]);
  }
  $message = "Pago eliminado correctamente.";
  header("Location: $url_base&msg=" . urlencode($message));
  exit();
}

// Importe sugerido en el formulario
$importe_sugerido = $sin_contrato
  ? ($propiedad['precio'] ?? '')
  : ($contrato['importe'] ?? '');

include 'includes/header_nav.php';
?>

<main class="container container-main py-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Pagos</h1>
    <button class="btn btn-lg btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formPagoCollapse" aria-expanded="<?= $show_form ? 'true' : 'false' ?>" aria-controls="formPagoCollapse" style="font-weight:600;">
      <?= $show_form ? 'Ocultar' : 'Agregar Nuevo Pago' ?>
    </button>
  </div>

  <p>
    <?php if ($sin_contrato): ?>
      Propiedad: <a href="propiedades.php?edit=<?= $propiedad_id ?>" class="text-decoration-none text-dark"><strong><?= htmlspecialchars($propiedad['nombre']) ?></strong></a><br>
      Tipo: <strong><?= htmlspecialchars($propiedad['tipo'] ?? '') ?></strong><br>
      Dirección: <strong><?= htmlspecialchars($propiedad['direccion'] ?? '') ?></strong><br>
      <span class="badge bg-secondary">Sin contrato</span>
    <?php else: ?>
      Contrato: <a href="contratos.php?edit=<?= $contrato_id ?>" class="text-decoration-none text-dark"><strong>#<?= $contrato_id ?></strong></a><br>
      Inquilino: <a href="inquilinos.php?edit=<?= intval($contrato['inquilino_id']) ?>" class="text-decoration-none text-dark"><strong><?= htmlspecialchars($contrato['inquilino_nombre']) ?></strong> <?= htmlspecialchars($contrato['vehiculo']) ?> <?= htmlspecialchars($contrato['matricula']) ?> <?= htmlspecialchars($contrato['telefono']) ?></a><br>
      Propiedad: <a href="propiedades.php?edit=<?= htmlspecialchars($contrato['propiedad_id'] ?? '') ?>" class="text-decoration-none text-dark"><strong><?= htmlspecialchars($contrato['propiedad_nombre']) ?></strong></a><br>
      Tipo: <strong><?= htmlspecialchars($contrato['propiedad_tipo'] ?? '') ?></strong><br>
      Dirección: <strong><?= htmlspecialchars($contrato['propiedad_direccion'] ?? '') ?></strong>
    <?php endif; ?>
  </p>

  <?php if ($message): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul><?php foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?></ul>
    </div>
  <?php endif; ?>


  <div class="collapse <?= $show_form ? 'show' : '' ?>" id="formPagoCollapse">
    <div class="card mb-4">
      <div class="card-header">
        <h5><?= $edit_id ? 'Editar Pago' : 'Registrar Nuevo Pago' ?></h5>
      </div>
      <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
          <input type="hidden" name="edit_id" value="<?= $edit_id ?>">
          <div class="mb-3">
            <label for="periodo" class="form-label">Período *</label>
            <select name="periodo" id="periodo" class="form-select" required>
              <option value="">Seleccione un período...</option>
              <?php
                $periodo_actual = $fecha_actual->format('Y-m');
                $periodo_anterior = (clone $fecha_actual)->modify('-1 month')->format('Y-m');
                foreach ($periodos as $periodo):
                  $etiqueta = $periodo;
                  if ($periodo === $periodo_actual) $etiqueta .= ' (actual)';
                  elseif ($periodo === $periodo_anterior) $etiqueta .= ' (anterior)';
              ?>
                <option value="<?= $periodo ?>" <?= $periodo === ($edit_data['periodo'] ?? $periodo_actual) ? 'selected' : '' ?>><?= $etiqueta ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="fecha_pago" class="form-label">Fecha *</label>
            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="<?= $edit_data['fecha'] ?? date('Y-m-d') ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Concepto *</label>
            <div class="btn-group flex-wrap" role="group" aria-label="Concepto">
              <input type="radio" class="btn-check" name="concepto" id="concepto_pago_mensual" value="Pago mensual" <?= ($edit_data['concepto'] ?? '') === 'Pago mensual' ? 'checked' : '' ?> required>
              <label class="btn btn-outline-primary" for="concepto_pago_mensual">Pago mensual</label>

              <input type="radio" class="btn-check" name="concepto" id="concepto_impuestos" value="Impuestos" <?= ($edit_data['concepto'] ?? '') === 'Impuestos' ? 'checked' : '' ?>>
              <label class="btn btn-outline-primary" for="concepto_impuestos">Impuestos</label>

              <input type="radio" class="btn-check" name="concepto" id="concepto_gastos_comunes" value="Gastos comunes" <?= ($edit_data['concepto'] ?? '') === 'Gastos comunes' ? 'checked' : '' ?>>
              <label class="btn btn-outline-primary" for="concepto_gastos_comunes">Gastos comunes</label>

              <input type="radio" class="btn-check" name="concepto" id="concepto_comisiones" value="Comisiones" <?= ($edit_data['concepto'] ?? '') === 'Comisiones' ? 'checked' : '' ?>>
              <label class="btn btn-outline-primary" for="concepto_comisiones">Comisiones</label>
            </div>
          </div>
          <div class="mb-3">
            <label for="importe" class="form-label">Importe *</label>
            <input type="number" step="0.01" min="0" class="form-control" id="importe" name="importe" value="<?= htmlspecialchars($edit_data['importe'] ?? $importe_sugerido) ?>" required>
          </div>

          <!-- Nuevo campo para Tipo de Pago -->
          <div class="mb-3">
            <label class="form-label">Tipo de Pago *</label>
            <div class="btn-group" role="group" aria-label="Tipo de pago">
              <input type="radio" class="btn-check" name="tipo_pago" id="efectivo" value="Efectivo" <?= ($edit_data['tipo_pago'] ?? '') === 'Efectivo' ? 'checked' : '' ?> required>
              <label class="btn btn-outline-primary" for="efectivo">Efectivo</label>

              <input type="radio" class="btn-check" name="tipo_pago" id="efectivo_sobre" value="Efectivo (Sobre)" <?= ($edit_data['tipo_pago'] ?? '') === 'Efectivo (Sobre)' ? 'checked' : '' ?>>
              <label class="btn btn-outline-primary" for="efectivo_sobre">Efectivo (Sobre)</label>

              <input type="radio" class="btn-check" name="tipo_pago" id="transferencia" value="Transferencia" <?= ($edit_data['tipo_pago'] ?? '') === 'Transferencia' ? 'checked' : '' ?>>
              <label class="btn btn-outline-primary" for="transferencia">Transferencia</label>
            </div>
          </div>


          <div class="mb-3">
            <label for="comentario" class="form-label">Comentario</label>
            <textarea class="form-control" id="comentario" name="comentario" rows="3"><?= htmlspecialchars($edit_data['comentario'] ?? '') ?></textarea>
          </div>
          <div class="mb-3">
            <label for="comprobante" class="form-label">Comprobante</label>
            <input type="file" class="form-control" id="comprobante" name="comprobante" accept="image/*,application/pdf">
            <?php if ($edit_data && $edit_data['comprobante']): ?>
              <small class="form-text text-muted">Comprobante actual: <a href="uploads/<?= htmlspecialchars($edit_data['comprobante']) ?>" target="_blank"><?= htmlspecialchars($edit_data['comprobante']) ?></a></small>
            <?php endif; ?>
          </div>
          <div class="d-flex gap-2">
            <button type="submit" name="nuevo_pago" class="btn btn-lg btn-primary">
              <?= $edit_id ? 'Actualizar Pago' : 'Registrar Pago' ?>
            </button>
            <?php if ($edit_id): ?>
              <a href="<?= $url_base ?>" class="btn btn-outline-secondary">Cancelar</a>
            <?php endif; ?>
          </div>
        </form>
      </div>
    </div>
  </div>

  <?php if (count($pagos_list) === 0): ?>
    <p>No hay pagos registrados<?= $sin_contrato ? ' para esta propiedad' : ' para este contrato' ?>.</p>
  <?php else: ?>
    <form method="POST">
      <div class="mb-3">
        <a href="<?= $url_base ?>&export=csv" class="btn btn-success">
          <i class="bi bi-file-earmark-excel"></i> Exportar a Excel
        </a>
      </div>
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Concepto</th>
            <th>Validado</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pagos_list as $pago): ?>
            <tr>
              <td>
                <b><?= htmlspecialchars($pago['periodo']) ?></b> <br>
                <small>
                  <nobr><?= htmlspecialchars($pago['fecha']) ?></nobr>
                </small>
              </td>
              <td>
                <b><?= htmlspecialchars($pago['concepto']) ?></b> <br> $<?= number_format($pago['importe'], 2, ",", ".") ?><br>
                <span class="badge bg-info"><?= htmlspecialchars($pago['tipo_pago'] ?? '') ?></span><br>
                <small><?= nl2br(htmlspecialchars($pago['comentario'])) ?><br>
                  <?php if ($pago['comprobante']): ?>
                    <a href="uploads/<?= htmlspecialchars($pago['comprobante']) ?>" target="_blank">Ver Comprobante</a>
                  <?php endif; ?>
                </small>
              </td>
              <td>
                <div class="form-check d-flex">
                  <input class="form-check-input checkbox-validacion"
                      type="checkbox"
                      id="validado_<?= $pago['id'] ?>"
                      data-pago-id="<?= $pago['id'] ?>"
                      <?= ($pago['validado'] ?? false) ? 'checked' : '' ?>
                      onclick="if(!confirm('¿Realmente desea validar el pago?')) { event.preventDefault(); return false; }">
                  <label class="form-check-label ms-2" for="validado_<?= $pago['id'] ?>">
                    <?php if ($pago['validado'] ?? false): ?>
                      <small class="text-success">
                        <i class="bi bi-check-circle-fill"></i> Validado
                        <?php if ($pago['fecha_validacion'] ?? null): ?>
                          <br><small><?= date('d/m/Y H:i', strtotime($pago['fecha_validacion'])) ?></small>
                        <?php endif; ?>
                      </small>
                    <?php else: ?>
                      <small class="text-muted">Pendiente</small>
                    <?php endif; ?>
                  </label>
                </div>
              </td>
              <td>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                  <div class="btn-group btn-group-sm" role="group">
                    <a href="<?= $url_base ?>&edit=<?= intval($pago['id']) ?>" class="btn btn-outline-primary" title="Editar">
                      <i class="bi bi-pencil"></i>
                    </a>
                    <a href="<?= $url_base ?>&delete=<?= intval($pago['id']) ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Seguro que desea eliminar este pago?')">
                      <i class="bi bi-trash"></i>
                    </a>
                  </div>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php if ($sin_contrato): ?>
        <a href="propiedades.php" class="btn btn-secondary ms-2">Volver a Propiedades</a>
      <?php else: ?>
        <a href="contratos.php" class="btn btn-secondary ms-2">Volver a Contratos</a>
      <?php endif; ?>
      <a href="movimientos.php?propiedad_id=<?= $propiedad_id ?>" class="btn btn-info ms-2">Ver Movimientos</a>
    </form>
  <?php endif; ?>

</main>

<script>
  const collapseInquilino = document.getElementById('formPagoCollapse');
  const toggleBtnInquilino = document.querySelector('button[data-bs-target="#formPagoCollapse"]');
  collapseInquilino.addEventListener('show.bs.collapse', () => toggleBtnInquilino.textContent = 'Ocultar');
  collapseInquilino.addEventListener('hide.bs.collapse', () => toggleBtnInquilino.textContent = 'Agregar Nuevo Pago');

  // Función para validar/desvalidar pagos
  function validarPago(pagoId, validado) {
    const formData = new FormData();
    formData.append('pago_id', pagoId);
    formData.append('validado', validado);

    fetch('validar_pago.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Mostrar mensaje de éxito
          const mensaje = document.createElement('div');
          mensaje.className = 'alert alert-success alert-dismissible fade show position-fixed';
          mensaje.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
          mensaje.innerHTML = `
            ${data.message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          `;
          document.body.appendChild(mensaje);

          // Remover el mensaje después de 3 segundos
          setTimeout(() => {
            mensaje.remove();
          }, 3000);

          // Actualizar la etiqueta del checkbox
          const checkbox = document.getElementById(`validado_${pagoId}`);
          const label = checkbox.nextElementSibling;

          if (validado) {
            label.innerHTML = `
              <small class="text-success">
                <i class="bi bi-check-circle-fill"></i> Validado
                <br><small>${data.fecha_validacion ? new Date(data.fecha_validacion).toLocaleString('es-ES', {
                  day: '2-digit',
                  month: '2-digit',
                  year: 'numeric',
                  hour: '2-digit',
                  minute: '2-digit'
                }) : ''}</small>
              </small>
            `;
          } else {
            label.innerHTML = '<small class="text-muted">Pendiente</small>';
          }
        } else {
          // Mostrar mensaje de error
          const mensaje = document.createElement('div');
          mensaje.className = 'alert alert-danger alert-dismissible fade show position-fixed';
          mensaje.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
          mensaje.innerHTML = `
            Error: ${data.message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          `;
          document.body.appendChild(mensaje);

          // Remover el mensaje después de 5 segundos
          setTimeout(() => {
            mensaje.remove();
          }, 5000);

          // Revertir el checkbox
          const checkbox = document.getElementById(`validado_${pagoId}`);
          checkbox.checked = !validado;
        }
      })
      .catch(error => {
        console.error('Error:', error);

        // Mostrar mensaje de error
        const mensaje = document.createElement('div');
        mensaje.className = 'alert alert-danger alert-dismissible fade show position-fixed';
        mensaje.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        mensaje.innerHTML = `
          Error de conexión. Intente nuevamente.
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(mensaje);

        // Remover el mensaje después de 5 segundos
        setTimeout(() => {
          mensaje.remove();
        }, 5000);

        // Revertir el checkbox
        const checkbox = document.getElementById(`validado_${pagoId}`);
        checkbox.checked = !validado;
      });
  }

  // Manejar cambios en los checkboxes de validación
  document.addEventListener('DOMContentLoaded', function() {
    const checkboxesValidacion = document.querySelectorAll('.checkbox-validacion');
    checkboxesValidacion.forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        const pagoId = this.getAttribute('data-pago-id');
        const validado = this.checked;

        // Deshabilitar el checkbox temporalmente para evitar múltiples clics
        this.disabled = true;

        validarPago(pagoId, validado);

        // Habilitar el checkbox después de un breve delay
        setTimeout(() => {
          this.disabled = false;
        }, 1000);
      });
    });
  });
</script>

<?php
include 'includes/footer.php';
?>