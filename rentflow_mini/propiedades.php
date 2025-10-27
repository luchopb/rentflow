<?php
require_once 'config.php';
check_login();
$page_title = 'Propiedades - Inmobiliaria';

$edit_id = intval($_GET['edit'] ?? 0);
$delete_id = intval($_GET['delete'] ?? 0);
$message = '';
$propiedad_id = '';
$errors = [];
$busqueda = clean_input($_GET['search'] ?? '');
$filtro_tipo = clean_input($_GET['filtro_tipo'] ?? '');
$filtro_propietario = intval($_GET['filtro_propietario'] ?? 0);
$filtro_estado = clean_input($_GET['filtro_estado'] ?? '');
$filtro_contrato = clean_input($_GET['filtro_contrato'] ?? '');
$filtro_ultimo_pago = clean_input($_GET['filtro_ultimo_pago'] ?? '');

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
$propiedad_id = $_GET['propiedad_id'] ?? '';

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
  $link_mercadolibre = clean_input($_POST['link_mercadolibre'] ?? '');
  $link_otras = clean_input($_POST['link_otras'] ?? '');
  $ose = clean_input($_POST['ose'] ?? '');
  $ute = clean_input($_POST['ute'] ?? '');
  $padron = clean_input($_POST['padron'] ?? '');
  $imm_tasa_general = clean_input($_POST['imm_tasa_general'] ?? '');
  $imm_tarifa_saneamiento = clean_input($_POST['imm_tarifa_saneamiento'] ?? '');
  $imm_instalaciones = clean_input($_POST['imm_instalaciones'] ?? '');
  $imm_adicional_mercantil = clean_input($_POST['imm_adicional_mercantil'] ?? '');
  $convenios = clean_input($_POST['convenios'] ?? '');
  $propietario_id = intval($_POST['propietario_id'] ?? 0);

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
  if (!$propietario_id) $errors[] = "El propietario es obligatorio.";
  if (!$estado || !in_array($estado, ['libre', 'alquilado', 'uso propio', 'en venta'])) $estado = 'libre';

  if (empty($errors)) {
    $imagenes_db = json_encode($gallery_images);
    $documentos_db = json_encode($attached_docs);
    $usuario_id = $_SESSION['user_id'];
    $fecha_hora = date('Y-m-d H:i:s');

    if ($edit_id > 0) {
      $stmt = $pdo->prepare("UPDATE propiedades SET nombre=?, tipo=?, direccion=?, imagenes=?, documentos=?, galeria=?, local=?, precio=?, incluye_gc=?, gastos_comunes=?, estado=?, anep=?, contribucion_inmobiliaria=?, comentarios=?, link_mercadolibre=?, link_otras=?, ose=?, ute=?, padron=?, imm_tasa_general=?, imm_tarifa_saneamiento=?, imm_instalaciones=?, imm_adicional_mercantil=?, convenios=?, propietario_id=?, usuario_id=?, fecha_modificacion=? WHERE id=?");
      $stmt->execute([$nombre, $tipo, $direccion, $imagenes_db, $documentos_db, $galeria, $local, $precio, $incluye_gc, $gastos_comunes, $estado, $anep, $contribucion_inmobiliaria, $comentarios, $link_mercadolibre, $link_otras, $ose, $ute, $padron, $imm_tasa_general, $imm_tarifa_saneamiento, $imm_instalaciones, $imm_adicional_mercantil, $convenios, $propietario_id, $usuario_id, $fecha_hora, $edit_id]);
      $propiedad_id = $edit_id;
      $message = "Propiedad actualizada correctamente.";
    } else {
      // Corregido: la cantidad de columnas y valores debe coincidir (26 columnas y 26 valores)
      $stmt = $pdo->prepare("INSERT INTO propiedades (nombre,tipo,direccion,imagenes,documentos,galeria,local,precio,incluye_gc,gastos_comunes,estado,anep,contribucion_inmobiliaria,comentarios,link_mercadolibre,link_otras,ose,ute,padron,imm_tasa_general,imm_tarifa_saneamiento,imm_instalaciones,imm_adicional_mercantil,convenios,propietario_id,usuario_id,fecha_creacion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
      $stmt->execute([$nombre, $tipo, $direccion, $imagenes_db, $documentos_db, $galeria, $local, $precio, $incluye_gc, $gastos_comunes, $estado, $anep, $contribucion_inmobiliaria, $comentarios, $link_mercadolibre, $link_otras, $ose, $ute, $padron, $imm_tasa_general, $imm_tarifa_saneamiento, $imm_instalaciones, $imm_adicional_mercantil, $convenios, $propietario_id, $usuario_id, $fecha_hora]);
      $propiedad_id = $pdo->lastInsertId();
      $message = "Propiedad creada correctamente.";
    }
    header("Location: propiedades.php?msg=" . urlencode($message) . "&propiedad_id=" . urlencode($propiedad_id));
    exit();
  } else {
    $edit_data = compact('nombre', 'tipo', 'direccion', 'galeria', 'local', 'precio', 'incluye_gc', 'gastos_comunes', 'estado', 'anep', 'contribucion_inmobiliaria', 'comentarios', 'link_mercadolibre', 'link_otras', 'ose', 'ute', 'padron', 'imm_tasa_general', 'imm_tarifa_saneamiento', 'imm_instalaciones', 'imm_adicional_mercantil', 'convenios', 'propietario_id');
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
      $edit_data['propietario_id'] = $edit_data['propietario_id'] ?? '';
    }
  }
}


