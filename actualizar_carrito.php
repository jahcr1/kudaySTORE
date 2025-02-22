<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $cantidad = $_POST['cantidad'];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = $cantidad;
    }

    // Recalcular el total de productos en el carrito
    $cartCount = array_sum($_SESSION['cart']);
    echo json_encode(['cartCount' => $cartCount]);
}
?>