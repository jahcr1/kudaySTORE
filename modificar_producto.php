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
    
    // Inicializar variables para imagen
    $img_tabla = null;
    $tipo_archivo = null;

    // Comprobar que se subió un archivo y validar
    if (isset($_FILES['foto_producto']) && $_FILES['foto_producto']['error'] == 0) {
        $nombre_archivo = $_FILES['foto_producto']['name'];
        $tipo_archivo = $_FILES['foto_producto']['type'];
        $peso_archivo = $_FILES['foto_producto']['size'];
        $tmp_archivo = $_FILES['foto_producto']['tmp_name'];

        // Verificar la extensión
        $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);

        // Obtener la primera palabra del nombre del producto
        $cadena = trim($nombre);
        $palabras = explode(' ', $cadena);
        $primera_palabra = $palabras[0];
        $nombre_archivo_nuevo = $primera_palabra;

        // Validar el formato del archivo y su tamaño
        if (($tipo_archivo != 'image/png' && $tipo_archivo != 'image/gif' && $tipo_archivo != 'image/jpeg') || $peso_archivo > 250000) {
            header("Location: panel.php#modalmod?error_formato_o_peso");
            exit;
        }

        // Leer el contenido del archivo y preparar la imagen para la base de datos
        $imagen = fopen($tmp_archivo, "rb");
        $contenido_imagen = fread($imagen, $peso_archivo);
        fclose($imagen);
        $img_tabla = addslashes($contenido_imagen); // Escapar el contenido binario

    } 
    
    // Crear el SQL para actualizar el producto
    if ($img_tabla !== null && $tipo_archivo !== null) {
        // Si hay una imagen nueva, actualiza todos los campos incluyendo la imagen
        $sql = "UPDATE productos SET nombre_producto = ?, precio_producto = ?, descripcion_producto = ?, ci_imagen_producto = ?, formato_imagen = ? WHERE id_producto = ?";
        
        // Preparar y ejecutar la sentencia
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('sdsssi', $nombre, $precio, $descripcion, $img_tabla, $tipo_archivo, $id);
    } else {
        // Si no hay imagen nueva, solo actualiza los campos que se requieren
        $sql = "UPDATE productos SET nombre_producto = ?, precio_producto = ?, descripcion_producto = ? WHERE id_producto = ?";
        
        // Preparar y ejecutar la sentencia
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param('sdsi', $nombre, $precio, $descripcion, $id);
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
?>
