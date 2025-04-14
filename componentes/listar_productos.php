<?php
session_start();

require_once('conexion.php');


if (isset($_SESSION['administrador'])) {

  if (isset($_POST['categoria'])) {

    $categoria = mysqli_real_escape_string($conexion, $_POST['categoria']);
    $resultado = null;

    //La consulta JOIN crea un alias categoria_nombre y le asigna el join de ambas tablas usando punteros, luego de la instruccion FROM hay q declarar el puntero productos p
    switch ($categoria) {
      case '1':
        $resultado = mysqli_query($conexion, "SELECT p.*, c.nombre AS categoria_nombre FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE p.categoria_id = '1'");
        break;
      case'2':
        $resultado = mysqli_query($conexion, "SELECT p.*, c.nombre AS categoria_nombre FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE p.categoria_id = '2'");
        break;
      case '3':
        $resultado = mysqli_query($conexion, "SELECT p.*, c.nombre AS categoria_nombre FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE p.categoria_id = '3'");
        break;
      case '4':
        $resultado = mysqli_query($conexion, "SELECT p.*, c.nombre AS categoria_nombre FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE p.categoria_id = '4'");
        break;
      case '5':
        $resultado = mysqli_query($conexion, "SELECT p.*, c.nombre AS categoria_nombre FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE p.categoria_id = '5'");
        break;
      case '6':
        $resultado = mysqli_query($conexion, "SELECT p.*, c.nombre AS categoria_nombre FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE p.categoria_id = '6'");
        break;
      case '7':
        $resultado = mysqli_query($conexion, "SELECT p.*, c.nombre AS categoria_nombre FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE p.categoria_id = '7'");
        break;
      case '8':
        $resultado = mysqli_query($conexion, "SELECT p.*, c.nombre AS categoria_nombre FROM productos p JOIN categorias c ON p.categoria_id = c.id WHERE p.categoria_id = '8'");
        break;
      default:
      echo 'Categoria no valida';
      exit;
    }
    
    if ($resultado) {
      $_SESSION['productos'] = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
      header("Location: ../panel.php?ok#listar-productos");
      exit();
    } else {
      echo 'No se encontraron productos.';
    }
  }
} else {
  $_SESSION['error'] = "Por favor, selecciona una categoría para listar los productos.";
    header("Location: ../panel.php");
    exit();
}
