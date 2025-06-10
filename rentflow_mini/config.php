<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Archivo config.php: conexión a base de datos y funciones comunes
session_start();

define('DB_HOST', 'localhost');
define('DB_NAME', 'drakon_luchorentflow_mini');
define('DB_USER', 'root');
define('DB_PASS', '');

// Crear conexión PDO
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Error conexión DB: " . $e->getMessage());
}

// Función para verificar login
function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
}

// Función para verificar rol admin
function is_admin() {
    return (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');
}

// Función para sanitizar entradas
function clean_input($data) {
    return htmlspecialchars(trim($data));
}
?>

