<?php
session_start();

require_once('conexion.php');


if (isset($_SESSION['administrador'])) {

  if (isset($_POST['categoria'])) {

    $categoria = mysqli_real_escape_string($conexion, $_POST['categoria']);
    $resultado = null;

    switch ($categoria) {
      case 'Cartuchera':
        $resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE categoria = 'Cartuchera'");
        break;
        case 'Neceser':
          $resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE categoria = 'Neceser'");
          break;
      case 'Bolso Matero':
        $resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE categoria = 'Bolso Matero'");
        break;
      case 'Set Matero':
        $resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE categoria = 'Set Matero'");
        break;
      case 'Billetera':
        $resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE categoria = 'Billetera'");
        break;
      case 'Bandolera':
        $resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE categoria = 'Bandolera'");
        break;
      case 'Varios':
        $resultado = mysqli_query($conexion, "SELECT * FROM productos  WHERE categoria = 'Varios' ORDER BY nombre ASC");
        break;
      case 'Promociones':
        $resultado = mysqli_query($conexion, "SELECT * FROM productos  WHERE categoria = 'Promociones' ORDER BY nombre ASC");
        break;
      default:
      echo 'Categoria no valida';
      exit;
    }
    
    if ($resultado) {
      $_SESSION['productos'] = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
      header("Location: ../panel.php?eaea#tabla-resultado");
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
