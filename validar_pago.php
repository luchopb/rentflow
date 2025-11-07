<?php
require_once 'config.php';
check_login();

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit();
}

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}

// Obtener datos de la petición
$pago_id = intval($_POST['pago_id'] ?? 0);
$validado = $_POST['validado'] === 'true';

if (!$pago_id) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID de pago requerido']);
    exit();
}

try {
    // Verificar que el pago existe
    $stmt = $pdo->prepare("SELECT id FROM pagos WHERE id = ?");
    $stmt->execute([$pago_id]);
    
    if (!$stmt->fetch()) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Pago no encontrado']);
        exit();
    }
    
    // Actualizar el estado de validación
    if ($validado) {
        // Marcar como validado
        $stmt = $pdo->prepare("
            UPDATE pagos 
            SET validado = TRUE, 
                fecha_validacion = NOW(), 
                usuario_validacion_id = ? 
            WHERE id = ?
        ");
        $stmt->execute([$_SESSION['user_id'], $pago_id]);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Pago validado correctamente',
            'validado' => true,
            'fecha_validacion' => date('Y-m-d H:i:s'),
            'usuario_validacion' => $_SESSION['username'] ?? 'Usuario'
        ]);
    } else {
        // Marcar como no validado
        $stmt = $pdo->prepare("
            UPDATE pagos 
            SET validado = FALSE, 
                fecha_validacion = NULL, 
                usuario_validacion_id = NULL 
            WHERE id = ?
        ");
        $stmt->execute([$pago_id]);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Validación del pago removida',
            'validado' => false
        ]);
    }
    
} catch (PDOException $e) {
    error_log("Error al validar pago: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor']);
}
?> 