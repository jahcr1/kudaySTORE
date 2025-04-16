<?php
require_once('conexion.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_compra'])) {
    $id_compra = intval($_POST['id_compra']);

    // 1. Obtener los datos de la compra
    $query = "SELECT * FROM compras WHERE id = ?";
    $stmt = $conexion->prepare($query);
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

        $stmt_stock = $conexion->prepare("UPDATE productos SET stock = stock - ? WHERE id = ? AND stock >= ?");
        $stmt_stock->bind_param("iii", $cantidad, $id_producto, $cantidad);
        $stmt_stock->execute();

        if ($stmt_stock->affected_rows === 0) {
            die("Stock insuficiente para el producto ID $id_producto.");
        }
    }

    // 4. Insertar la compra en la tabla ventas (venta final para enviar)
    $productos_json = json_encode($productos, JSON_UNESCAPED_UNICODE);

    $stmt_venta = $conexion->prepare("INSERT INTO ventas (
        nombre_cliente, apellido_cliente, telefono_cliente, email_cliente, direccion, provincia, ciudad, codigopostal, total, productos_json, fecha
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    $stmt_venta->bind_param(
        "sssssssdds",
        $compra['nombre_cliente'],
        $compra['apellido_cliente'],
        $compra['telefono_cliente'],
        $compra['email_cliente'],
        $compra['direccion'],
        $compra['provincia'],
        $compra['ciudad'],
        $compra['codigopostal'],
        $compra['total'],
        $productos_json
    );

    $stmt_venta->execute();
    $venta_id = $conexion->insert_id;

    // 5. Insertar en detalle_ventas
    $stmt_detalle = $conexion->prepare("INSERT INTO detalle_ventas (id_venta, id_producto, nombre_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?, ?)");
    foreach ($productos as $producto) {
        $id_producto = intval($producto['id']);
        $cantidad = intval($producto['cantidad']);
        $nombre_producto = $producto['name'];
        $precio_unitario = floatval($producto['price']);
        $stmt_detalle->bind_param("iisid", $venta_id, $id_producto, $nombre_producto, $cantidad, $precio_unitario);
        $stmt_detalle->execute();
    }

    // 6. Actualizar estado de la compra a 'confirmada'
    $stmt_update = $conexion->prepare("UPDATE compras SET estado = 'Confirmada' WHERE id = ?");
    $stmt_update->bind_param("i", $id_compra);
    $stmt_update->execute();

    // Confirmación Exitosa y redirigimos a mostrar_compras para actualizar la tabla
    header("Location: mostrar_compras.php?auto=1");
    exit();
}
