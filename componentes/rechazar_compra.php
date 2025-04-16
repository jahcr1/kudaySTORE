<?php
require('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_compra'])) {
    $id_compra = intval($_POST['id_compra']);

    // Actualizar el estado a 'rechazada'
    $stmt = $conexion->prepare("UPDATE compras SET estado = 'Rechazada' WHERE id = ?");
    $stmt->bind_param("i", $id_compra);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Redirigimos a mostrar_compras.php para actualizar los datos
        header("Location: mostrar_compras.php?auto=1&mensaje=compra_rechazada");
    } else {
        // Algo salió mal o ya estaba rechazada
        header("Location: mostrar_compras.php?auto=1&mensaje=error_rechazo");
    }
    exit;
}
?>

