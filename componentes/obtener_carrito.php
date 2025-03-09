<?php
session_start();

// Si no hay carrito en sesión, devolver valores por defecto
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// **Eliminar productos con cantidad 0 para evitar errores**
$_SESSION['carrito'] = array_filter($_SESSION['carrito'], function($item) {
  return $item['cantidad'] > 0;
});

// Calcular el total del carrito
$total = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total += $item['precio'] * $item['cantidad'];
}

// Obtener el costo de envío guardado en sesión o establecerlo en 0
$costoEnvio = isset($_SESSION['costoEnvio']) ? $_SESSION['costoEnvio'] : 0;

/// Responder con JSON
echo json_encode([
  "carrito" => array_values($_SESSION['carrito']), // Reindexamos el array
  "total" => $total,
  "costoEnvio" => $costoEnvio
]);

