<?php
require_once '../../config/database.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'create':
    case 'update':
        $id = $_POST['id'] ?? null;
        $direccion = $_POST['direccion'] ?? '';
        $tipo = $_POST['tipo'] ?? '';
        $precio = $_POST['precio'] ?? 0;
        $estado = $_POST['estado'] ?? 'Disponible';
        $caracteristicas = $_POST['caracteristicas'] ?? '';
        $galeria = $_POST['galeria'] ?? '';
        $local = $_POST['local'] ?? '';

        try {
            if ($action === 'create') {
                $stmt = $conn->prepare("INSERT INTO propiedades (direccion, tipo, precio, estado, caracteristicas, galeria, local) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$direccion, $tipo, $precio, $estado, $caracteristicas, $galeria, $local]);
                $response = ['success' => true, 'message' => 'Propiedad creada exitosamente'];
            } else {
                $stmt = $conn->prepare("UPDATE propiedades 
                                      SET direccion = ?, tipo = ?, precio = ?, estado = ?, caracteristicas = ?, 
                                          galeria = ?, local = ? 
                                      WHERE id = ?");
                $stmt->execute([$direccion, $tipo, $precio, $estado, $caracteristicas, $galeria, $local, $id]);
                $response = ['success' => true, 'message' => 'Propiedad actualizada exitosamente'];
            }
        } catch (PDOException $e) {
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
        break;

    case 'delete':
        $id = $_POST['id'] ?? 0;
        try {
            // Verificar si la propiedad está en uso en algún contrato
            $stmt = $conn->prepare("SELECT COUNT(*) FROM contratos WHERE propiedad_id = ?");
            $stmt->execute([$id]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $response = ['success' => false, 'message' => 'No se puede eliminar la propiedad porque está asociada a uno o más contratos'];
            } else {
                $stmt = $conn->prepare("DELETE FROM propiedades WHERE id = ?");
                $stmt->execute([$id]);
                $response = ['success' => true, 'message' => 'Propiedad eliminada exitosamente'];
            }
        } catch (PDOException $e) {
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
        break;

    case 'get':
        $id = $_POST['id'] ?? 0;
        try {
            $stmt = $conn->prepare("SELECT * FROM propiedades WHERE id = ?");
            $stmt->execute([$id]);
            $propiedad = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($propiedad) {
                $response = ['success' => true, 'data' => $propiedad];
            } else {
                $response = ['success' => false, 'message' => 'Propiedad no encontrada'];
            }
        } catch (PDOException $e) {
            $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
        }
        break;

    default:
        $response = ['success' => false, 'message' => 'Acción no válida'];
}

echo json_encode($response); 