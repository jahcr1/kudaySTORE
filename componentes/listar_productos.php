<?php
session_start();

include_once('conexion.php');


if (isset($_SESSION['administrador'])) {

  if (!empty($_POST)) {

    $categoria = mysqli_real_escape_string($conexion, $_POST['categoria']);
    $resultado = null;

    switch ($categoria) {
      case 'Cartuchera':
        $resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE categoria_producto = 'Cartuchera'");
        break;
        case 'Neceser':
          $resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE categoria_producto = 'Neceser'");
          break;
      case 'Bolso Matero':
        $resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE categoria_producto = 'Bolso Matero'");
        break;
      case 'Set Matero':
        $resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE categoria_producto = 'Set Matero'");
        break;
      case 'Billetera':
        $resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE categoria_producto = 'Billetera'");
        break;
      case 'Bandolera':
        $resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE categoria_producto = 'Bandolera'");
        break;
      case 'Varios':
        $resultado = mysqli_query($conexion, "SELECT * FROM productos  WHERE categoria_producto = 'Varios' ORDER BY nombre_producto ASC");
        break;
      default:
      echo 'Categoria no valida';
      exit;
    }
    
    if ($resultado) {
      $_SESSION['productos'] = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
      header("Location: ../panel.php?eaea#tabla-resultado");
      exit;
    } else {
      echo 'No se encontraron productos.';
    }
  }
} else {
  echo 'Error de usuario invalido';
}
