<?php
// Traemos las variables de entorno desde config.php una sola vez
// asi dsp en cualquier pagina que necesite usar varenv tiene que hacer solo un include conexion.php
require_once __DIR__ . '/../config.php'; 

// Probar conexión con mysqli usando variables de entorno
$conexion = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_NAME']);

if($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}
?>
