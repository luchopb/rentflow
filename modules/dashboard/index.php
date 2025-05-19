<?php
require_once '../../config/database.php';

// Obtener cantidad de propiedades disponibles y total
$stmt = $conn->prepare("
    SELECT 
        SUM(CASE WHEN estado = 'Disponible' THEN 1 ELSE 0 END) as disponibles,
        COUNT(*) as total
    FROM propiedades
");
$stmt->execute();
$propiedades = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener cantidad de contratos activos
$stmt = $conn->prepare("
    SELECT COUNT(*) as total
    FROM contratos 
    WHERE estado = 'Activo'
");
$stmt->execute();
$contratos_activos = $stmt->fetchColumn();

// Obtener cantidad de deudores
$stmt = $conn->prepare("
    SELECT COUNT(DISTINCT i.id) as total
    FROM inquilinos i
    JOIN contratos c ON i.id = c.inquilino_id
    JOIN pagos p ON c.id = p.contrato_id
    WHERE p.estado = 'Vencido'
    AND c.estado = 'Activo'
");
$stmt->execute();
$deudores = $stmt->fetchColumn();

// Obtener próximos vencimientos (20 días)
$stmt = $conn->prepare("
    SELECT COUNT(*) as total
    FROM pagos p
    JOIN contratos c ON p.contrato_id = c.id
    WHERE p.estado = 'Pendiente'
    AND c.estado = 'Activo'
    AND p.fecha_vencimiento BETWEEN CURRENT_DATE AND DATE_ADD(CURRENT_DATE, INTERVAL 20 DAY)
");
$stmt->execute();
$proximos_vencimientos = $stmt->fetchColumn();
?>

<div class="container-fluid py-4">
    <!-- Indicadores -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-info text-white h-100 cursor-pointer" onclick="cargarModulo('propiedades')">
                <div class="card-body">
                    <h5 class="card-title">Propiedades Disponibles</h5>
                    <div class="display-1">
                        <?php echo $propiedades['disponibles']; ?>
                        <span class="fs-6">de <?php echo $propiedades['total']; ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white h-100 cursor-pointer" onclick="cargarModulo('contratos')">
                <div class="card-body">
                    <h5 class="card-title">Contratos Activos</h5>
                    <div class="display-1"><?php echo $contratos_activos; ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white h-100 cursor-pointer" onclick="cargarModulo('inquilinos')">
                <div class="card-body">
                    <h5 class="card-title">Deudores</h5>
                    <div class="display-1"><?php echo $deudores; ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white h-100 cursor-pointer" onclick="cargarModulo('contratos')">
                <div class="card-body">
                    <h5 class="card-title">Próximos Vencimientos</h5>
                    <div class="display-1"><?php echo $proximos_vencimientos; ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Próximos Vencimientos de Pagos -->
        <div class="col-12 col-xl-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Próximos Vencimientos de Pagos (20 días)</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Propiedad</th>
                                    <th>Inquilino</th>
                                    <th>Monto</th>
                                    <th>Días</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $conn->prepare("
                                    SELECT 
                                        p.fecha_vencimiento,
                                        pr.direccion as propiedad,
                                        i.nombre as inquilino,
                                        p.monto,
                                        DATEDIFF(p.fecha_vencimiento, CURRENT_DATE) as dias
                                    FROM pagos p
                                    JOIN contratos c ON p.contrato_id = c.id
                                    JOIN propiedades pr ON c.propiedad_id = pr.id
                                    JOIN inquilinos i ON c.inquilino_id = i.id
                                    WHERE p.estado = 'Pendiente'
                                    AND c.estado = 'Activo'
                                    AND p.fecha_vencimiento BETWEEN CURRENT_DATE AND DATE_ADD(CURRENT_DATE, INTERVAL 20 DAY)
                                    ORDER BY p.fecha_vencimiento ASC
                                ");
                                $stmt->execute();
                                $proximos_pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                if (count($proximos_pagos) > 0):
                                    foreach ($proximos_pagos as $pago):
                                ?>
                                    <tr>
                                        <td><?php echo $pago['fecha_vencimiento']; ?></td>
                                        <td><?php echo htmlspecialchars($pago['propiedad']); ?></td>
                                        <td><?php echo htmlspecialchars($pago['inquilino']); ?></td>
                                        <td>$<?php echo number_format($pago['monto'], 2); ?></td>
                                        <td><?php echo $pago['dias']; ?></td>
                                    </tr>
                                <?php
                                    endforeach;
                                else:
                                ?>
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

        <!-- Contratos por Vencer -->
        <div class="col-12 col-xl-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Contratos por Vencer (60 días)</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha Fin</th>
                                    <th>Propiedad</th>
                                    <th>Inquilino</th>
                                    <th>Renta</th>
                                    <th>Días</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $conn->prepare("
                                    SELECT 
                                        c.fecha_fin,
                                        p.direccion as propiedad,
                                        i.nombre as inquilino,
                                        c.renta_mensual,
                                        DATEDIFF(c.fecha_fin, CURRENT_DATE) as dias
                                    FROM contratos c
                                    JOIN propiedades p ON c.propiedad_id = p.id
                                    JOIN inquilinos i ON c.inquilino_id = i.id
                                    WHERE c.estado = 'Activo'
                                    AND c.fecha_fin BETWEEN CURRENT_DATE AND DATE_ADD(CURRENT_DATE, INTERVAL 60 DAY)
                                    ORDER BY c.fecha_fin ASC
                                ");
                                $stmt->execute();
                                $contratos_vencer = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                if (count($contratos_vencer) > 0):
                                    foreach ($contratos_vencer as $contrato):
                                ?>
                                    <tr>
                                        <td><?php echo $contrato['fecha_fin']; ?></td>
                                        <td><?php echo htmlspecialchars($contrato['propiedad']); ?></td>
                                        <td><?php echo htmlspecialchars($contrato['inquilino']); ?></td>
                                        <td>$<?php echo number_format($contrato['renta_mensual'], 2); ?></td>
                                        <td><?php echo $contrato['dias']; ?></td>
                                    </tr>
                                <?php
                                    endforeach;
                                else:
                                ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No hay contratos por vencer</td>
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

<style>
.cursor-pointer {
    cursor: pointer;
}
.cursor-pointer:hover {
    background-color: rgba(255,255,255,0.1);
    transition: background-color 0.3s ease;
}
</style> 