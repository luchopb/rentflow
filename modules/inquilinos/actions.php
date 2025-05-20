<?php
require_once '../../config/database.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
    case 'update':
        $id = $_POST['id'] ?? null;
        $nombre = $_POST['nombre'] ?? '';
        $documento = $_POST['documento'] ?? '';
        $email = $_POST['email'] ?? '';
        $telefono = $_POST['telefono'] ?? '';
        $vehiculo = $_POST['vehiculo'] ?? '';
        $matricula = $_POST['matricula'] ?? '';

        try {
            // Verificar si el Documento ya existe
            $stmt = $conn->prepare("SELECT id FROM inquilinos WHERE documento = ? AND id != ?");
            $stmt->execute([$documento, $id ?? 0]);
            if ($stmt->rowCount() > 0) {
                $response = ['success' => false, 'message' => 'Ya existe un inquilino con ese Documento'];
                break;
            }

            if ($action === 'create') {
                $stmt = $conn->prepare("INSERT INTO inquilinos (nombre, documento, email, telefono, vehiculo, matricula) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$nombre, $documento, $email, $telefono, $vehiculo, $matricula]);
                $response = ['success' => true, 'message' => 'Inquilino creado exitosamente'];
            } else {
                $stmt = $conn->prepare("UPDATE inquilinos SET nombre = ?, documento = ?, email = ?, telefono = ?, vehiculo = ?, matricula = ? WHERE id = ?");
                $stmt->execute([$nombre, $documento, $email, $telefono, $vehiculo, $matricula, $id]);
                $response = ['success' => true, 'message' => 'Inquilino actualizado exitosamente'];
            }
        } catch (PDOException $e) {
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
        break;

    case 'delete':
        $id = $_POST['id'] ?? 0;
        try {
            // Verificar si el inquilino tiene contratos
            $stmt = $conn->prepare("SELECT COUNT(*) FROM contratos WHERE inquilino_id = ?");
            $stmt->execute([$id]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $response = ['success' => false, 'message' => 'No se puede eliminar el inquilino porque tiene contratos asociados'];
            } else {
                $stmt = $conn->prepare("DELETE FROM inquilinos WHERE id = ?");
                $stmt->execute([$id]);
                $response = ['success' => true, 'message' => 'Inquilino eliminado exitosamente'];
            }
        } catch (PDOException $e) {
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
        break;

    case 'get':
        $id = $_POST['id'] ?? 0;
        try {
            $stmt = $conn->prepare("SELECT * FROM inquilinos WHERE id = ?");
            $stmt->execute([$id]);
            $inquilino = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($inquilino) {
                $response = ['success' => true, 'data' => $inquilino];
            } else {
                $response = ['success' => false, 'message' => 'Inquilino no encontrado'];
            }
        } catch (PDOException $e) {
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
        break;

    case 'get_contratos':
        $id = $_POST['id'] ?? 0;
        try {
            $stmt = $conn->prepare("
                SELECT c.*, p.direccion as propiedad_direccion 
                FROM contratos c 
                JOIN propiedades p ON c.propiedad_id = p.id 
                WHERE c.inquilino_id = ? 
                ORDER BY c.fecha_inicio DESC
            ");
            $stmt->execute([$id]);
            $contratos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $response = ['success' => true, 'data' => $contratos];
        } catch (PDOException $e) {
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
        break;

    case 'get_pagos':
        $id = $_POST['id'] ?? 0;
        try {
            $stmt = $conn->prepare("
                SELECT p.*, c.renta_mensual, pr.direccion as propiedad_direccion 
                FROM pagos p 
                JOIN contratos c ON p.contrato_id = c.id 
                JOIN propiedades pr ON c.propiedad_id = pr.id 
                WHERE c.inquilino_id = ? 
                ORDER BY p.fecha_vencimiento DESC
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