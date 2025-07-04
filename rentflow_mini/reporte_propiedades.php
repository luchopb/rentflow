<?php
require_once 'config.php';
check_login();
$page_title = 'Reporte de Propiedades';

header('Content-Type: text/html; charset=utf-8');

// Consulta para obtener todos los datos requeridos
$sql = "
SELECT 
  p.id AS propiedad_id, p.nombre AS propiedad_nombre, p.tipo, p.direccion, p.galeria, p.local, p.estado, p.precio, p.imagenes, p.documentos AS propiedad_documentos,
  pr.nombre AS propietario_nombre,
  i.id AS inquilino_id, i.nombre AS inquilino_nombre, i.telefono AS inquilino_telefono, i.vehiculo AS inquilino_vehiculo, i.matricula AS inquilino_matricula, i.documentos AS inquilino_documentos,
  c.id AS contrato_id, c.fecha_inicio, c.fecha_fin, c.importe, c.documentos AS contrato_documentos,
  pa.id AS pago_id, pa.concepto, pa.fecha, pa.periodo, pa.tipo_pago, pa.importe AS pago_importe, pa.comprobante
FROM propiedades p
LEFT JOIN propietarios pr ON pr.id = p.propietario_id
LEFT JOIN contratos c ON c.propiedad_id = p.id 
    -- AND c.estado = 'activo' 
    -- AND CURDATE() BETWEEN c.fecha_inicio AND c.fecha_fin
LEFT JOIN inquilinos i ON c.inquilino_id = i.id
LEFT JOIN pagos pa ON pa.contrato_id = c.id
ORDER BY p.id DESC, pa.fecha DESC
";


$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


function bg($n) {
  $colors = ['#e3f2fd', '#e8f5e9', '#fff3e0', '#f3e5f5'];
  return $colors[$n % count($colors)];
}

