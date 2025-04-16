<?php
require_once('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_compra'])) {
    $id_compra = intval($_POST['id_compra']);

    // 1. Obtener los datos de la compra
    $query = "SELECT * FROM compras WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_compra);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        die("Compra no encontrada.");
    }

    $compra = $resultado->fetch_assoc();

    // 2. Decodificar productos JSON
    $productos = json_decode($compra['productos_json'], true);
    if (!$productos) {
        die("Error al decodificar productos.");
    }

    // 3. Restar stock por cada producto
    foreach ($productos as $producto) {
        $id_producto = intval($producto['id']);
        $cantidad = intval($producto['cantidad']);

        $stmt_stock = $conn->prepare("UPDATE productos SET stock = stock - ? WHERE id = ? AND stock >= ?");
        $stmt_stock->bind_param("iii", $cantidad, $id_producto, $cantidad);
        $stmt_stock->execute();

        if ($stmt_stock->affected_rows === 0) {
            die("Stock insuficiente para el producto ID $id_producto.");
        }
    }

    // 4. Insertar la compra en la tabla ventas (venta final para enviar)
    $stmt_venta = $conn->prepare("INSERT INTO ventas (total, fecha) VALUES (?, NOW())");
    $stmt_venta->bind_param("d", $compra['total']);
    $stmt_venta->execute();
    $venta_id = $conn->insert_id;

    // 5. Insertar en detalle_ventas
    $stmt_detalle = $conn->prepare("INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
    foreach ($productos as $producto) {
        $id_producto = intval($producto['id']);
        $cantidad = intval($producto['cantidad']);
        $precio_unitario = floatval($producto['precio_unitario']);
        $stmt_detalle->bind_param("iiid", $venta_id, $id_producto, $cantidad, $precio_unitario);
        $stmt_detalle->execute();
    }

    // 6. Actualizar estado de la compra a 'confirmada'
    $stmt_update = $conn->prepare("UPDATE compras SET estado = 'confirmada' WHERE id = ?");
    $stmt_update->bind_param("i", $id_compra);
    $stmt_update->execute();

    // Redireccionar o mostrar mensaje
    header("Location: ../panel.php?mensaje=venta_confirmada");
    exit;
}
?>
