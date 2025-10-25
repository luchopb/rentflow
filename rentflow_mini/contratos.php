<?php
require_once 'config.php';
require_once 'includes/email_helper.php';
check_login();
$page_title = 'Contratos - Inmobiliaria';

$edit_id = intval($_GET['edit'] ?? 0);
$delete_id = intval($_GET['delete'] ?? 0);
$message = '';
$errors = [];
$propiedad_id_param = intval($_GET['propiedad_id'] ?? 0);

// Manejo eliminación contrato
if ($delete_id) {
  // Obtener el ID de la propiedad asociada al contrato
  $stmt = $pdo->prepare("SELECT propiedad_id FROM contratos WHERE id = ?");
  $stmt->execute([$delete_id]);
  $propiedad_id = $stmt->fetchColumn();

  // Eliminar pagos y contrato
  $pdo->prepare("DELETE FROM pagos WHERE contrato_id = ?")->execute([$delete_id]);
  $pdo->prepare("DELETE FROM contratos WHERE id = ?")->execute([$delete_id]);

  // Marcar la propiedad como libre
  if ($propiedad_id) {
    $pdo->prepare("UPDATE propiedades SET estado = 'libre' WHERE id = ?")->execute([$propiedad_id]);
  }

  $message = "Contrato eliminado correctamente.";
}

// Variables por defecto para formulario
$inquilino_id = null;
$propiedad_id = $propiedad_id_param ?: null;
$fecha_inicio = '';
$fecha_fin = '';
$importe = '';
$garantia = 0;
$corredor = 0;
$estado = 'activo';
$comentarios = '';

$documentos_subidos = [];
$documentos_guardados = [];
$docs_json = '[]'; // Inicializamos con array vacío en JSON

if ($propiedad_id) {
  $stmt_precio = $pdo->prepare("SELECT precio FROM propiedades WHERE id = ?");
  $stmt_precio->execute([$propiedad_id]);
  $precio_prop = $stmt_precio->fetchColumn();
  if ($precio_prop !== false) {
    $importe = $precio_prop;
  }
}

