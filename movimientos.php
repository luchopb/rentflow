<?php
require_once 'config.php';
check_login();
$page_title = 'Movimientos - Inmobiliaria';

$propiedad_id = intval($_GET['propiedad_id'] ?? 0);

if (!$propiedad_id) {
    header("Location: propiedades.php");
    exit();
}

// Obtener información de la propiedad
$stmt = $pdo->prepare("SELECT p.*, pr.nombre as propietario_nombre FROM propiedades p LEFT JOIN propietarios pr ON p.propietario_id = pr.id WHERE p.id = ?");
$stmt->execute([$propiedad_id]);
$propiedad = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$propiedad) {
    header("Location: propiedades.php");
    exit();
}

// Obtener contratos activos de la propiedad
$stmt = $pdo->prepare("SELECT c.*, i.nombre as inquilino_nombre FROM contratos c LEFT JOIN inquilinos i ON c.inquilino_id = i.id WHERE c.propiedad_id = ? AND c.estado = 'activo' AND CURDATE() BETWEEN c.fecha_inicio AND c.fecha_fin");
$stmt->execute([$propiedad_id]);
$contratos_activos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener pagos de la propiedad (a través de contratos)
$stmt = $pdo->prepare("
  SELECT 
    'pago' as tipo,
    p.id,
    p.fecha,
    p.periodo,
    p.concepto,
    p.importe,
    p.tipo_pago,
    p.comentario,
    p.comprobante,
    p.fecha_creacion,
    c.id as contrato_id,
    i.nombre as inquilino_nombre,
    u.username as usuario_nombre
  FROM pagos p
  JOIN contratos c ON p.contrato_id = c.id
  LEFT JOIN inquilinos i ON c.inquilino_id = i.id
  LEFT JOIN usuarios u ON p.usuario_id = u.id
  WHERE c.propiedad_id = ?
  ORDER BY p.fecha DESC, p.id DESC
");
$stmt->execute([$propiedad_id]);
$pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener gastos de la propiedad
$stmt = $pdo->prepare("
  SELECT 
    'gasto' as tipo,
    g.id,
    g.fecha,
    g.concepto,
    g.importe,
    g.forma_pago,
    g.observaciones as comentario,
    g.comprobante,
    g.fecha_creacion,
    u.username as usuario_nombre
  FROM gastos g
  LEFT JOIN usuarios u ON g.usuario_id = u.id
  WHERE g.propiedad_id = ?
  ORDER BY g.fecha DESC, g.id DESC
");
$stmt->execute([$propiedad_id]);
$gastos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Combinar y ordenar cronológicamente
$movimientos = array_merge($pagos, $gastos);

// Ordenar por fecha descendente (más recientes primero)
usort($movimientos, function ($a, $b) {
    $fecha_a = strtotime($a['fecha']);
    $fecha_b = strtotime($b['fecha']);
    if ($fecha_a == $fecha_b) {
        return $b['id'] - $a['id']; // Si misma fecha, por ID descendente
    }
    return $fecha_b - $fecha_a;
});

// Calcular totales
$total_pagos = array_sum(array_column($pagos, 'importe'));
$total_gastos = array_sum(array_column($gastos, 'importe'));
$balance = $total_pagos - $total_gastos;

include 'includes/header_nav.php';
?>

<main class="container container-main">

    <!-- Información de la propiedad compacta -->
    <div class="card mb-3">
        <div class="card-body py-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-1"><?= htmlspecialchars($propiedad['nombre']) ?></h4>
                    <small class="text-muted"><?= htmlspecialchars($propiedad['tipo']) ?> - <?= htmlspecialchars($propiedad['direccion']) ?></small>
                </div>
                <div class="text-end">
                    <div class="mb-1">
                        <?php
                        $estado_class = match ($propiedad['estado']) {
                            'libre' => 'bg-danger',
                            'alquilado' => 'bg-success',
                            'uso propio' => 'bg-info',
                            'en venta' => 'bg-warning text-dark',
                            default => 'bg-secondary'
                        };
                        ?>
                        <span class="badge <?= $estado_class ?>"><?= ucfirst($propiedad['estado']) ?></span>
                    </div>
                    <div class="small text-muted">
                        $<?= number_format($propiedad['precio'], 0, ',', '.') ?>
                        <?php if (!empty($contratos_activos)): ?>
                            <br><a href="contratos.php?edit=<?= $contratos_activos[0]['id'] ?>" class="text-decoration-none"><?= htmlspecialchars($contratos_activos[0]['inquilino_nombre']) ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Botones de registro de pagos y gastos -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex gap-2">
            <?php if (!empty($contratos_activos)): ?>
                <a href="pagos.php?contrato_id=<?= $contratos_activos[0]['id'] ?>&add=true" class="btn btn-lg btn-primary" style="font-weight:600;">
                    <i class="bi bi-cash-coin"></i> Registrar Pago
                </a>
            <?php endif; ?>
            <a href="gastos.php?propiedad_id=<?= $propiedad_id ?>&add=true" class="btn btn-lg btn-warning" style="font-weight:600;">
                <i class="bi bi-receipt"></i> Registrar Gasto
            </a>
        </div>
    </div>



    <!-- Movimientos cronológicos compactos -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Movimientos</h5>
        </div>
        <div class="card-body p-0">
            <?php if (empty($movimientos)): ?>
                <div class="alert alert-info m-3">No hay movimientos registrados para esta propiedad.</div>
            <?php else: ?>
                <div class="list-group list-group-flush">
                    <?php foreach ($movimientos as $movimiento): ?>
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div class="d-flex align-items-center">
                                            <?php if ($movimiento['tipo'] === 'pago'): ?>
                                                <span class="badge bg-success me-2">PAGO</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger me-2">GASTO</span>
                                            <?php endif; ?>
                                            <strong><?= htmlspecialchars($movimiento['concepto']) ?></strong>
                                        </div>
                                        <small class="text-muted"><?= date('d/m/Y', strtotime($movimiento['fecha'])) ?></small>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="<?= $movimiento['tipo'] === 'pago' ? 'text-success' : 'text-danger' ?> fw-bold">
                                                <?= $movimiento['tipo'] === 'pago' ? '+' : '-' ?>$<?= number_format($movimiento['importe'], 0, ',', '.') ?>
                                            </span>
                                            <small class="text-muted ms-2">
                                                <?php if ($movimiento['tipo'] === 'pago' && $movimiento['tipo_pago']): ?>
                                                    <?= htmlspecialchars($movimiento['tipo_pago']) ?>
                                                <?php elseif ($movimiento['tipo'] === 'gasto' && $movimiento['forma_pago']): ?>
                                                    <?= htmlspecialchars($movimiento['forma_pago']) ?>
                                                <?php endif; ?>
                                            </small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <?php if ($movimiento['comentario']): ?>
                                                <button type="button" class="btn btn-sm btn-outline-info me-2" title="Ver Comentario" onclick="toggleComentario(<?= $movimiento['id'] ?>)">
                                                    <i class="bi bi-chat-text"></i>
                                                </button>
                                            <?php endif; ?>
                                            <?php if ($movimiento['comprobante']): ?>
                                                <a href="uploads/<?= htmlspecialchars($movimiento['comprobante']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary me-2" title="Ver Comprobante">
                                                    <i class="bi bi-file-earmark"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($_SESSION['user_role'] === 'admin'): ?>
                                                <?php if ($movimiento['tipo'] === 'pago'): ?>
                                                    <a href="pagos.php?contrato_id=<?= $movimiento['contrato_id'] ?>&edit=<?= $movimiento['id'] ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                <?php else: ?>
                                                    <a href="gastos.php?edit=<?= $movimiento['id'] ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Comentario oculto - fila separada -->
                            <?php if ($movimiento['comentario']): ?>
                                <div id="comentario-<?= $movimiento['id'] ?>" class="mt-2 p-2 bg-light rounded" style="display: none;">
                                    <small class="text-muted">
                                        <i class="bi bi-chat-text me-1"></i>
                                        <strong>Comentario:</strong> <?= htmlspecialchars($movimiento['comentario']) ?>
                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <!-- Resumen financiero compacto -->
    <div class="row my-4">
        <div class="col-4">
            <div class="card text-center text-white bg-success">
                <div class="card-body py-2">
                    <h6 class="card-title mb-1">Pagos</h6>
                    <h5 class="card-text mb-0">$<?= number_format($total_pagos, 0, ',', '.') ?></h5>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card text-center text-white bg-danger">
                <div class="card-body py-2">
                    <h6 class="card-title mb-1">Gastos</h6>
                    <h5 class="card-text mb-0">$<?= number_format($total_gastos, 0, ',', '.') ?></h5>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card text-center text-white <?= $balance >= 0 ? 'bg-info' : 'bg-warning' ?>">
                <div class="card-body py-2">
                    <h6 class="card-title mb-1">Balance</h6>
                    <h5 class="card-text mb-0">$<?= number_format($balance, 0, ',', '.') ?></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="my-4">
        <a href="propiedades.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver a Propiedades
        </a>
    </div>

</main>


<?php include 'includes/footer.php'; ?>

<script>
    function toggleComentario(movimientoId) {
        const comentario = document.getElementById('comentario-' + movimientoId);
        const boton = event.target.closest('button');
        const icono = boton.querySelector('i');

        if (comentario.style.display === 'none' || comentario.style.display === '') {
            comentario.style.display = 'block';
            icono.className = 'bi bi-chat-text-fill';
            boton.title = 'Ocultar Comentario';
        } else {
            comentario.style.display = 'none';
            icono.className = 'bi bi-chat-text';
            boton.title = 'Ver Comentario';
        }
    }
</script>