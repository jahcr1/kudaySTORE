<?php
$categoria_producto = $_POST['producto'];
$nombre_producto = $_POST['nombre'];
$id_producto = $_POST['id_producto'];
$precio_producto = $_POST['precio'];
$descripcion_producto = $_POST['descripcion'];

/**
 * La superglobal $_FILES es un array de 2 dimensiones, asique
 * guardamos en variables todas las partes del archivo por
 * separado, el nombre original del archivo, el formato del archivo,
 * el tamanio en bytes del archivo y su ubicacion temporal donde fue
 * creado ese archivo.
 */
$nombre_archivo = $_FILES['foto_producto']['name'];
$tipo_archivo = $_FILES['foto_producto']['type'];
$peso_archivo = $_FILES['foto_producto']['size'];
$tmp_archivo = $_FILES['foto_producto']['tmp_name'];

// directorio raiz creado
$carpeta = '../images/productos/';

//funcion para sacar la extension de un archivo usando su nombre
$extension = pathinfo($_FILES['foto_producto']['name'], PATHINFO_EXTENSION);

//scripts para usar la primera palabra de un dato pasado x post
$cadena = trim($nombre_producto);
$palabras = explode(' ', $cadena);
$primera_palabra = $palabras[0];
$nombre_archivo_nuevo = $primera_palabra;

//validacion de formato de archivo y peso de archivo
if ($tipo_archivo != 'image/png' && $tipo_archivo != 'image/gif' && $tipo_archivo != 'image/jpeg') {
  header("Location: panel.php?error_formato");
} else if ($peso_archivo > 250000) {
  header("Location: panel.php?error_peso");
} else {

  /**   cambiar explicacion del metodo actualizado!!
   * 
   * la funcion move_uploeaded_file de php sirve para
   * enviar un archivo de imagen q subo desde el form a un
   * directorio raiz, pero yo quiero subirla a la bd, asique aplico
   * otro metodo.
  
   * move_uploaded_file($tmp_archivo, $carpeta . $nombre_archivo_nuevo . $id_producto . '.' . $extension);
    
   */
  

  include("conexion.php");

  $imagen = fopen($tmp_archivo, "r+");
  $contenido_imagen = fread($imagen, $peso_archivo);
  $img_tabla = addslashes($contenido_imagen);




  mysqli_query($conexion, "INSERT INTO productos VALUES ($id_producto, '$nombre_producto', '$categoria_producto', $precio_producto, '$descripcion_producto', '$img_tabla', '$tipo_archivo')");

  header("Location: ../panel.php?ok");
}
