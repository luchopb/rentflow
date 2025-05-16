<?php
require_once '../../config/database.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
    case 'update':
        $id = $_POST['id'] ?? null;
        $propiedad_id = $_POST['propiedad_id'] ?? 0;
        $inquilino_id = $_POST['inquilino_id'] ?? 0;
        $fecha_inicio = $_POST['fecha_inicio'] ?? '';
        $fecha_fin = $_POST['fecha_fin'] ?? '';
        $renta_mensual = $_POST['renta_mensual'] ?? 0;
        $estado = $_POST['estado'] ?? 'Activo';

        try {
            // Validaciones básicas
            if (!$propiedad_id || !$inquilino_id || !$fecha_inicio || !$fecha_fin || !$renta_mensual) {
                $response = ['success' => false, 'message' => 'Todos los campos son obligatorios'];
                break;
            }

            // Validar fechas
            if (strtotime($fecha_inicio) >= strtotime($fecha_fin)) {
                $response = ['success' => false, 'message' => 'La fecha de fin debe ser posterior a la fecha de inicio'];
                break;
            }

            // Verificar si la propiedad está disponible
            if ($action === 'create') {
                $stmt = $conn->prepare("
                    SELECT COUNT(*) FROM contratos 
                    WHERE propiedad_id = ? 
                    AND estado = 'Activo'
                    AND (
                        (fecha_inicio <= ? AND fecha_fin >= ?) OR
                        (fecha_inicio <= ? AND fecha_fin >= ?) OR
                        (fecha_inicio >= ? AND fecha_fin <= ?)
                    )
                ");
                $stmt->execute([
                    $propiedad_id,
                    $fecha_inicio, $fecha_inicio,
                    $fecha_fin, $fecha_fin,
                    $fecha_inicio, $fecha_fin
                ]);
                
                if ($stmt->fetchColumn() > 0) {
                    $response = ['success' => false, 'message' => 'La propiedad no está disponible para las fechas seleccionadas'];
                    break;
                }
            }

            $conn->beginTransaction();

            if ($action === 'create') {
                // Insertar el contrato
                $stmt = $conn->prepare("
                    INSERT INTO contratos (propiedad_id, inquilino_id, fecha_inicio, fecha_fin, renta_mensual, estado) 
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([$propiedad_id, $inquilino_id, $fecha_inicio, $fecha_fin, $renta_mensual, $estado]);
                $contrato_id = $conn->lastInsertId();

                if (!$contrato_id) {
                    throw new Exception('Error al crear el contrato');
                }
                
                // Actualizar estado de la propiedad
                $stmt = $conn->prepare("UPDATE propiedades SET estado = 'Alquilado' WHERE id = ?");
                $stmt->execute([$propiedad_id]);
                
                // Crear pagos mensuales
                $fecha_actual = new DateTime($fecha_inicio);
                $fecha_fin_obj = new DateTime($fecha_fin);
                
                // Asegurarse de que la fecha de fin sea el último día del mes
                $fecha_fin_obj->modify('last day of this month');
                
                // Generar pagos mensuales
                while ($fecha_actual <= $fecha_fin_obj) {
                    try {
                        $stmt = $conn->prepare("
                            INSERT INTO pagos (contrato_id, fecha_vencimiento, monto, estado) 
                            VALUES (?, ?, ?, 'Pendiente')
                        ");
                        $stmt->execute([
                            $contrato_id,
                            $fecha_actual->format('Y-m-d'),
                            $renta_mensual
                        ]);
                        
                        // Avanzar al primer día del siguiente mes
                        $fecha_actual->modify('first day of next month');
                    } catch (PDOException $e) {
                        throw new Exception('Error al crear los pagos mensuales: ' . $e->getMessage());
                    }
                }
                
                $response = ['success' => true, 'message' => 'Contrato creado exitosamente'];
            } else {
                $stmt = $conn->prepare("
                    UPDATE contratos 
                    SET propiedad_id = ?, inquilino_id = ?, fecha_inicio = ?, fecha_fin = ?, 
                        renta_mensual = ?, estado = ? 
                    WHERE id = ?
                ");
                $stmt->execute([$propiedad_id, $inquilino_id, $fecha_inicio, $fecha_fin, $renta_mensual, $estado, $id]);
                
                // Actualizar estado de la propiedad si el contrato se finaliza o cancela
                if ($estado !== 'Activo') {
                    $stmt = $conn->prepare("UPDATE propiedades SET estado = 'Disponible' WHERE id = ?");
                    $stmt->execute([$propiedad_id]);
                }
                
                $response = ['success' => true, 'message' => 'Contrato actualizado exitosamente'];
            }

            $conn->commit();
        } catch (Exception $e) {
            $conn->rollBack();
            $response = ['success' => false, 'message' => $e->getMessage()];
        }
        break;

    case 'delete':
        $id = $_POST['id'] ?? 0;
        try {
            $conn->beginTransaction();

            // Obtener la propiedad_id antes de eliminar
            $stmt = $conn->prepare("SELECT propiedad_id FROM contratos WHERE id = ?");
            $stmt->execute([$id]);
            $propiedad_id = $stmt->fetchColumn();

            // Eliminar pagos asociados primero
            $stmt = $conn->prepare("DELETE FROM pagos WHERE contrato_id = ?");
            $stmt->execute([$id]);

            // Eliminar contrato
            $stmt = $conn->prepare("DELETE FROM contratos WHERE id = ?");
            $stmt->execute([$id]);

            // Actualizar estado de la propiedad
            $stmt = $conn->prepare("UPDATE propiedades SET estado = 'Disponible' WHERE id = ?");
            $stmt->execute([$propiedad_id]);

            $conn->commit();
            $response = ['success' => true, 'message' => 'Contrato eliminado exitosamente'];
        } catch (PDOException $e) {
            $conn->rollBack();
            $response = ['success' => false, 'message' => 'Error al eliminar el contrato: ' . $e->getMessage()];
        }
        break;

    case 'get':
        $id = $_POST['id'] ?? 0;
        try {
            $stmt = $conn->prepare("SELECT * FROM contratos WHERE id = ?");
            $stmt->execute([$id]);
            $contrato = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($contrato) {
                $response = ['success' => true, 'data' => $contrato];
            } else {
                $response = ['success' => false, 'message' => 'Contrato no encontrado'];
            }
        } catch (PDOException $e) {
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
        break;

    case 'get_pagos':
        $id = $_POST['id'] ?? 0;
        try {
            $stmt = $conn->prepare("
                SELECT p.*, c.renta_mensual 
                FROM pagos p 
                JOIN contratos c ON p.contrato_id = c.id 
                WHERE p.contrato_id = ? 
                ORDER BY p.fecha_vencimiento ASC
            ");
            $stmt->execute([$id]);
            $pagos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response = ['success' => true, 'data' => $pagos];
        } catch (PDOException $e) {
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
        break;

    default:
        $response = ['success' => false, 'message' => 'Acción no válida'];
}

echo json_encode($response); 