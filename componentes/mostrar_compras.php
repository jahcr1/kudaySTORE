<?php 
session_start();
require_once('conexion.php');

if (isset($_SESSION['administrador'])) {
    // Se puede usar GET o POST, así el script es más flexible
    $nombre = isset($_REQUEST['nombre']) ? mysqli_real_escape_string($conexion, $_REQUEST['nombre']) : '';
    $fecha = isset($_REQUEST['fecha']) ? mysqli_real_escape_string($conexion, $_REQUEST['fecha']) : '';

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

    // Si fue solicitado como redirección automática
    if (isset($_GET['auto']) && $_GET['auto'] === '1') {
        $mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : 'actualizado';
        header("Location: ../panel.php?mensaje=$mensaje#ventas");
        exit();
    }
    
} else {
    $_SESSION['error'] = "Acceso no autorizado.";
    header("Location: ../index.php");
    exit();
}
