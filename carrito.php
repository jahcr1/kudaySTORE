<?php
session_start();

include('./componentes/conexion.php');

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    echo "<p>No hay productos en el carrito.</p>";
    exit;
}

$productIds = implode(',', array_keys($cart));
$query = "SELECT * FROM productos WHERE id IN ($productIds)";
$result = mysqli_query($conexion, $query);

?>

<h1>Carrito</h1>
<table>
    <thead>
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total = 0;
        while ($product = mysqli_fetch_assoc($result)) {
            $id = $product['id'];
            $cantidad = $cart[$id];
            $subtotal = $product['precio'] * $cantidad;
            $total += $subtotal;
        ?>
        <tr>
            <td><?php echo $product['nombre']; ?></td>
            <td>$<?php echo $product['precio']; ?></td>
            <td><?php echo $cantidad; ?></td>
            <td>$<?php echo $subtotal; ?></td>
        </tr>
        <?php } ?>
        <tr>
            <td colspan="3">Total</td>
            <td>$<?php echo $total; ?></td>
        </tr>
    </tbody>
</table>

<a href="cerrar.php"> cerrar sesion</a>