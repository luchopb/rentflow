<?php
require_once 'config.php';
check_login();
$page_title = 'Reporte de Propiedades - Impuestos';

header('Content-Type: text/html; charset=utf-8');

// Consulta para obtener solo las propiedades con sus datos de impuestos
$sql = "
SELECT 
  p.id AS propiedad_id, 
  p.nombre AS propiedad_nombre, 
  p.tipo, 
  p.direccion, 
  p.galeria, 
  p.local, 
  p.estado,
  p.ose,
  p.ute,
  p.padron,
  p.imm_tasa_general,
  p.imm_tarifa_saneamiento,
  p.imm_instalaciones,
  p.imm_adicional_mercantil,
  p.contribucion_inmobiliaria,
  p.anep,
  p.convenios
FROM propiedades p
ORDER BY p.id DESC
";

$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

function bg($n) {
  $colors = ['#e3f2fd', '#e8f5e9', '#fff3e0', '#f3e5f5'];
  return $colors[$n % count($colors)];
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
    .bg-impuestos { background-color:rgb(255, 229, 186) !important; }
    th, td { vertical-align: middle !important; font-size: 12px; }
    .nowrap { white-space: nowrap; }
  </style>
</head>
<body class="container-fluid px-4 py-4">
  <h1 class="mb-4">Reporte de Propiedades - Impuestos</h1>
  <a href="#" class="btn btn-success mb-3" onclick="exportTableToExcel('tabla_reporte', 'reporte_propiedades_impuestos')">Exportar a Excel</a>
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
          <th class="bg-impuestos">OSE</th>
          <th class="bg-impuestos">UTE</th>
          <th class="bg-impuestos">Padrón</th>
          <th class="bg-impuestos">IMM Tasa General</th>
          <th class="bg-impuestos">IMM Tarifa Saneamiento</th>
          <th class="bg-impuestos">IMM Instalaciones</th>
          <th class="bg-impuestos">IMM Adicional Mercantil</th>
          <th class="bg-impuestos">Contribución Inmobiliaria</th>
          <th class="bg-impuestos">ANEP</th>
          <th class="bg-impuestos">Convenios</th>
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
          <td class="bg-impuestos"><?= htmlspecialchars($r['ose'] ?? '') ?></td>
          <td class="bg-impuestos"><?= htmlspecialchars($r['ute'] ?? '') ?></td>
          <td class="bg-impuestos"><?= htmlspecialchars($r['padron'] ?? '') ?></td>
          <td class="bg-impuestos"><?= htmlspecialchars($r['imm_tasa_general'] ?? '') ?></td>
          <td class="bg-impuestos"><?= htmlspecialchars($r['imm_tarifa_saneamiento'] ?? '') ?></td>
          <td class="bg-impuestos"><?= htmlspecialchars($r['imm_instalaciones'] ?? '') ?></td>
          <td class="bg-impuestos"><?= htmlspecialchars($r['imm_adicional_mercantil'] ?? '') ?></td>
          <td class="bg-impuestos"><?= htmlspecialchars($r['contribucion_inmobiliaria'] ?? '') ?></td>
          <td class="bg-impuestos"><?= htmlspecialchars($r['anep'] ?? '') ?></td>
          <td class="bg-impuestos"><?= htmlspecialchars($r['convenios'] ?? '') ?></td>
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