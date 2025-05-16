<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'drakon_pruebalucho');
define('DB_PASS', 'JHF6y5dwP31V');
define('DB_NAME', 'drakon_pruebalucho');

try {
    $conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    die();
}
?> 