// Manejo POST (crear o editar contrato)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $inquilino_id = intval($_POST['inquilino_id'] ?? 0);
  $propiedad_id = intval($_POST['propiedad_id'] ?? 0);
  $fecha_inicio = $_POST['fecha_inicio'] ?? '';
  $fecha_fin = $_POST['fecha_fin'] ?? '';
  $importe = floatval($_POST['importe'] ?? 0);
  $garantia = $_POST['garantia'] ?? '';
  $corredor = $_POST['corredor'] ?? '';
  $estado = $_POST['estado'] ?? 'activo';
  $comentarios = $_POST['comentarios'] ?? '';
  $edit_id = intval($_POST['edit_id'] ?? 0);

  // Leer documentos previos si editando
  if ($edit_id > 0) {
    $stmt_docs = $pdo->prepare("SELECT documentos FROM contratos WHERE id = ?");
    $stmt_docs->execute([$edit_id]);
    $doc_previos = $stmt_docs->fetchColumn();
    if ($doc_previos) {
      $documentos_guardados = json_decode($doc_previos, true);
      if (!is_array($documentos_guardados)) {
        $documentos_guardados = [];
      }
    }
  }

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

  $todos_documentos = array_merge($documentos_guardados, $documentos_subidos);
  $docs_json = json_encode($todos_documentos);

  if (!$inquilino_id) $errors[] = "Debe seleccionar un inquilino.";
  if (!$propiedad_id) $errors[] = "Debe seleccionar una propiedad.";
  if (!$fecha_inicio) $errors[] = "Debe seleccionar fecha de inicio.";
  if (!$fecha_fin) $errors[] = "Debe seleccionar fecha de fin.";
  if (!$importe || $importe <= 0) $errors[] = "Debe ingresar un importe válido.";
  if (!in_array($estado, ['activo', 'finalizado'])) $estado = 'activo';
  if ($fecha_inicio && $fecha_fin && ($fecha_inicio > $fecha_fin)) {
    $errors[] = "La fecha de inicio debe ser anterior a la fecha de fin.";
  }

  // Verificar si la fecha de fin es menor a hoy
  if ($fecha_fin && (strtotime($fecha_fin) < time())) {
    $estado = 'finalizado'; // Marcar como finalizado
  } else {
    $estado = 'activo'; // Mantener como activo si la fecha de fin es mayor o igual a hoy
  }

  if (empty($errors)) {
    if ($edit_id > 0) {
      // Actualizar contrato con documentos
      $stmt = $pdo->prepare("UPDATE contratos SET inquilino_id=?, propiedad_id=?, fecha_inicio=?, fecha_fin=?, importe=?, garantia=?, corredor=?, estado=?, documentos=?, comentarios=? WHERE id=?");
      $stmt->execute([$inquilino_id, $propiedad_id, $fecha_inicio, $fecha_fin, $importe, $garantia, $corredor, $estado, $docs_json, $comentarios, $edit_id]);

      // Si el estado es finalizado, marcar la propiedad como libre
      if ($estado === 'finalizado') {
        $pdo->prepare("UPDATE propiedades SET estado = 'libre' WHERE id = ?")->execute([$propiedad_id]);
      }

      $message = "Contrato actualizado correctamente.";
      // Enviar email después de actualizar
      $contrato_id_envio = $edit_id;
    } else {
      // Insertar nuevo contrato con documentos
      $stmt = $pdo->prepare("INSERT INTO contratos (inquilino_id, propiedad_id, fecha_inicio, fecha_fin, importe, garantia, corredor, estado, documentos, comentarios) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ");
      $stmt->execute([$inquilino_id, $propiedad_id, $fecha_inicio, $fecha_fin, $importe, $garantia, $corredor, $estado, $docs_json, $comentarios]);
      $new_id = $pdo->lastInsertId();

      // Actualizar estado propiedad a "alquilado" solo si no está finalizado
      if ($estado !== 'finalizado') {
        $pdo->prepare("UPDATE propiedades SET estado = 'alquilado' WHERE id = ?")->execute([$propiedad_id]);
      }

      $message = "Contrato creado correctamente.";
      // Enviar email después de crear
      $contrato_id_envio = $new_id;
      // Obtener emails de propietario e inquilino
      $stmt = $pdo->prepare("SELECT c.*, i.email as inquilino_email, i.nombre as inquilino_nombre, p.propietario_id, p.nombre as propiedad_nombre, p.direccion, pr.email as propietario_email, pr.nombre as propietario_nombre FROM contratos c JOIN inquilinos i ON c.inquilino_id = i.id JOIN propiedades p ON c.propiedad_id = p.id JOIN propietarios pr ON p.propietario_id = pr.id WHERE c.id = ?");
      $stmt->execute([$contrato_id_envio]);
      $info = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($info) {
        $destinatarios = array_filter(array_merge(
          explode(',', $info['inquilino_email']),
          explode(',', $info['propietario_email'])
        ));
        $asunto = 'Nuevo Contrato registrado en RentFlow';
        $cuerpo = '<h2>Detalle del Contrato</h2>';
        $cuerpo .= '<b>Propiedad:</b> ' . htmlspecialchars($info['propiedad_nombre']) . ' (' . htmlspecialchars($info['direccion']) . ')<br>';
        $cuerpo .= '<b>Inquilino:</b> ' . htmlspecialchars($info['inquilino_nombre']) . '<br>';
        $cuerpo .= '<b>Propietario:</b> ' . htmlspecialchars($info['propietario_nombre']) . '<br>';
        $cuerpo .= '<b>Fecha inicio:</b> ' . htmlspecialchars($info['fecha_inicio']) . '<br>';
        $cuerpo .= '<b>Fecha fin:</b> ' . htmlspecialchars($info['fecha_fin']) . '<br>';
        $cuerpo .= '<b>Importe:</b> $' . number_format($info['importe'], 2, ',', '.') . '<br>';
        $cuerpo .= '<b>Estado:</b> ' . htmlspecialchars($info['estado']) . '<br>';
        enviar_email($destinatarios, $asunto, $cuerpo);
      }
    }
    header("Location: contratos.php?msg=" . urlencode($message) . "&contrato_id=" . urlencode($contrato_id_envio));
    exit();
  } else {
    $edit_data = [
      'inquilino_id' => $inquilino_id,
      'propiedad_id' => $propiedad_id,
      'fecha_inicio' => $fecha_inicio,
      'fecha_fin' => $fecha_fin,
      'importe' => $importe,
      'garantia' => $garantia,
      'corredor' => $corredor,
      'estado' => $estado,
      'documentos' => $docs_json,
      'comentarios' => $comentarios,
    ];
  }
} elseif ($edit_id > 0) {
  $stmt = $pdo->prepare("SELECT * FROM contratos WHERE id = ?");
  $stmt->execute([$edit_id]);
  $edit_data = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($edit_data) {
    $edit_data['comentarios'] = $edit_data['comentarios'] ?? '';
  } else {
    $edit_id = 0;
    $edit_data = null;
  }
} else {
  $edit_data = $propiedad_id_param ? ['propiedad_id' => $propiedad_id_param, 'importe' => $importe, 'estado' => 'activo'] : null;
}

