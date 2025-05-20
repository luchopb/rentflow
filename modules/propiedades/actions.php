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
        $gastos_comunes = $_POST['gastos_comunes'] ?? 0;
        $contribucion_inmobiliaria_cc = $_POST['contribucion_inmobiliaria_cc'] ?? 0;
        $contribucion_inmobiliaria_padron = $_POST['contribucion_inmobiliaria_padron'] ?? 0;

        try {
            if ($action === 'create') {
                $stmt = $conn->prepare("
                    INSERT INTO propiedades (
                        direccion, tipo, precio, estado, caracteristicas, 
                        galeria, local, gastos_comunes, 
                        contribucion_inmobiliaria_cc, contribucion_inmobiliaria_padron
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $direccion, $tipo, $precio, $estado, $caracteristicas,
                    $galeria, $local, $gastos_comunes,
                    $contribucion_inmobiliaria_cc, $contribucion_inmobiliaria_padron
                ]);
                $propiedad_id = $conn->lastInsertId();
                $response = ['success' => true, 'message' => 'Propiedad creada exitosamente'];
            } else {
                $stmt = $conn->prepare("
                    UPDATE propiedades 
                    SET direccion = ?, tipo = ?, precio = ?, estado = ?, 
                        caracteristicas = ?, galeria = ?, local = ?,
                        gastos_comunes = ?, contribucion_inmobiliaria_cc = ?,
                        contribucion_inmobiliaria_padron = ?
                    WHERE id = ?
                ");
                $stmt->execute([
                    $direccion, $tipo, $precio, $estado, $caracteristicas,
                    $galeria, $local, $gastos_comunes,
                    $contribucion_inmobiliaria_cc, $contribucion_inmobiliaria_padron,
                    $id
                ]);
                $propiedad_id = $id;
                $response = ['success' => true, 'message' => 'Propiedad actualizada exitosamente'];
            }

            // --- BLOQUE DE MANEJO DE IMÁGENES ---
            if (!empty($_FILES['imagenes']['name'][0])) {
                $uploadDir = '../../uploads/propiedades/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                $maxSize = 5 * 1024 * 1024; // 5MB
                foreach ($_FILES['imagenes']['tmp_name'] as $idx => $tmpName) {
                    $fileName = basename($_FILES['imagenes']['name'][$idx]);
                    $fileType = $_FILES['imagenes']['type'][$idx];
                    $fileSize = $_FILES['imagenes']['size'][$idx];
                    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                    $newFileName = uniqid('img_') . '.' . $fileExt;
                    $targetPath = $uploadDir . $newFileName;

                    if (!in_array($fileType, $allowedTypes)) continue;
                    if ($fileSize > $maxSize) continue;
                    if (move_uploaded_file($tmpName, $targetPath)) {
                        $stmt = $conn->prepare("INSERT INTO propiedad_imagenes (propiedad_id, filename) VALUES (?, ?)");
                        $stmt->execute([$propiedad_id, $newFileName]);
                    }
                }
            }
            // --- FIN BLOQUE DE IMÁGENES ---
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
                // Obtener imágenes asociadas
                $stmt = $conn->prepare("SELECT filename FROM propiedad_imagenes WHERE propiedad_id = ?");
                $stmt->execute([$id]);
                $imagenes = $stmt->fetchAll(PDO::FETCH_COLUMN);
                $propiedad['imagenes'] = $imagenes;
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