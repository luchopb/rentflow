<?php
require_once '../../config/database.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
    case 'update':
        $id = $_POST['id'] ?? null;
        $contrato_id = $_POST['contrato_id'] ?? 0;
        $monto = $_POST['monto'] ?? 0;
        $fecha_pago = $_POST['fecha_pago'] ?? null;
        $monto_pagado = $_POST['monto_pagado'] ?? null;

        try {
            // Validaciones básicas
            if (!$contrato_id || !$monto || !$fecha_pago || !$monto_pagado) {
                $response = ['success' => false, 'message' => 'Todos los campos son obligatorios'];
                break;
            }

            if (strtotime($fecha_pago) > time()) {
                $response = ['success' => false, 'message' => 'La fecha de pago no puede ser futura'];
                break;
            }

            if ($action === 'create') {
                $stmt = $conn->prepare("
                    INSERT INTO pagos (contrato_id, fecha_vencimiento, monto, fecha_pago, monto_pagado, estado) 
                    VALUES (?, ?, ?, ?, ?, 'Pagado')
                ");
                $stmt->execute([$contrato_id, $fecha_pago, $monto, $fecha_pago, $monto_pagado]);
                $response = ['success' => true, 'message' => 'Pago registrado exitosamente'];
            } else {
                $stmt = $conn->prepare("
                    UPDATE pagos 
                    SET contrato_id = ?, fecha_vencimiento = ?, monto = ?, fecha_pago = ?, monto_pagado = ?, estado = 'Pagado'
                    WHERE id = ?
                ");
                $stmt->execute([$contrato_id, $fecha_pago, $monto, $fecha_pago, $monto_pagado, $id]);
                $response = ['success' => true, 'message' => 'Pago actualizado exitosamente'];
            }
        } catch (PDOException $e) {
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
        break;

    case 'delete':
        $id = $_POST['id'] ?? 0;
        try {
            $stmt = $conn->prepare("DELETE FROM pagos WHERE id = ?");
            $stmt->execute([$id]);
            $response = ['success' => true, 'message' => 'Pago eliminado exitosamente'];
        } catch (PDOException $e) {
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
        break;

    case 'get':
        $id = $_POST['id'] ?? 0;
        try {
            $stmt = $conn->prepare("SELECT * FROM pagos WHERE id = ?");
            $stmt->execute([$id]);
            $pago = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($pago) {
                $response = ['success' => true, 'data' => $pago];
            } else {
                $response = ['success' => false, 'message' => 'Pago no encontrado'];
            }
        } catch (PDOException $e) {
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
        break;

    default:
        $response = ['success' => false, 'message' => 'Acción no válida'];
}

echo json_encode($response); 