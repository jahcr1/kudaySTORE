<?php
include('conexion.php');
$id_producto = $_GET['id'];
$consultar_img = mysqli_query($conexion, "SELECT formato_imagen, ci_imagen_producto FROM productos WHERE id_producto = $id_producto");
$separarDatos = mysqli_fetch_row($consultar_img);
header("Content-type: $separarDatos[0]");
echo $separarDatos[1]; 
?>