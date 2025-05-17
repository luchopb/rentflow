<?php
require_once '../../config/database.php';

// Obtener cantidad de contratos activos
$stmt = $conn->prepare("
    SELECT COUNT(*) as total 
    FROM contratos 
    WHERE estado = 'Activo'
");
$stmt->execute();
$contratos_activos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Obtener cantidad de deudores (inquilinos con pagos vencidos)
$stmt = $conn->prepare("
    SELECT COUNT(DISTINCT c.inquilino_id) as total
    FROM contratos c
    JOIN pagos p ON p.contrato_id = c.id
    WHERE p.estado = 'Vencido'
    AND c.estado = 'Activo'
");
$stmt->execute();
$deudores = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Obtener próximos vencimientos (20 días)
$stmt = $conn->prepare("
    SELECT 
        p.fecha_vencimiento,
        p.monto,
        pr.direccion as propiedad,
        i.nombre as inquilino,
        i.dni
    FROM pagos p
    JOIN contratos c ON p.contrato_id = c.id
    JOIN propiedades pr ON c.propiedad_id = pr.id
    JOIN inquilinos i ON c.inquilino_id = i.id
    WHERE p.fecha_vencimiento BETWEEN CURRENT_DATE AND DATE_ADD(CURRENT_DATE, INTERVAL 20 DAY)
    AND p.estado = 'Pendiente'
    AND c.estado = 'Activo'
    ORDER BY p.fecha_vencimiento ASC
");
$stmt->execute();
$proximos_vencimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid py-4">
    <!-- Indicadores -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Contratos Activos</h5>
                    <h2 class="display-4"><?php echo $contratos_activos; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Deudores</h5>
                    <h2 class="display-4"><?php echo $deudores; ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <h5 class="card-title">Próximos Vencimientos</h5>
                    <h2 class="display-4"><?php echo count($proximos_vencimientos); ?></h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Acciones Rápidas</h5>
                    <button class="btn btn-primary me-2" onclick="nuevoInquilino()">
                        <i class="fas fa-user-plus"></i> Nuevo Inquilino
                    </button>
                    <button class="btn btn-success me-2" onclick="nuevaPropiedad()">
                        <i class="fas fa-home"></i> Nueva Propiedad
                    </button>
                    <button class="btn btn-info me-2" onclick="nuevoContrato()">
                        <i class="fas fa-file-signature"></i> Nuevo Contrato
                    </button>
                    <button class="btn btn-warning" onclick="nuevoPago()">
                        <i class="fas fa-money-bill-wave"></i> Registrar Pago
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Próximos Vencimientos -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Próximos Vencimientos (20 días)</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Propiedad</th>
                                    <th>Inquilino</th>
                                    <th>Monto</th>
                                    <th>Días Restantes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($proximos_vencimientos as $vencimiento): 
                                    $dias_restantes = (strtotime($vencimiento['fecha_vencimiento']) - strtotime(date('Y-m-d'))) / (60 * 60 * 24);
                                ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($vencimiento['fecha_vencimiento'])); ?></td>
                                    <td><?php echo htmlspecialchars($vencimiento['propiedad']); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($vencimiento['inquilino']); ?>
                                        <br>
                                        <small class="text-muted">DNI: <?php echo htmlspecialchars($vencimiento['dni']); ?></small>
                                    </td>
                                    <td>$<?php echo number_format($vencimiento['monto'], 2); ?></td>
                                    <td>
                                        <span class="badge <?php echo $dias_restantes <= 5 ? 'bg-danger' : ($dias_restantes <= 10 ? 'bg-warning' : 'bg-success'); ?>">
                                            <?php echo round($dias_restantes); ?> días
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php if (empty($proximos_vencimientos)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay vencimientos próximos</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 