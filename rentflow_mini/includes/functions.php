<?php
// functions.php: Funciones comunes para el sistema de inmobiliaria

/**
 * Función para mostrar el estado de una propiedad con colores
 */
function estado_label($e) {
  switch ($e) {
    case 'libre':
      return '<span class="badge bg-danger">Libre</span>';
    case 'alquilado':
      return '<span class="badge bg-success">Alquilado</span>';
    case 'uso propio':
      return '<span class="badge bg-secondary">Uso Propio</span>';
    case 'en venta':
      return '<span class="badge bg-warning text-dark">En Venta</span>';
    default:
      return '<span class="badge bg-light text-dark">' . ucfirst($e) . '</span>';
  }
}

/**
 * Función para mostrar el estado de un contrato con colores
 */
function estado_contrato_label($estado) {
  switch ($estado) {
    case 'activo':
      return '<span class="badge bg-success">Activo</span>';
    case 'finalizado':
      return '<span class="badge bg-secondary">Finalizado</span>';
    case 'suspendido':
      return '<span class="badge bg-warning text-dark">Suspendido</span>';
    case 'cancelado':
      return '<span class="badge bg-danger">Cancelado</span>';
    default:
      return '<span class="badge bg-light text-dark">' . ucfirst($estado) . '</span>';
  }
}

/**
 * Función para limpiar input de usuario
 */
function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

/**
 * Función para formatear moneda
 */
function format_currency($amount) {
  return '$' . number_format($amount, 0, ',', '.');
}

/**
 * Función para formatear fecha
 */
function format_date($date, $format = 'd/m/Y') {
  return date($format, strtotime($date));
}


// Función para verificar login
function check_login()
{
  if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
  }
}

// Función para verificar rol admin
function is_admin()
{
  return (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin');
}

?>
