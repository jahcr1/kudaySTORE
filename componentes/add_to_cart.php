<?php
session_start();

// Incluir el archivo de conexión a la base de datos
include_once('conexion.php');  // Asegúrate de que la ruta es correcta

// Verifica si se envió una solicitud POST con datos válidos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (!isset($data['productId'], $data['quantity']) || !is_numeric($data['productId']) || !is_numeric($data['quantity'])) {
        echo json_encode(['success' => false, 'error' => 'Datos inválidos.']);
        exit;
    }

    $productId = (int)$data['productId'];
    $quantity = (int)$data['quantity'];

    // Verifica si la cantidad es válida
    if ($quantity < 1) {
        echo json_encode(['success' => false, 'error' => 'Cantidad inválida.']);
        exit;
    }

    // Verifica si la conexión está activa
    if (!$conexion) {
        echo json_encode(['success' => false, 'error' => 'Conexión a la base de datos fallida.']);
        exit;
    }

    // Consulta para obtener el stock del producto desde la base de datos
    $query = "SELECT stock FROM productos WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if (!$product) {
        echo json_encode(['success' => false, 'error' => 'Producto no encontrado.']);
        exit;
    }

    // Verifica que no se supere el stock disponible
    $availableStock = $product['stock'];

    // Si el producto ya está en el carrito, verificamos la cantidad total
    $currentCartQuantity = isset($_SESSION['cart'][$productId]) ? $_SESSION['cart'][$productId] : 0;

    // Verifica si la cantidad total excede el stock
    if ($currentCartQuantity + $quantity > $availableStock) {
        echo json_encode(['success' => false, 'error' => 'Cantidad solicitada excede el stock disponible.']);
        exit;
    }

    // Inicializa el carrito si no existe
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Actualiza la cantidad del producto en el carrito
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }

    // Calcula el total de productos en el carrito
    $totalItems = array_sum($_SESSION['cart']);

    // Devuelve una respuesta JSON con el nuevo estado del carrito
    echo json_encode(['success' => true, 'cartCount' => $totalItems]);
    exit;
}

// Si se llega a este punto, el método no es POST
echo json_encode(['success' => false, 'error' => 'Método no permitido.']);
exit;
