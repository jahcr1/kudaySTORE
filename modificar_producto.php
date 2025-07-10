<?php
session_start();
include('componentes/conexion.php');

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // NUEVO BLOQUE: Validar ID de producto de forma segura
    $id = isset($_POST['id']) && is_numeric($_POST['id']) ? intval($_POST['id']) : 0;
    if ($id <= 0) {
        die("ID de producto inválido.");
    }
    
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $descripcion = $_POST['descripcion'];
    
    

    // Manejo de Imagen Principal
    if (isset($_FILES['foto_producto']) && $_FILES['foto_producto']['error'] === UPLOAD_ERR_OK) {

        // Verificamos el tamaño de la imagen. Max 8 MB
        if ($_FILES['foto_producto']['size'] > 8192 * 1024) { 
          header("Location: panel.php?mensaje=error-peso#cargando");
          exit();

        }

        $imagenData = file_get_contents($_FILES['foto_producto']['tmp_name']);
        $imagenTipo = mime_content_type($_FILES['foto_producto']['tmp_name']); //guardar el tipo de la imagen
    } else {
        $imagenData = null;
        $imagenTipo = null;
    }

    // Crear el SQL para actualizar el producto
    if ($imagenData !== null && $imagenTipo !== null) {
        // Si hay una imagen nueva, actualiza todos los campos incluyendo la imagen
        $sql = "UPDATE productos SET nombre = ?, precio = ?, descripcion = ?, stock = ?, ci_imagen_producto = ?, formato_imagen = ? WHERE id = ?";

        // Preparar y ejecutar la sentencia
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('sdsissi', $nombre, $precio, $descripcion, $stock, $imagenData, $imagenTipo, $id);
    } else {
        // Si no hay imagen nueva, solo actualiza los campos que se requieren
        $sql = "UPDATE productos SET nombre = ?, precio = ?, descripcion = ?, stock = ? WHERE id = ?";

        // Preparar y ejecutar la sentencia
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('sdsii', $nombre, $precio, $descripcion, $stock, $id);
    }

    if ($stmt->execute()) {
        // Consulta para recargar todos los productos y actualizar la sesión
        $consulta = "SELECT productos.*, categorias.nombre AS categoria_nombre FROM productos JOIN categorias ON productos.categoria_id = categorias.id";
        
        $resultado = $conexion->query($consulta);

        if ($resultado->num_rows > 0) {
            // Actualizamos la sesión con los datos actualizados
            $_SESSION['productos'] = $resultado->fetch_all(MYSQLI_ASSOC);
        }

        // NUEVO BLOQUE: Manejo robusto de thumbnails
        if (isset($_FILES['thumbnails']) && is_array($_FILES['thumbnails']['name']) && count($_FILES['thumbnails']['name']) > 0) {

            // Borrar miniaturas existentes del producto
            $deleteThumbs = $conexion->prepare("DELETE FROM producto_imagenes WHERE producto_id = ?");
            $deleteThumbs->bind_param("i", $id);
            $deleteThumbs->execute();
            $deleteThumbs->close();

            // Insertar nuevas miniaturas
            $insertThumb = $conexion->prepare("INSERT INTO producto_imagenes (producto_id, imagen, formato) VALUES (?, ?, ?)");

            $allowed_mimes = ['image/jpeg', 'image/png', 'image/webp']; // Tipos permitidos

            for ($i = 0; $i < count($_FILES['thumbnails']['name']); $i++) {
                if ($_FILES['thumbnails']['error'][$i] === UPLOAD_ERR_OK) {
                    $thumbTmpName = $_FILES['thumbnails']['tmp_name'][$i];
                    $thumbSize = $_FILES['thumbnails']['size'][$i];

                    $thumbMime = mime_content_type($thumbTmpName);

                    // Validación de tipo y tamaño max 8 MB
                    if ($thumbSize > 8 * 1024 * 1024 || !in_array($thumbMime, $allowed_mimes)) {
                        error_log("Miniatura rechazada: " . $_FILES['thumbnails']['name'][$i]);
                        continue;
                    }

                    $thumbData = file_get_contents($thumbTmpName);
                    $insertThumb->bind_param("iss", $id, $thumbData, $thumbMime);
                    $insertThumb->execute();
                }
            }

            $insertThumb->close();
        }

        // Redirigimos de vuelta con una notificación de éxito
        header('Location: panel.php?okm#tabla-resultado');
        exit;
    }

    // Cerrar la sentencia y la conexión
    $stmt->close();
    $conexion->close();
}
