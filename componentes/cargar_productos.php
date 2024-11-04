<?php
require_once 'conexion.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

      $categoria_producto = $_POST['producto'];
      $nombre_producto = $_POST['nombre'];
      $id_producto = $_POST['id_producto'];
      $precio_producto = $_POST['precio'];
      $descripcion_producto = $_POST['descripcion'];

      // Manejo de Imagen
      if(isset($_FILES['foto_producto']) && $_FILES['foto_producto']['error'] === UPLOAD_ERR_OK) {
        
        // Verificamos el tamaño de la imagen
        if ($_FILES['foto_producto']['size'] > 1024 * 1024) { // 1 MB
          header("Location: ../panel.php?mensaje=error-peso#formulario-carga");
          exit();

        }

        $imagenData = file_get_contents($_FILES['foto_producto']['tmp_name']);
        $imagenTipo = mime_content_type($_FILES['foto_producto']['tmp_name']); //guardar el tipo de la imagen
      } else {
          $imagenData = null;
          $imagenTipo = null;
        }

      $stmt = $conexion->prepare("INSERT INTO productos (id_producto, nombre_producto, precio_producto, descripcion_producto, categoria_producto, ci_imagen_producto, formato_imagen) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isdssss", $id_producto, $nombre_producto, $precio_producto, $descripcion_producto, $categoria_producto, $imagenData, $imagenTipo);
      
      if($stmt->execute()) {
        $stmt->close();
        
        // Redirigir a panel.php con un parámetro de éxito en la URL
        header("Location: ../panel.php?mensaje=exito#formulario-carga");
        exit();
      
      } else {
        // Redirigir con un parámetro de error si algo falla
        header("Location: ../panel.php?mensaje=error#formulario-carga");
        exit();
       }
}  
?>