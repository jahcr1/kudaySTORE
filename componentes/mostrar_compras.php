<?php
session_start();

require_once('conexion.php');

if (isset($_SESSION['administrador'])) {
    $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($conexion, $_POST['nombre']) : '';
    $fecha = isset($_POST['fecha']) ? mysqli_real_escape_string($conexion, $_POST['fecha']) : '';

    $sql = "SELECT * FROM compras WHERE 1";

    if (!empty($nombre)) {
        $sql .= " AND nombre_cliente LIKE '%$nombre%'";
    }

    if (!empty($fecha)) {
        $sql .= " AND DATE(fecha_compra) = '$fecha'";
    }

    $sql .= " ORDER BY fecha_compra DESC";

    $resultado = mysqli_query($conexion, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $_SESSION['compras'] = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    } else {
        $_SESSION['compras'] = [];
    }

    header("Location: ../panel.php#ventas");
    exit();
} else {
    $_SESSION['error'] = "Acceso no autorizado.";
    header("Location: ../index.php");
    exit();
}
?>