// Consulta con búsqueda y filtros
$busqueda = clean_input($_GET['search'] ?? '');
$filtro_tipo = clean_input($_GET['filtro_tipo'] ?? '');
$filtro_propietario = intval($_GET['filtro_propietario'] ?? 0);
$filtro_estado = clean_input($_GET['filtro_estado'] ?? '');
$filtro_contrato = clean_input($_GET['filtro_contrato'] ?? '');
$filtro_ultimo_pago = clean_input($_GET['filtro_ultimo_pago'] ?? '');
$params = [];
$sql = "SELECT p.*, c.id AS contrato_id, i.nombre AS inquilino_nombre, i.id AS inquilino_id, pr.nombre AS propietario,
        (SELECT MAX(periodo) FROM pagos WHERE contrato_id = c.id AND concepto = 'Pago mensual') AS fecha_ultimo_pago,
        (SELECT tipo_pago FROM pagos WHERE contrato_id = c.id AND concepto = 'Pago mensual' AND periodo = (SELECT MAX(periodo) FROM pagos WHERE contrato_id = c.id AND concepto = 'Pago mensual') LIMIT 1) AS tipo_ultimo_pago
        FROM propiedades p 
        LEFT JOIN contratos c ON c.propiedad_id = p.id 
          AND c.estado = 'activo' 
          AND CURDATE() BETWEEN c.fecha_inicio AND c.fecha_fin 
        LEFT JOIN inquilinos i ON c.inquilino_id = i.id
        LEFT JOIN propietarios pr ON p.propietario_id = pr.id";

$where_conditions = [];
if ($busqueda) {
  $where_conditions[] = "(p.nombre LIKE ? OR p.direccion LIKE ? OR p.local LIKE ? OR i.nombre LIKE ?)";
  $like_search = '%' . $busqueda . '%';
  $params = array_merge($params, [$like_search, $like_search, $like_search, $like_search]);
}
if ($filtro_tipo) {
  $where_conditions[] = "p.tipo = ?";
  $params[] = $filtro_tipo;
}
if ($filtro_propietario) {
  $where_conditions[] = "p.propietario_id = ?";
  $params[] = $filtro_propietario;
}
if ($filtro_estado) {
  $where_conditions[] = "p.estado = ?";
  $params[] = $filtro_estado;
}
if ($filtro_contrato === 'vigente') {
  $where_conditions[] = "c.id IS NOT NULL";
}
if ($filtro_contrato === 'sin') {
  $where_conditions[] = "c.id IS NULL";
}
if ($filtro_ultimo_pago === 'con') {
  $mes_actual = date('Y-m');
  $where_conditions[] = "(SELECT MAX(periodo) FROM pagos WHERE contrato_id = c.id AND concepto = 'Pago mensual') = ?";
  $params[] = $mes_actual;
}
if ($filtro_ultimo_pago === 'sin') {
  $mes_actual = date('Y-m');
  $where_conditions[] = "((SELECT MAX(periodo) FROM pagos WHERE contrato_id = c.id AND concepto = 'Pago mensual') IS NULL OR (SELECT MAX(periodo) FROM pagos WHERE contrato_id = c.id AND concepto = 'Pago mensual') <> ?)";
  $params[] = $mes_actual;
}
if (!empty($where_conditions)) {
  $sql .= " WHERE " . implode(' AND ', $where_conditions);
}

$sql .= " ORDER BY p.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$propiedades = $stmt->fetchAll();

// Contador por tipo de propiedad (filtrado)
$tipos = ['Local', 'Apartamento', 'Cochera', 'Garage', 'Depósito', 'Casa'];
$contador_tipos = [];

// Contador total filtrado
$sql_total = "SELECT COUNT(*) as total FROM propiedades p 
              LEFT JOIN contratos c ON c.propiedad_id = p.id 
                AND c.estado = 'activo' 
                AND CURDATE() BETWEEN c.fecha_inicio AND c.fecha_fin 
              LEFT JOIN inquilinos i ON c.inquilino_id = i.id";

$where_conditions_count = [];
$params_count = [];

if ($busqueda) {
  $where_conditions_count[] = "(p.nombre LIKE ? OR p.direccion LIKE ? OR p.local LIKE ? OR i.nombre LIKE ?)";
  $like_search = '%' . $busqueda . '%';
  $params_count = array_merge($params_count, [$like_search, $like_search, $like_search, $like_search]);
}

if ($filtro_tipo) {
  $where_conditions_count[] = "p.tipo = ?";
  $params_count[] = $filtro_tipo;
}