function archivos($arr, $dir = 'uploads/') {
  // Si está vacío, retornar guión
  if (empty($arr)) {
    return '';
  }
  
  // Si es un string JSON válido, intentar decodificarlo
  if (is_string($arr)) {
    $decoded = json_decode($arr, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
      // Es un JSON válido con array, recorrer y crear links
      $out = '';
      foreach ($decoded as $archivo) {
        $out .= '<a href="' . $dir . htmlspecialchars($archivo) . '" target="_blank">' . htmlspecialchars($archivo) . '</a> ';
      }
      return $out;
    } else {
      // No es JSON válido, mostrar como string simple
      return '<a href="' . $dir . htmlspecialchars($arr) . '" target="_blank">' . htmlspecialchars($arr) . '</a>';
    }
  }

  // Si no se pudo procesar, retornar el valor original como string
  return htmlspecialchars($arr);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($page_title) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .bg-prop { background-color:rgb(181, 224, 255) !important; }
    .bg-owner { background-color:rgb(255, 249, 178) !important; }
    .bg-inq { background-color:rgb(183, 255, 189) !important; }
    .bg-ctr { background-color:rgb(255, 229, 186) !important; }
    .bg-pay { background-color:rgb(246, 191, 255) !important; }
    th, td { vertical-align: middle !important; font-size: 12px; }
    .nowrap { white-space: nowrap; }
  </style>
</head>
<body class="container-fluid px-4 py-4">
  <h1 class="mb-4">Reporte de Propiedades</h1>
  <a href="#" class="btn btn-success mb-3" onclick="exportTableToExcel('tabla_reporte', 'reporte_propiedades')">Exportar a Excel</a>
  <div class="table-responsive">
    <table class="table table-bordered align-middle border-dark" id="tabla_reporte">
      <thead>
        <tr>
          <th class="bg-prop">ID Propiedad</th>
          <th class="bg-prop">Nombre</th>
          <th class="bg-prop">Tipo</th>
          <th class="bg-prop">Dirección</th>
          <th class="bg-prop">Galería</th>
          <th class="bg-prop">Local</th>
          <th class="bg-prop">Estado</th>
          <th class="bg-prop">Precio</th>
          <th class="bg-prop">Imágenes</th>
          <th class="bg-prop">Docs Adjuntos</th>
          <th class="bg-owner">Propietario</th>
          <th class="bg-inq">ID Inquilino</th>
          <th class="bg-inq">Nombre Inquilino</th>
          <th class="bg-inq">Teléfono</th>
          <th class="bg-inq">Vehículo</th>
          <th class="bg-inq">Matrícula</th>
          <th class="bg-inq">Docs Adjuntos</th>
          <th class="bg-ctr">ID Contrato</th>
          <th class="bg-ctr">Fecha Inicio</th>
          <th class="bg-ctr">Fecha Fin</th>
          <th class="bg-ctr">Importe</th>
          <th class="bg-ctr">Docs Adjuntos</th>
          <th class="bg-pay">ID Pago</th>
          <th class="bg-pay">Concepto</th>
          <th class="bg-pay">Fecha</th>
          <th class="bg-pay">Periodo</th>
          <th class="bg-pay">Tipo de Pago</th>
          <th class="bg-pay">Importe</th>
          <th class="bg-pay">Comprobante</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
        <tr>
          <td class="bg-prop nowrap"><?= $r['propiedad_id'] ?></td>
          <td class="bg-prop"><?= htmlspecialchars($r['propiedad_nombre'] ?? '') ?></td>
          <td class="bg-prop"><?= htmlspecialchars($r['tipo'] ?? '') ?></td>
          <td class="bg-prop"><?= htmlspecialchars($r['direccion'] ?? '') ?></td>
          <td class="bg-prop"><?= htmlspecialchars($r['galeria'] ?? '') ?></td>
          <td class="bg-prop"><?= htmlspecialchars($r['local'] ?? '') ?></td>
          <td class="bg-prop"><?= htmlspecialchars($r['estado'] ?? '') ?></td>
          <td class="bg-prop">$ <?= number_format($r['precio'] ?? 0, 2, ',', '.') ?></td>
          <td class="bg-prop"><?= archivos($r['imagenes']) ?></td>
          <td class="bg-prop"><?= archivos($r['propiedad_documentos']) ?></td>
          <td class="bg-owner"><?= htmlspecialchars($r['propietario_nombre'] ?? '') ?></td>
          <td class="bg-inq nowrap"><?= $r['inquilino_id'] ?></td>
          <td class="bg-inq"><?= htmlspecialchars($r['inquilino_nombre'] ?? '') ?></td>
          <td class="bg-inq"><?= htmlspecialchars($r['inquilino_telefono'] ?? '') ?></td>
          <td class="bg-inq"><?= htmlspecialchars($r['inquilino_vehiculo'] ?? '') ?></td>
          <td class="bg-inq"><?= htmlspecialchars($r['inquilino_matricula'] ?? '') ?></td>
          <td class="bg-inq"><?= archivos($r['inquilino_documentos']) ?></td>
          <td class="bg-ctr nowrap"><?= $r['contrato_id'] ?></td>
          <td class="bg-ctr"><?= htmlspecialchars($r['fecha_inicio'] ?? '') ?></td>
          <td class="bg-ctr"><?= htmlspecialchars($r['fecha_fin'] ?? '') ?></td>
          <td class="bg-ctr">$ <?= number_format($r['importe'] ?? 0, 2, ',', '.') ?></td>
          <td class="bg-ctr"><?= archivos($r['contrato_documentos']) ?></td>
          <td class="bg-pay nowrap"><?= $r['pago_id'] ?></td>
          <td class="bg-pay"><?= htmlspecialchars($r['concepto'] ?? '') ?></td>
          <td class="bg-pay"><?= htmlspecialchars($r['fecha'] ?? '') ?></td>
          <td class="bg-pay"><?= htmlspecialchars($r['periodo'] ?? '') ?></td>
          <td class="bg-pay"><?= htmlspecialchars($r['tipo_pago'] ?? '') ?></td>
          <td class="bg-pay">$ <?= number_format($r['pago_importe'] ?? 0, 2, ',', '.') ?></td>
          <td class="bg-pay"><?= archivos($r['comprobante']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <script>
    function exportTableToExcel(tableID, filename = '') {
      var dataType = 'application/vnd.ms-excel';
      var tableSelect = document.getElementById(tableID);
      var tableHTML = tableSelect.outerHTML;
      filename = filename ? filename + '.xls' : 'excel_data.xls';
      var utf8BOM = '\uFEFF';
      var blob = new Blob([utf8BOM + tableHTML], { type: dataType });
      var downloadLink = document.createElement('a');
      downloadLink.href = URL.createObjectURL(blob);
      downloadLink.download = filename;
      document.body.appendChild(downloadLink);
      downloadLink.click();
      document.body.removeChild(downloadLink);
    }
  </script>
</body>
</html> 