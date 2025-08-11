<?php

declare(strict_types=1);

// Ajuste zona horaria Argentina
date_default_timezone_set('America/Argentina/Buenos_Aires');

ini_set('display_errors', '1'); // solo en dev
error_reporting(E_ALL);

require_once __DIR__ . '/conexion.php'; // tu conexión mysqli en $conexion
require_once __DIR__ . '/../vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

header('Content-Type: application/json; charset=utf-8');

$logFile = __DIR__ . '/logs_errores_php.txt';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Método no permitido']);
        exit;
    }

    // Leer JSON del body; fallback a $_POST si no vienen JSON
    $raw = file_get_contents('php://input');
    $input = json_decode($raw, true);
    if (!is_array($input)) {
        $input = $_POST;
    }

    // Campos esperados
    $nombre      = trim($input['nombre'] ?? '');
    $apellido    = trim($input['apellido'] ?? '');
    $telefono    = trim($input['telefono'] ?? '');
    $email       = trim($input['email'] ?? '');
    $direccion   = trim($input['direccion'] ?? '');
    $provincia   = trim($input['provincia'] ?? '');
    $ciudad      = trim($input['ciudad'] ?? '');
    $codigopostal = trim($input['codigopostal'] ?? '');
    $productos   = $input['productos'] ?? $input['carrito'] ?? [];
    $total       = floatval($input['total'] ?? 0);
    $costoEnvio  = floatval($input['costoEnvio'] ?? 0);

    // Aceptar productos tanto si vienen array o string JSON
    if (is_string($productos)) {
        $productos_array = json_decode($productos, true);
    } else {
        $productos_array = $productos;
    }
    if (!is_array($productos_array)) {
        $productos_array = [];
    }

    // Validaciones básicas
    if (
        $nombre === '' || $apellido === '' || $telefono === '' || $email === '' ||
        $direccion === '' || $provincia === '' || $ciudad === '' || $codigopostal === '' ||
        $total <= 0 || count($productos_array) === 0
    ) {
        throw new Exception('Faltan datos obligatorios o carrito vacío.');
    }

    // Guardar la compra en BD con estado "Pendiente"
    $productos_json = json_encode($productos_array, JSON_UNESCAPED_UNICODE);

    $stmt = $conexion->prepare("
        INSERT INTO compras
          (nombre_cliente, apellido_cliente, telefono_cliente, email_cliente, direccion, provincia, ciudad, codigopostal, productos_json, total, estado, fecha_compra)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");
    if (!$stmt) {
        throw new Exception('Error en prepare (compras): ' . $conexion->error);
    }

    $estado = 'Pendiente';
    $types = 'sssssssssds';

    $stmt->bind_param(
        $types,
        $nombre,
        $apellido,
        $telefono,
        $email,
        $direccion,
        $provincia,
        $ciudad,
        $codigopostal,
        $productos_json,
        $total,
        $estado
    );

    if (!$stmt->execute()) {
        throw new Exception('Error al insertar compra: ' . $stmt->error);
    }

    $idCompra = (int)$stmt->insert_id;
    $stmt->close();

    // Configurar Mercado Pago
    $mpAccessToken = $_ENV['MP_ACCESS_TOKEN'] ?? getenv('MP_ACCESS_TOKEN') ?: null;
    if (!$mpAccessToken) {
        throw new Exception('Token de Mercado Pago no encontrado en variables de entorno.');
    }
    MercadoPagoConfig::setAccessToken($mpAccessToken);

    // Detectar entorno y definir baseUrl
    $appEnv = $_ENV['APP_ENV'] ?? getenv('APP_ENV') ?? 'production';
    if ($appEnv === 'local') {
        $ngrokUrl = $_ENV['NGROK_URL'] ?? getenv('NGROK_URL');
        if (!$ngrokUrl) {
            throw new Exception('NGROK_URL no definido en .env para entorno local.');
        }
        $baseUrl = rtrim($ngrokUrl, '/');
    } else {
        $baseUrl = 'https://kudayartesanias.com.ar';
    }

    // Crear items para la preferencia
    $items = [];
    foreach ($productos_array as $p) {
        $title = $p['name'] ?? $p['title'] ?? 'Producto';
        $qty = max(1, intval($p['cantidad'] ?? $p['quantity'] ?? 1));
        $price = floatval($p['price'] ?? $p['unit_price'] ?? 0);
        if ($price <= 0) {
            throw new Exception("Precio inválido para el producto: {$title}");
        }
        $items[] = [
            'title' => mb_substr($title, 0, 120),
            'quantity' => $qty,
            'unit_price' => $price,
            'id' => (string)($p['id'] ?? '')
        ];
    }

    if ($costoEnvio > 0) {
        $items[] = [
            'title' => 'Costo de envío',
            'quantity' => 1,
            'unit_price' => $costoEnvio,
            'id' => 'envio_' . $idCompra
        ];
    }

    // Armar preferencia
    $preferencePayload = [
        'items' => $items,
        'payer' => [
            'name' => $nombre,
            'surname' => $apellido,
            'email' => $email
        ],
        'back_urls' => [
            'success' => $baseUrl . '/carrito.php?mp_status=success&id=' . $idCompra,
            'failure' => $baseUrl . '/carrito.php?mp_status=failure&id=' . $idCompra,
            'pending' => $baseUrl . '/carrito.php?mp_status=pending&id=' . $idCompra
        ],
        'auto_return' => 'approved',
        'notification_url' => $baseUrl . '/webhook.php',
        'statement_descriptor' => "Tienda Kuday",
        'external_reference' => (string)$idCompra
    ];

    $client = new PreferenceClient();
    $preference = $client->create($preferencePayload);

    $init_point = $preference->init_point ?? $preference->sandbox_init_point ?? null;
    if (!$init_point) {
        $arr = json_decode(json_encode($preference), true);
        $init_point = $arr['init_point'] ?? $arr['sandbox_init_point'] ?? null;
    }

    if (!$init_point) {
        throw new Exception('No se pudo generar el init_point de Mercado Pago.');
    }

    echo json_encode([
        'success' => true,
        'init_point' => $init_point,
        'id_compra' => $idCompra
    ], JSON_UNESCAPED_UNICODE);
    exit;
} catch (Throwable $e) {
    $msg = date('Y-m-d H:i:s') . ' - procesar_compra ERROR: ' . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n\n";
    file_put_contents($logFile, $msg, FILE_APPEND);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al procesar la compra. ' . $e->getMessage()]);
    exit;
}
