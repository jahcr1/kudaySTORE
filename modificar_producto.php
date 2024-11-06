<?php
session_start();
include('componentes/conexion.php');

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $descripcion = $_POST['descripcion'];
    

    // Manejo de Imagen
    if (isset($_FILES['foto_producto']) && $_FILES['foto_producto']['error'] === UPLOAD_ERR_OK) {

        // Verificamos el tamaño de la imagen
        if ($_FILES['foto_producto']['size'] > 1024 * 1024) { // 1 MB
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
        $consulta = "SELECT * FROM productos";
        $resultado = $conexion->query($consulta);

        if ($resultado->num_rows > 0) {
            // Actualizamos la sesión con los datos actualizados
            $_SESSION['productos'] = $resultado->fetch_all(MYSQLI_ASSOC);
        }

        // Redirigimos de vuelta con una notificación de éxito
        header('Location: panel.php?okm#tabla-resultado');
        exit;
    }

    // Cerrar la sentencia y la conexión
    $stmt->close();
    $conexion->close();
}