$msg = $_GET['msg'] ?? '';
if ($msg) {
  $message = $msg;
}
$contrato_id = $_GET['contrato_id'] ?? '';

$inquilinos = $pdo->query("SELECT id, nombre FROM inquilinos ORDER BY nombre ASC")->fetchAll();
$propiedades = $pdo->query("SELECT id, nombre, estado, precio FROM propiedades WHERE estado IN ('libre','en venta','uso propio') ORDER BY nombre ASC")->fetchAll();

$contratos = $pdo->query("SELECT 
  c.*, i.nombre as inquilino_nombre, p.nombre as propiedad_nombre 
  FROM contratos c 
  JOIN inquilinos i ON c.inquilino_id = i.id 
  JOIN propiedades p ON c.propiedad_id = p.id
  ORDER BY c.id DESC")->fetchAll();

// Add property filter to include the property being edited
if ($edit_id > 0) {
  $stmt = $pdo->prepare("SELECT id, nombre, estado, precio FROM propiedades WHERE id = ?");
  $stmt->execute([$edit_data['propiedad_id']]);
  $propiedad_edit = $stmt->fetch();
  if ($propiedad_edit) {
    $propiedades[] = $propiedad_edit;
  }
}

// Añadimos función estado_label con badges coloreados
function estado_label($e)
{
  switch ($e) {
    case 'activo':
      return '<span class="badge bg-success">Activo</span>';
    case 'finalizado':
      return '<span class="badge bg-danger">Finalizado</span>';
    default:
      return ucfirst($e);
  }
}

include 'includes/header_nav.php';
?>

<main class="container container-main py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Contratos</h1>
    <button class="btn btn-lg btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formContratoCollapse" aria-expanded="<?= ($edit_id || !empty($errors) || $propiedad_id_param) ? 'true' : 'false' ?>" aria-controls="formContratoCollapse" style="font-weight:600;">
      <?= ($edit_id || !empty($errors) || $propiedad_id_param) ? 'Ocultar' : 'Agregar Nuevo Contrato' ?>
    </button>
  </div>

  <?php if ($message): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php if ($contrato_id): ?>
      <a href="contratos.php?edit=<?= $contrato_id ?>" class="btn btn-success mb-3">Ver contrato</a>
    <?php endif; ?>
  <?php endif; ?>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <ul><?php foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?></ul>
    </div>
  <?php endif; ?>

  <?php if ($edit_id): ?>
    <a href="pagos.php?contrato_id=<?= intval($edit_id) ?>" class="btn btn-success mb-3">Registrar Pagos</a>
  <?php endif; ?>


  <div class="collapse <?= ($edit_id || !empty($errors) || $propiedad_id_param) ? 'show' : '' ?>" id="formContratoCollapse">
    <div class="card p-4 mb-4 mt-3">
      <h3><?= $edit_id ? "Editar Contrato" : "Nuevo Contrato" ?></h3>
      <form method="POST" enctype="multipart/form-data" novalidate id="formContrato">
        <input type="hidden" name="edit_id" value="<?= $edit_id ?: '' ?>" />

        <div class="mb-3">
          <label for="propiedad_id" class="form-label">Propiedad *</label>
          <select name="propiedad_id" id="propiedad_id" class="form-select" required>
            <option value="">Seleccione...</option>
            <?php foreach ($propiedades as $p): ?>
              <option value="<?= $p['id'] ?>"
                <?= (($edit_data['propiedad_id'] ?? '') == $p['id']) ? 'selected' : '' ?>
                data-precio="<?= htmlspecialchars($p['precio']) ?>">
                <?= htmlspecialchars($p['nombre']) ?> (<?= $p['estado'] ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <a href="propiedades.php?add=true" class="btn btn-success btn-sm">Agregar Propiedad Nueva</a>
          <?php if ($edit_id > 0): ?>
            <a href="propiedades.php?edit=<?= htmlspecialchars($edit_data['propiedad_id'] ?? '') ?>" class="btn btn-primary btn-sm">Editar Propiedad</a>
          <?php endif; ?>
        </div>

        <div class="mb-3">
          <label for="inquilino_id" class="form-label">Inquilino *</label>
          <select name="inquilino_id" id="inquilino_id" class="form-select" required>
            <option value="">Seleccione...</option>
            <?php foreach ($inquilinos as $i): ?>
              <option value="<?= $i['id'] ?>" <?= (($edit_data['inquilino_id'] ?? '') == $i['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($i['nombre']) . " - " . $i['id'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <a href="inquilinos.php?add=true" class="btn btn-success btn-sm">Agregar Nuevo Inquilino</a>
        </div>

        <div class="mb-3">
          <label for="fecha_inicio" class="form-label">Fecha de Inicio *</label>
          <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required
            value="<?= htmlspecialchars($edit_data['fecha_inicio'] ?? date('Y-m-d')) ?>">
        </div>

        <div class="mb-3">
          <label for="fecha_fin" class="form-label">Fecha de Fin *</label>
          <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required
            value="<?= htmlspecialchars($edit_data['fecha_fin'] ?? date('Y-m-d', strtotime('+1 year'))) ?>">
        </div>

        <div class="mb-3">
          <label for="importe" class="form-label">Importe *</label>
          <input type="number" step="0.01" min="0" class="form-control" id="importe" name="importe" required value="<?= htmlspecialchars($edit_data['importe'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label for="garantia" class="form-label">Garantía</label>
          <input type="text" class="form-control" id="garantia" name="garantia" value="<?= htmlspecialchars($edit_data['garantia'] ?? '') ?>" />
        </div>

        <div class="mb-3">
          <label for="corredor" class="form-label">Corredor</label>
          <input type="text" class="form-control" id="corredor" name="corredor" value="<?= htmlspecialchars($edit_data['corredor'] ?? '') ?>" />
        </div>

        <div class="mb-3">
          <label for="estado" class="form-label">Estado *</label>
          <select name="estado" id="estado" class="form-select" required>
            <option value="activo" <?= ($edit_data['estado'] ?? '') === 'activo' ? 'selected' : '' ?>>Activo</option>
            <option value="finalizado" <?= ($edit_data['estado'] ?? '') === 'finalizado' ? 'selected' : '' ?>>Finalizado</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="comentarios" class="form-label">Comentarios</label>
          <textarea class="form-control" id="comentarios" name="comentarios" rows="3"><?= htmlspecialchars($edit_data['comentarios'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
          <label for="documentos" class="form-label">Adjuntar Documentos</label>
          <input type="file" name="documentos[]" multiple class="form-control" />
        </div>

        <?php if (!empty($edit_data['documentos'])):
          $documentos = json_decode($edit_data['documentos'], true);
          if (is_array($documentos) && count($documentos) > 0):
        ?>
            <div class="mb-3">
              <label class="form-label">Documentos Adjuntos:</label>
              <ul>
                <?php foreach ($documentos as $doc): ?>
                  <li><a href="uploads/<?= htmlspecialchars($doc) ?>" target="_blank"><?= htmlspecialchars($doc) ?></a></li>
                <?php endforeach; ?>
              </ul>
            </div>
        <?php endif;
        endif; ?>

        <button type="submit" class="btn btn-lg btn-primary fw-semibold mt-3"><?= $edit_id ? "Actualizar" : "Guardar" ?></button>
        <?php if ($edit_id): ?>
          <a href="contratos.php" class="btn btn-lg btn-outline-secondary ms-2 mt-3">Cancelar</a>
        <?php endif; ?>
      </form>
    </div>
  </div>

  <?php if (!($edit_id || !empty($errors) || $propiedad_id_param)): ?>
    <section>
      <h2 class="fw-semibold mb-3">Listado de Contratos</h2>
      <?php if (count($contratos) === 0): ?>
        <p>No hay contratos registrados.</p>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table align-middle table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Contrato</th>
                <th>Pagos</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($contratos as $c): ?>
                <tr>
                  <td><?= htmlspecialchars($c['id']) ?></td>
                  <td>
                    <a href="contratos.php?edit=<?= intval($c['id']) ?>" class="text-decoration-none text-dark"><b><?= htmlspecialchars($c['propiedad_nombre']) ?></b> <?= htmlspecialchars($c['inquilino_nombre']) ?><br>
                      <?= estado_label($c['estado']) ?>
                      <small>
                        <nobr>$ <?= number_format($c['importe'], 2, ",", ".") ?></nobr><br>
                        <?= date('d/m/Y', strtotime($c['fecha_inicio'])) ?> a <?= date('d/m/Y', strtotime($c['fecha_fin'])) ?>
                      </small>
                    </a><br>
                    <?php
                    $docs = [];
                    if (!empty($c['documentos'])) {
                      $docs = json_decode($c['documentos'], true);
                      if (!is_array($docs)) $docs = [];
                    }
                    foreach ($docs as $doc) {
                      $ext = strtolower(pathinfo($doc, PATHINFO_EXTENSION));
                      if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                        echo '<a href="uploads/' . htmlspecialchars($doc) . '" target="_blank" class="vista-previa">';
                        echo '<img src="uploads/' . htmlspecialchars($doc) . '" alt="img">';
                        echo '</a>';
                      } else {
                        echo '<a href="uploads/' . htmlspecialchars($doc) . '" target="_blank" title="Ver documento" class="vista-previa"><i class="bi bi-paperclip"></i></a>';
                      }
                    }
                    ?>
                  </td>
                  <td>
                    <a href="pagos.php?contrato_id=<?= intval($c['id']) ?>" class="btn btn-sm btn-success">Pagos</a>
                  </td>
                  <!--<td style="min-width:130px;">
                    <a href="contratos.php?edit=<?= intval($c['id']) ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                    <a href="contratos.php?delete=<?= intval($c['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que desea eliminar este contrato y sus pagos?')">Eliminar</a>
                  </td>-->
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </section>
  <?php endif; ?>

</main>
<script>
  const collapseContrato = document.getElementById('formContratoCollapse');
  const toggleBtnContrato = document.querySelector('button[data-bs-target="#formContratoCollapse"]');
  collapseContrato.addEventListener('show.bs.collapse', () => toggleBtnContrato.textContent = 'Ocultar');
  collapseContrato.addEventListener('hide.bs.collapse', () => toggleBtnContrato.textContent = 'Agregar Nuevo Contrato');

  document.getElementById('propiedad_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const precio = selectedOption.getAttribute('data-precio');
    if (precio !== null) {
      document.getElementById('importe').value = precio;
    } else {
      document.getElementById('importe').value = '';
    }
  });
</script>

<?php
include 'includes/footer.php';
?>