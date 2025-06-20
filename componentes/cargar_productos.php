<?php
require_once 'conexion.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

      $categoria_producto = $_POST['producto'];
      $nombre_producto = $_POST['nombre'];
      $id_producto = $_POST['id_producto'];
      $precio_producto = $_POST['precio'];
      $descripcion_producto = $_POST['descripcion'];
      $stock_producto = $_POST['stock'];

      // Manejo de Imagen
      if(isset($_FILES['foto_producto']) && $_FILES['foto_producto']['error'] === UPLOAD_ERR_OK) {
        
        // Verificamos el tamaño de la imagen
        if ($_FILES['foto_producto']['size'] > 8192 * 1024) { // 8 MB
          header("Location: ../panel.php?mensaje=error-peso#formulario-carga1");
          exit();

        }
        
        $imagenData = file_get_contents($_FILES['foto_producto']['tmp_name']);
        $imagenTipo = mime_content_type($_FILES['foto_producto']['tmp_name']); //guardar el tipo de la imagen
      } else {
          $imagenData = null;
          $imagenTipo = null;
        }

      // Comprobando si el ID ya existe
      $stmt_check = $conexion->prepare("SELECT COUNT(*) FROM productos WHERE id = ?");
      $stmt_check->bind_param("i", $id_producto);
      $stmt_check->execute();
      $stmt_check->bind_result($count);
      $stmt_check->fetch();
      $stmt_check->close();

      if ($count > 0) {
          // Si ya existe el ID, redirige con un mensaje de error
          header("Location: ../panel.php?mensaje=error-duplicado#formulario-carga1");
          exit();
      }

      $stmt = $conexion->prepare("INSERT INTO productos (id, nombre, precio, descripcion, categoria_id, stock, ci_imagen_producto, formato_imagen) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isdsiiss", $id_producto, $nombre_producto, $precio_producto, $descripcion_producto, $categoria_producto, $stock_producto, $imagenData, $imagenTipo);
      
      if($stmt->execute()) {
        $stmt->close();
        
        // Redirigir a panel.php con un parámetro de éxito en la URL
        header("Location: ../panel.php?mensaje=exito#formulario-carga1");
        exit();
      
      } else {
        // Redirigir con un parámetro de error si algo falla
        header("Location: ../panel.php?mensaje=error#formulario-carga1");
        exit();
      }
}  
?>