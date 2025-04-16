<?php
require('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_compra'])) {
    $id_compra = intval($_POST['id_compra']);

    // Actualizar el estado a 'rechazada'
    $stmt = $conn->prepare("UPDATE compras SET estado = 'rechazada' WHERE id = ?");
    $stmt->bind_param("i", $id_compra);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Redireccionar con mensaje de éxito
        header("Location: ../panel.php?mensaje=compra_rechazada");
    } else {
        // Algo salió mal o ya estaba rechazada
        header("Location: ../panel.php?mensaje=error_rechazo");
    }
    exit;
}
?>