if ($filtro_propietario) {
  $where_conditions_count[] = "p.propietario_id = ?";
  $params_count[] = $filtro_propietario;
}

if ($filtro_estado) {
  $where_conditions_count[] = "p.estado = ?";
  $params_count[] = $filtro_estado;
}

if ($filtro_contrato === 'vigente') {
  $where_conditions_count[] = "c.id IS NOT NULL";
}
if ($filtro_contrato === 'sin') {
  $where_conditions_count[] = "c.id IS NULL";
}
if ($filtro_ultimo_pago === 'con') {
  $where_conditions_count[] = "(SELECT MAX(periodo) FROM pagos WHERE contrato_id = c.id AND concepto = 'Pago mensual') = ?";
  $params_count[] = date('Y-m');
}
if ($filtro_ultimo_pago === 'sin') {
  $where_conditions_count[] = "((SELECT MAX(periodo) FROM pagos WHERE contrato_id = c.id AND concepto = 'Pago mensual') IS NULL OR (SELECT MAX(periodo) FROM pagos WHERE contrato_id = c.id AND concepto = 'Pago mensual') <> ?)";
  $params_count[] = date('Y-m');
}

if (!empty($where_conditions_count)) {
  $sql_total .= " WHERE " . implode(' AND ', $where_conditions_count);
}

$stmt_total = $pdo->prepare($sql_total);
$stmt_total->execute($params_count);
$total_propiedades = $stmt_total->fetch()['total'];

// Contador por tipo (aplicando los mismos filtros)
foreach ($tipos as $tipo) {
  $sql_count = "SELECT COUNT(*) as total FROM propiedades p 
                LEFT JOIN contratos c ON c.propiedad_id = p.id 
                  AND c.estado = 'activo' 
                  AND CURDATE() BETWEEN c.fecha_inicio AND c.fecha_fin 
                LEFT JOIN inquilinos i ON c.inquilino_id = i.id";

  $where_conditions_count = [];
  $params_count = [];

  if ($busqueda) {
    $where_conditions_count[] = "(p.nombre LIKE ? OR p.direccion LIKE ? OR p.local LIKE ? OR i.nombre LIKE ?)";
    $like_search = '%' . $busqueda . '%';
    $params_count = array_merge($params_count, [$like_search, $like_search, $like_search, $like_search]);
  }

  // Si hay filtro de tipo, solo contar ese tipo específico
  if ($filtro_tipo) {
    if ($filtro_tipo === $tipo) {
      $where_conditions_count[] = "p.tipo = ?";
      $params_count[] = $tipo;
    } else {
      // Para otros tipos, establecer contador en 0 cuando hay filtro específico
      $contador_tipos[$tipo] = 0;
      continue;
    }
  } else {
    // Si no hay filtro de tipo, contar todos los tipos
    $where_conditions_count[] = "p.tipo = ?";
    $params_count[] = $tipo;
  }

  if ($filtro_propietario) {
    $where_conditions_count[] = "p.propietario_id = ?";
    $params_count[] = $filtro_propietario;
  }

  if ($filtro_estado) {
    $where_conditions_count[] = "p.estado = ?";
    $params_count[] = $filtro_estado;
  }

  if ($filtro_contrato === 'vigente') {
    $where_conditions_count[] = "c.id IS NOT NULL";
  }
  if ($filtro_contrato === 'sin') {
    $where_conditions_count[] = "c.id IS NULL";
  }
  if ($filtro_ultimo_pago === 'con') {
    $where_conditions_count[] = "(SELECT MAX(periodo) FROM pagos WHERE contrato_id = c.id AND concepto = 'Pago mensual') = ?";
    $params_count[] = date('Y-m');
  }
  if ($filtro_ultimo_pago === 'sin') {
    $where_conditions_count[] = "((SELECT MAX(periodo) FROM pagos WHERE contrato_id = c.id AND concepto = 'Pago mensual') IS NULL OR (SELECT MAX(periodo) FROM pagos WHERE contrato_id = c.id AND concepto = 'Pago mensual') <> ?)";
    $params_count[] = date('Y-m');
  }

  if (!empty($where_conditions_count)) {
    $sql_count .= " WHERE " . implode(' AND ', $where_conditions_count);
  }

  $stmt_count = $pdo->prepare($sql_count);
  $stmt_count->execute($params_count);
  $contador_tipos[$tipo] = $stmt_count->fetch()['total'];
}

