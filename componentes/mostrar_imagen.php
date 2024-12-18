<?php  
session_start();

require_once 'conexion.php';

if (!$conexion) {
  die("Error en la conexión a la base de datos");
}

// Validar y sanitizar el parámetro 'id' recibido por GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
  die("ID no válido");
}

// Preparar la consulta para obtener la imagen binaria y el tipo MIME
$stmt = $conexion->prepare("SELECT ci_imagen_producto, formato_imagen FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

// Verificar si la consulta ha devuelto resultados
if ($stmt->num_rows > 0) {
  $stmt->bind_result($imagen, $tipo);
  $stmt->fetch();

  // Configurar la cabecera HTTP para indicar el tipo de contenido y la longitud
  header("Content-Type: " . htmlspecialchars($tipo));
  header("Content-Length: " . strlen($imagen));

  // Enviar la imagen binaria al navegador
  echo $imagen;
} else {
  die("Imagen no encontrada");
}

$stmt->close();
?>
