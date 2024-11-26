<?php
include('./componentes/conexion.php');
session_start();

// Obtiene el ID del producto de la URL
$id_producto = $_GET['id'] ?? null;

if (!$id_producto) {
    echo "Producto no encontrado.";
    exit;
}

// Consulta el producto en la base de datos
$query = "SELECT p.*, c.nombre AS categoria_nombre 
          FROM productos p 
          JOIN categorias c 
          ON p.categoria_id = c.id 
          WHERE p.id = $id_producto";
$result = mysqli_query($conexion, $query);
$producto = mysqli_fetch_assoc($result);

if (!$producto) {
    echo "Producto no encontrado.";
    exit;
}
?>

<div class="detalle-producto">
    <h1><?php echo $producto['nombre']; ?></h1>
    <img src="data:<?php echo $producto['formato_imagen']; ?>;base64,<?php echo base64_encode($producto['ci_imagen_producto']); ?>" alt="Imagen del Producto">
    <p><strong>Precio:</strong> $<?php echo $producto['precio']; ?></p>
    <p><strong>Descripción:</strong> <?php echo $producto['descripcion']; ?></p>
    <p><strong>Categoría:</strong> <?php echo $producto['categoria_nombre']; ?></p>
    <a href="./carrito.php" class="btn btn-danger add-carrito" data-id="<?php echo $producto['id']; ?>">Agregar al carrito</a>
</div>
