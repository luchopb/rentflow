<?php
// Configurar el manejo de errores
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Función para manejar errores fatales
function fatal_handler() {
    $error = error_get_last();
    if ($error !== NULL && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        $message = "Error Fatal: {$error['message']} en {$error['file']} línea {$error['line']}";
        error_log($message);
        echo json_encode([
            'error' => true,
            'message' => $message
        ]);
    }
}
register_shutdown_function('fatal_handler');

// Manejador de excepciones no capturadas
set_exception_handler(function($e) {
    $message = "Excepción no capturada: " . $e->getMessage() . " en " . $e->getFile() . " línea " . $e->getLine();
    error_log($message);
    echo json_encode([
        'error' => true,
        'message' => $message
    ]);
});
?> 