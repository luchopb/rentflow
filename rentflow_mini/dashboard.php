<?php
require_once 'config.php';
check_login();
$page_title = 'Dashboard - Inmobiliaria';
include 'includes/header_nav.php';

// Obtener el mes y año actual
$mes_actual = date('m');
$anio_actual = date('Y');
$periodo = date('Y-m');
$search = clean_input($_GET['search'] ?? '');

// Obtener propiedades y sus inquilinos actuales
$stmt = $pdo->prepare("
    SELECT c.id AS id, p.nombre AS propiedad_nombre, i.nombre AS inquilino_nombre, c.fecha_fin 
    FROM propiedades p
    INNER JOIN contratos c ON p.id = c.propiedad_id AND c.estado = 'activo'
    LEFT JOIN inquilinos i ON c.inquilino_id = i.id
");
$stmt->execute();
$propiedades_inquilinos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener pagos del mes actual
$stmt_pagos = $pdo->prepare("
    SELECT contrato_id 
    FROM pagos 
    WHERE periodo = ? AND concepto = 'Pago mensual'
");
$stmt_pagos->execute([$periodo]);
$pagos_mes_actual = $stmt_pagos->fetchAll(PDO::FETCH_COLUMN, 0); // Obtener solo los contrato_id

?>

<main class="container container-main">
  <h1>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?></h1>

  <form action="propiedades.php" method="GET" class="mb-4" role="search" aria-label="Buscar propiedades">
    <div class="input-group" style="max-width:480px;">
      <input
        type="search"
        name="search"
        class="form-control"
        placeholder="Buscar por nombre, dirección, local o inquilino"
        value="<?= htmlspecialchars($search) ?>"
        aria-label="Buscar propiedades" autocomplete="off" />
      <button class="btn btn-primary" type="submit" aria-label="Buscar">Buscar</button>
      <?php if ($search): ?>
        <a href="dashboard.php" class="btn btn-outline-secondary" aria-label="Limpiar búsqueda">Limpiar</a>
      <?php endif; ?>
    </div>
  </form>


  <section class="mt-2">
    <div class="d-flex gap-3">
      <a href="propiedades.php" class="btn btn-primary flex-fill">Propiedades</a>
      <a href="inquilinos.php" class="btn btn-primary flex-fill">Inquilinos</a>
      <a href="contratos.php" class="btn btn-primary flex-fill">Contratos</a>
    </div>
  </section>

  <section class="mt-5">
    <h2 class="fw-semibold">Pagos Mensuales</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Contrato</th>
          <th>Pago <?php 
              // Crea un objeto DateTime con el año y mes deseados
              $fecha = new DateTime("$anio_actual-$mes_actual-01");
              // Obtiene el nombre del mes en español
              $meses = [
                  1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                  5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                  9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
              ];
              $nombre_mes = $meses[(int)$fecha->format('n')]; // Obtiene el número del mes y lo convierte a nombre
              // Muestra el mes y el año
              echo ucfirst($nombre_mes) . ' ' . $anio_actual;
          ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($propiedades_inquilinos as $row): ?>
          <tr>
            <td><b><?= htmlspecialchars($row['propiedad_nombre']) ?></b><br><?= htmlspecialchars($row['inquilino_nombre'] ?? 'N/A') ?></td>
            <td>
              <?php if (in_array($row['id'], $pagos_mes_actual)): ?>
                <a href="pagos.php?contrato_id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Pago recibido</a>
              <?php else: ?>
                <a href="pagos.php?contrato_id=<?= $row['id'] ?>" class="btn btn-outline-success btn-sm">Registrar pago</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>

</main>

<?php
include 'includes/footer.php';
?>