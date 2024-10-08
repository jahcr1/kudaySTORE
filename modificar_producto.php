<?php
include('componentes/conexion.php');

if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];
  $nombre = $_POST['nombre'];
  $precio = $_POST['precio'];
  $descripcion = $_POST['descripcion'];

  // metemos conexión a la base de datos y ejecutamos la consulta de actualización.
  $sql = "UPDATE productos SET nombre_producto = ?, precio_producto = ?, descripcion_producto = ? WHERE id_producto = ?";
  
  // metemos la consulta preparada
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param('sdsi', $nombre, $precio, $descripcion, $id);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
      echo "<p>Producto modificado con éxito</p>";
  } else {
      header('Location: panel.php?error#listar-productos');
      echo "Error al modificar el producto";
  }

  header('Location: panel.php?ok#listar-productos');

  $stmt->close();
  $conexion->close();


}
?>