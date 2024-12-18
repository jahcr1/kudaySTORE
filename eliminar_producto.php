<?php
include('componentes/conexion.php');

if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $id = $_POST['id'];

  // Aquí debes realizar la conexión a la base de datos y ejecutar la consulta de eliminación.
  $sql = "DELETE FROM productos WHERE id = ?";
  
  // Supongamos que tienes una conexión $conn
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param('i', $id);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
      
      echo "Producto eliminado con éxito";
      header('Location: panel.php?eliminado_ok#panel');
  } else {
      echo "Error al eliminar el producto";
      header('Location: panel.php?eliminado_error#panel');
  }
  $stmt->close();
  $conexion->close();
  
  exit();
}
?>