// Obtener conteo de propiedades y contratos activos por tipo para la tarjeta
$stmt_propiedades_tarjeta = $pdo->query("
    SELECT p.tipo, 
           COUNT(*) as total,
           SUM(CASE WHEN c.estado = 'activo' THEN 1 ELSE 0 END) as ocupadas
    FROM propiedades p
    LEFT JOIN contratos c ON p.id = c.propiedad_id AND c.estado = 'activo'
    GROUP BY p.tipo
    ORDER BY total DESC
");
$propiedades_por_tipo_tarjeta = $stmt_propiedades_tarjeta->fetchAll(PDO::FETCH_ASSOC);
$total_propiedades_tarjeta = array_sum(array_column($propiedades_por_tipo_tarjeta, 'total'));
$total_ocupadas_tarjeta = array_sum(array_column($propiedades_por_tipo_tarjeta, 'ocupadas'));
$ratio_ocupacion_tarjeta = $total_propiedades_tarjeta > 0 ? round(($total_ocupadas_tarjeta / $total_propiedades_tarjeta) * 100) : 0;

include 'includes/header_nav.php';

?>

<main class="container container-main py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Propiedades</h1>
    <button class="btn btn-lg btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formPropiedadCollapse" aria-expanded="<?= $edit_id || !empty($errors) ? 'true' : 'false' ?>" aria-controls="formPropiedadCollapse" style="font-weight:600;">
      <?= $show_form || $edit_id || !empty($errors) ? 'Ocultar' : 'Agregar Nueva Propiedad' ?>
    </button>
  </div>

  <?php if ($message): ?>
    <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php if ($propiedad_id): ?>
      <a href="propiedades.php?edit=<?= $propiedad_id ?>" class="btn btn-success mb-3">Ver propiedad</a>
    <?php endif; ?>
  <?php endif; ?>

  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <ul><?php foreach ($errors as $e) echo "<li>" . htmlspecialchars($e) . "</li>"; ?></ul>
    </div>
  <?php endif; ?>


  <div class="collapse <?= $show_form || $edit_id || !empty($errors) ? 'show' : '' ?>" id="formPropiedadCollapse">
    <div class="card mb-4 mt-3">
      <div class="card-header">
        <h5><?= $edit_id ? "Editar Propiedad" : "Nueva Propiedad" ?></h5>
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
                  'Garage' => 'Garage',
                  'Depósito' => 'Depósito',
                  'Casa' => 'Casa'
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

            <!-- Campo Propietario -->
            <div class="mb-3">
              <label for="propietario_id" class="form-label">Propietario *</label>
              <select class="form-select" id="propietario_id" name="propietario_id" required>
                <?php
                try {
                  $propietarios = $pdo->query("SELECT id, nombre FROM propietarios ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
                  if (count($propietarios) === 0) {
                    echo '<option value="">No hay propietarios cargados</option>';
                  } else {
                    echo '<option value="">Seleccione...</option>';
                    foreach ($propietarios as $prop) {
                      $sel = ($edit_data['propietario_id'] ?? '') == $prop['id'] ? "selected" : "";
                      echo "<option value=\"{$prop['id']}\" $sel>{$prop['nombre']}</option>";
                    }
                  }
                } catch (Exception $e) {
                  echo '<option value="">Tabla propietarios no existe</option>';
                }
                ?>
              </select>
            </div>

            <div class="mb-3">
              <a href="propietarios.php?add=true" target="_blank" class="btn btn-outline-primary btn-sm">Agregar nuevo propietario</a>
            </div>

            <div class="mb-3">
              <label for="comentarios" class="form-label">Comentarios</label>
              <textarea class="form-control" id="comentarios" name="comentarios" rows="3"><?= htmlspecialchars($edit_data['comentarios'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
              <label for="link_mercadolibre" class="form-label">Link MercadoLibre</label>
              <div class="input-group">
                <input type="url" class="form-control" id="link_mercadolibre" name="link_mercadolibre" value="<?= htmlspecialchars($edit_data['link_mercadolibre'] ?? '') ?>" />
                <?php if (!empty($edit_data['link_mercadolibre'])): ?>
                  <a href="<?= htmlspecialchars($edit_data['link_mercadolibre']) ?>" target="_blank" class="btn btn-info">Abrir</a>
                <?php endif; ?>
              </div>
            </div>

            <div class="mb-3">
              <label for="link_otras" class="form-label">Link Otras plataformas</label>
              <div class="input-group">
                <input type="url" class="form-control" id="link_otras" name="link_otras" value="<?= htmlspecialchars($edit_data['link_otras'] ?? '') ?>" />
                <?php if (!empty($edit_data['link_otras'])): ?>
                  <a href="<?= htmlspecialchars($edit_data['link_otras']) ?>" target="_blank" class="btn btn-info">Abrir</a>
                <?php endif; ?>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Galería de imágenes</label>
              <input type="file" name="imagenes[]" multiple accept="image/*" class="form-control" />
            </div>

            <?php if (!empty($edit_data['imagenes_arr'])): ?>
              <div class="mb-3" id="image-preview-container">
                <?php foreach ($edit_data['imagenes_arr'] as $idx => $img): ?>
                  <div class="img-preview" data-img="<?= htmlspecialchars($img) ?>">
                    <button type="button" class="btn-remove-image" title="Eliminar imagen" onclick="removeImage('<?= htmlspecialchars($img) ?>')">&times;</button>
                    <img src="uploads/<?= htmlspecialchars($img) ?>" alt="" style="max-height:80px; max-width:100px; border-radius:0.5rem; cursor:pointer;" onclick="openGalleryModal(<?= $idx ?>)" />
                  </div>
                <?php endforeach; ?>
              </div>

              <!-- Modal Galería de Imágenes -->
              <div id="galleryModal" class="gallery-modal" style="display:none;">
                <span class="gallery-close" onclick="closeGalleryModal()">&times;</span>
                <img class="gallery-modal-content" id="galleryModalImg" src="" alt="Imagen" />
                <button type="button" class="gallery-nav gallery-prev" onclick="galleryPrev(event)">&#10094;</button>
                <button type="button" class="gallery-nav gallery-next" onclick="galleryNext(event)">&#10095;</button>
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
                <button class="btn btn-secondary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#additionalDataContent">
                  Ver más datos <i class="bi bi-plus"></i>
                </button>
              </h2>
              <div id="additionalDataContent" class="accordion-collapse collapse" data-bs-parent="#additionalDataAccordion">
                <div class="accordion-body px-1">
                  <div class="mb-3">
                    <label for="ose" class="form-label">OSE</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="ose" name="ose" step="1" min="0" value="<?= htmlspecialchars($edit_data['ose'] ?? '') ?>" />
                      <?php if ($edit_id): ?>
                        <a href="https://facturas.ose.com.uy/SGCv10WebClient/inicio.faces" target="_blank" class="btn btn-info">Consultar</a>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="ute" class="form-label">UTE</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="ute" name="ute" step="1" min="0" value="<?= htmlspecialchars($edit_data['ute'] ?? '') ?>" />
                      <?php if ($edit_id): ?>
                        <a href="https://www.ute.com.uy/imprima-su-factura" target="_blank" class="btn btn-info">Consultar</a>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="anep" class="form-label">ANEP</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="anep" name="anep" value="<?= htmlspecialchars($edit_data['anep'] ?? '') ?>" />
                      <?php if ($edit_id): ?>
                        <a href="https://dgi-anep.organismos.uy/paso1?0" target="_blank" class="btn btn-info">Consultar</a>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="padron" class="form-label">Padrón</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="padron" name="padron" step="1" min="0" value="<?= htmlspecialchars($edit_data['padron'] ?? '') ?>" />
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="contribucion_inmobiliaria" class="form-label">IMM Contribución Inmobiliaria (Propietario)</label>
                    <div class="input-group">
                      <input type="text" class="form-control" step="1" id="contribucion_inmobiliaria" name="contribucion_inmobiliaria" value="<?= htmlspecialchars($edit_data['contribucion_inmobiliaria'] ?? '') ?>" />
                      <?php if ($edit_id): ?>
                        <a href="https://www.montevideo.gub.uy/fwtc/pages/contribucion.xhtml" target="_blank" class="btn btn-info">Consultar</a>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="imm_tasa_general" class="form-label">IMM Tasa general</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="imm_tasa_general" name="imm_tasa_general" step="1" min="0" value="<?= htmlspecialchars($edit_data['imm_tasa_general'] ?? '') ?>" />
                      <?php if ($edit_id): ?>
                        <a href="https://www.montevideo.gub.uy/fwtc/pages/tributosDomiciliarios.xhtml" target="_blank" class="btn btn-info">Consultar</a>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="imm_tarifa_saneamiento" class="form-label">IMM Tarifa de saneamiento</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="imm_tarifa_saneamiento" name="imm_tarifa_saneamiento" step="1" min="0" value="<?= htmlspecialchars($edit_data['imm_tarifa_saneamiento'] ?? '') ?>" />
                      <?php if ($edit_id): ?>
                        <a href="https://www.montevideo.gub.uy/fwtc/pages/saneamiento.xhtml" target="_blank" class="btn btn-info">Consultar</a>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="imm_instalaciones" class="form-label">IMM Instalaciones mecánicas eléctricas</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="imm_instalaciones" name="imm_instalaciones" step="1" min="0" value="<?= htmlspecialchars($edit_data['imm_instalaciones'] ?? '') ?>" />
                      <?php if ($edit_id): ?>
                        <a href="https://www.montevideo.gub.uy/fwtc/pages/tributosDomiciliarios.xhtml" target="_blank" class="btn btn-info">Consultar</a>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="imm_adicional_mercantil" class="form-label">IMM Adicional mercantil</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="imm_adicional_mercantil" name="imm_adicional_mercantil" step="1" min="0" value="<?= htmlspecialchars($edit_data['imm_adicional_mercantil'] ?? '') ?>" />
                      <?php if ($edit_id): ?>
                        <a href="https://www.montevideo.gub.uy/fwtc/pages/tributosDomiciliarios.xhtml" target="_blank" class="btn btn-info">Consultar</a>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="convenios" class="form-label">Convenios</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="convenios" name="convenios" step="1" min="0" value="<?= htmlspecialchars($edit_data['convenios'] ?? '') ?>" />
                      <?php if ($edit_id): ?>
                        <a href="https://www.montevideo.gub.uy/fwtc/pages/convenios.xhtml" target="_blank" class="btn btn-info">Consultar</a>
                      <?php endif; ?>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-lg btn-primary fw-semibold"><?= $edit_id ? "Actualizar" : "Guardar" ?></button>
          <?php if ($edit_id): ?>
            <a href="propiedades.php" class="btn btn-lg btn-outline-secondary ms-2">Cancelar</a>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>


  <?php if (!($edit_id || !empty($errors) || $show_form)): ?>

    <div class="card mb-4">
      <div class="card-header" style="cursor:pointer;" data-bs-toggle="collapse" data-bs-target="#filtrosCollapse" aria-expanded="true" aria-controls="filtrosCollapse">
        <h5 class="mb-0">Filtros</h5>
      </div>
      <div id="filtrosCollapse" class="card-body collapse">
        <form method="GET" role="search" aria-label="Buscar propiedades">
          <div class="row g-3" style="max-width:1200px;">
            <div class="col-md-4">
              <label for="search" class="form-label">Buscar</label>
              <input
                type="search"
                name="search"
                class="form-control"
                placeholder="Nombre, dirección, local o inquilino..."
                value="<?= htmlspecialchars($busqueda) ?>"
                aria-label="Buscar propiedades" autocomplete="off" />
            </div>
            <div class="col-md-4 col-6">
              <label for="filtro_propietario" class="form-label">Propietario</label>
              <select name="filtro_propietario" class="form-select" aria-label="Filtrar por propietario">
                <option value="0">Todos</option>
                <?php
                $propietarios = $pdo->query("SELECT id, nombre FROM propietarios ORDER BY nombre")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($propietarios as $prop): ?>
                  <option value="<?= $prop['id'] ?>" <?= $filtro_propietario == $prop['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($prop['nombre']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4 col-6">
              <label for="filtro_tipo" class="form-label">Tipo de propiedad</label>
              <select name="filtro_tipo" class="form-select" aria-label="Filtrar por tipo">
                <option value="">Todos</option>
                <?php foreach ($tipos as $tipo): ?>
                  <option value="<?= htmlspecialchars($tipo) ?>" <?= $filtro_tipo === $tipo ? 'selected' : '' ?>>
                    <?= htmlspecialchars($tipo) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-4 col-6">
              <label for="filtro_estado" class="form-label">Estado</label>
              <select name="filtro_estado" class="form-select" aria-label="Filtrar por estado">
                <option value="">Todos</option>
                <option value="libre" <?= $filtro_estado === 'libre' ? 'selected' : '' ?>>Libre</option>
                <option value="alquilado" <?= $filtro_estado === 'alquilado' ? 'selected' : '' ?>>Alquilado</option>
                <option value="uso propio" <?= $filtro_estado === 'uso propio' ? 'selected' : '' ?>>Uso Propio</option>
                <option value="en venta" <?= $filtro_estado === 'en venta' ? 'selected' : '' ?>>En Venta</option>
              </select>
            </div>
            <div class="col-md-4 col-6">
              <label for="filtro_contrato" class="form-label">Contrato</label>
              <select name="filtro_contrato" class="form-select" aria-label="Filtrar por contrato">
                <option value="">Todos</option>
                <option value="vigente" <?= $filtro_contrato === 'vigente' ? 'selected' : '' ?>>Vigente</option>
                <option value="sin" <?= $filtro_contrato === 'sin' ? 'selected' : '' ?>>Sin contrato</option>
              </select>
            </div>
            <div class="col-md-4 col-6">
              <label for="filtro_ultimo_pago" class="form-label">Último Pago</label>
              <select name="filtro_ultimo_pago" class="form-select" aria-label="Filtrar por último pago">
                <option value="">Todos</option>
                <option value="con" <?= $filtro_ultimo_pago === 'con' ? 'selected' : '' ?>>Con pago este mes</option>
                <option value="sin" <?= $filtro_ultimo_pago === 'sin' ? 'selected' : '' ?>>Sin pago este mes</option>
              </select>
            </div>
            <div class="col-12">
              <button class="btn btn-primary" type="submit" aria-label="Buscar">Aplicar Filtros</button>
              <?php if ($busqueda || $filtro_tipo || $filtro_propietario || $filtro_estado || $filtro_contrato || $filtro_ultimo_pago): ?>
                <a href="propiedades.php" class="btn btn-outline-secondary" aria-label="Limpiar búsqueda">Borrar filtros</a>
              <?php endif; ?>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Tarjeta de Resumen de Propiedades -->
    <div class="row mb-4">
      <div class="col-md-12">
        <a href="contratos.php" class="text-decoration-none">
          <div class="card mb-2">
            <div class="card-body py-2">
              <h6 class="card-title mb-1 text-success">Propiedades Ocupadas</h6>
              <p class="card-text h4 mb-1"><?= $total_ocupadas_tarjeta ?>/<?= $total_propiedades_tarjeta ?></p>
              <div class="progress mb-1" role="progressbar" aria-label="Progreso de ocupación" style="height: 6px;">
                <div class="progress-bar" style="width: <?= $ratio_ocupacion_tarjeta ?>%"></div>
              </div>
              <div class="small">
                <?php foreach ($propiedades_por_tipo_tarjeta as $tipo): ?>
                  <?php
                  $ratio_tipo = $tipo['total'] > 0 ? round(($tipo['ocupadas'] / $tipo['total']) * 100) : 0;
                  ?>
                  <div class="d-flex justify-content-between">
                    <span class="text-capitalize"><?= htmlspecialchars($tipo['tipo']) ?>:</span>
                    <span><?= $tipo['ocupadas'] ?>/<?= $tipo['total'] ?> (<?= $ratio_tipo ?>%)</span>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>

    <section>
      <h2 class="fw-semibold mb-3">Listado de Propiedades</h2>
      <div class="mb-3">
        <span class="badge bg-dark-subtle text-black">Total: <?= $total_propiedades ?></span>
        <?php foreach ($tipos as $tipo): ?>
          <?php if ($contador_tipos[$tipo] > 0): ?>
            <span class="badge bg-body-secondary text-black"><?= htmlspecialchars($tipo) ?>: <?= $contador_tipos[$tipo] ?></span>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
      <?php if (count($propiedades) === 0): ?>
        <p>No hay propiedades registradas.</p>
      <?php else: ?>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <td class="p-0"></td>
                <th>Propiedad</th>
                <th>Contrato</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($propiedades as $p): ?>
                <tr>
                  <td class="p-0">
                    <div class="rounded-circle">
                      <?php if (!empty($p['imagenes'])):
                        $imagenes = json_decode($p['imagenes'], true);
                        if (!empty($imagenes[0])): ?>
                          <img src="uploads/<?= htmlspecialchars($imagenes[0]) ?>">
                        <?php else: ?>
                          <i class="bi bi-<?= $p['tipo'] === 'Cochera' ? 'car-front-fill' : 'house-door-fill' ?>"></i>
                        <?php endif; ?>
                      <?php else: ?>
                        <i class="bi bi-<?= $p['tipo'] === 'Cochera' ? 'car-front-fill' : 'house-door-fill' ?>"></i>
                      <?php endif; ?>
                    </div>
                  </td>
                  <td>
                    <b><a href="propiedades.php?edit=<?= intval($p['id']) ?>" class="text-decoration-none text-dark">
                        <?= intval($p['id']) ?>.
                        <?= htmlspecialchars($p['nombre']) ?></b> (<?= htmlspecialchars($p['tipo']) ?>)</a><br>
                    <?= htmlspecialchars($p['direccion']) ?><br>
                    <?= estado_label($p['estado']) ?> <small>
                      <nobr>$ <?= number_format($p['precio'], 2, ",", ".") ?></nobr><br>
                      <?= htmlspecialchars($p['propietario']) ?><br>
                      <?php if (!empty($p['link_mercadolibre'])): ?>
                        <a href="<?= htmlspecialchars($p['link_mercadolibre']) ?>" target="_blank" class="badge bg-warning text-dark text-decoration-none">
                          MercadoLibre
                        </a>
                      <?php endif; ?>
                    </small>
                  </td>
                  <td>
                    <?php if ($p['contrato_id'] && $p['inquilino_nombre']): ?>
                      <a href="inquilinos.php?edit=<?= intval($p['inquilino_id']) ?>" class="text-decoration-none text-dark">
                        <b><?= htmlspecialchars($p['inquilino_nombre']) ?></b>
                      </a>
                      <small class="d-block">
                        <?php if ($p['fecha_ultimo_pago']): ?>
                          <?php
                          $ultimo_pago = date('m/Y', strtotime($p['fecha_ultimo_pago']));
                          $periodo_actual = date('m/Y');
                          $badge_class = ($ultimo_pago === $periodo_actual) ? 'bg-success' : 'bg-warning text-dark';
                          $tipo_pago = $p['tipo_ultimo_pago'] ?? '';
                          ?>
                          <span class="badge <?= $badge_class ?>" style="max-width: 130px; overflow: hidden; text-overflow: ellipsis;"><?= $ultimo_pago ?><?= $tipo_pago ? ' ' . htmlspecialchars($tipo_pago) : '' ?></span>
                        <?php else: ?>
                          <span class="badge bg-danger">Sin pago</span>
                        <?php endif; ?>
                      </small>
                      <div class="mt-2">
                        <a href="pagos.php?contrato_id=<?= intval($p['contrato_id']) ?>" class="btn btn-sm btn-light bg-dark-subtle mb-1">
                          Pagos
                        </a>
                        <a href="gastos.php?propiedad_id=<?= intval($p['id']) ?>&add=true" class="btn btn-sm btn-light bg-dark-subtle mb-1">
                          Gastos
                        </a>
                        <a href="contratos.php?edit=<?= intval($p['contrato_id']) ?>" class="btn btn-sm btn-light bg-dark-subtle mb-1">
                          Contrato
                        </a>
                        <a href="movimientos.php?propiedad_id=<?= intval($p['id']) ?>" class="btn btn-sm btn-light bg-dark-subtle mb-1">
                          Movimientos
                        </a>
                      </div>
                    <?php else: ?>
                      <div class="mt-2">
                        <a href="contratos.php?propiedad_id=<?= intval($p['id']) ?>" class="btn btn-sm btn-light bg-dark-subtle mb-1 me-2" style="white-space: nowrap;">
                          Crear contrato
                        </a>
                        <a href="movimientos.php?propiedad_id=<?= intval($p['id']) ?>" class="btn btn-sm btn-light bg-dark-subtle mb-1 me-2">
                          Movimientos
                        </a>
                      </div>
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
  <?php endif; ?>

  <?php if ($edit_id): ?>
    <!-- Historial de Contratos -->
    <div class="card mt-4">
      <div class="card-header">
        <h5 class="mb-0">Historial de Contratos</h5>
      </div>
      <div class="card-body">
        <?php
        // Consulta para obtener el historial de contratos de esta propiedad
        $stmt_contratos = $pdo->prepare("
          SELECT 
            c.id AS contrato_id,
            c.fecha_inicio,
            c.fecha_fin,
            c.importe,
            c.estado,
            c.fecha_creacion,
            i.nombre AS inquilino_nombre,
            i.id AS inquilino_id
          FROM contratos c
          LEFT JOIN inquilinos i ON c.inquilino_id = i.id
          WHERE c.propiedad_id = ?
          ORDER BY c.fecha_inicio DESC
        ");
        $stmt_contratos->execute([$edit_id]);
        $contratos_historial = $stmt_contratos->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <?php if (empty($contratos_historial)): ?>
          <p class="text-muted">No hay contratos registrados para esta propiedad.</p>
          <a href="contratos.php?propiedad_id=<?= intval($edit_id) ?>" class="btn btn-success btn-sm mt-2">Crear contrato</a>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-sm">
              <tbody>
                <?php foreach ($contratos_historial as $contrato): ?>
                  <tr>
                    <td>
                      <?php if ($contrato['inquilino_nombre']): ?>
                        <a href="inquilinos.php?edit=<?= $contrato['inquilino_id'] ?>" class="text-decoration-none text-dark fw-bold">
                          <?= htmlspecialchars($contrato['inquilino_nombre']) ?>
                        </a>
                      <?php else: ?>
                        <span class="text-muted">Inquilino eliminado</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <small>
                        <?= date('d/m/Y', strtotime($contrato['fecha_inicio'])) ?> a <?= date('d/m/Y', strtotime($contrato['fecha_fin'])) ?><br>
                        <?php
                        $estado_class = $contrato['estado'] === 'activo' ? 'bg-success' : 'bg-secondary';
                        $estado_text = ucfirst($contrato['estado']);
                        ?>
                        <span class="badge <?= $estado_class ?>"><?= $estado_text ?></span>
                        $<?= number_format($contrato['importe'], 2, ',', '.') ?>
                      </small>
                    </td>
                    <td>
                      <a href="movimientos.php?propiedad_id=<?= intval($edit_id) ?>" class="btn btn-sm btn-info">
                        Movimientos
                      </a>
                      <a href="contratos.php?edit=<?= $contrato['contrato_id'] ?>" class="btn btn-sm btn-primary">
                        Contrato
                      </a>
                      <a href="pagos.php?contrato_id=<?= $contrato['contrato_id'] ?>" class="btn btn-sm btn-success">
                        Pagos
                      </a>
                      <a href="gastos.php?propiedad_id=<?= intval($edit_id) ?>&add=true" class="btn btn-sm btn-warning">
                        Gastos
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

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

  <?php if (!empty($edit_data['imagenes_arr'])): ?>
    // Galería de imágenes en modal
    const galleryImages = <?= json_encode($edit_data['imagenes_arr']) ?>;
    let currentGalleryIdx = 0;

    function openGalleryModal(idx) {
      currentGalleryIdx = idx;
      const modal = document.getElementById('galleryModal');
      const modalImg = document.getElementById('galleryModalImg');
      modalImg.src = 'uploads/' + galleryImages[currentGalleryIdx];
      modal.style.display = 'flex';
      document.body.style.overflow = 'hidden';
    }

    function closeGalleryModal() {
      document.getElementById('galleryModal').style.display = 'none';
      document.body.style.overflow = '';
    }

    function galleryPrev(e) {
      e.stopPropagation();
      currentGalleryIdx = (currentGalleryIdx - 1 + galleryImages.length) % galleryImages.length;
      document.getElementById('galleryModalImg').src = 'uploads/' + galleryImages[currentGalleryIdx];
    }

    function galleryNext(e) {
      e.stopPropagation();
      currentGalleryIdx = (currentGalleryIdx + 1) % galleryImages.length;
      document.getElementById('galleryModalImg').src = 'uploads/' + galleryImages[currentGalleryIdx];
    }

    // Cerrar modal al hacer click fuera de la imagen
    document.getElementById('galleryModal').addEventListener('click', function(e) {
      if (e.target === this) closeGalleryModal();
    });
    // Cerrar con ESC
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') closeGalleryModal();
    });
  <?php endif; ?>
</script>

<?php
include 'includes/footer.php';
?>