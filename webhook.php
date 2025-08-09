<?php

declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/componentes/conexion.php';
require_once __DIR__ . '/vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\MerchantOrder\MerchantOrderClient;
use MercadoPago\Client\Preference\PreferenceClient;
use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;

$logFile = __DIR__ . '/componentes/logs_errores_php.txt';

try {
    $mpAccessToken = $_ENV['MP_ACCESS_TOKEN'] ?? getenv('MP_ACCESS_TOKEN') ?: null;
    if (!$mpAccessToken) {
        throw new Exception('MP access token no definido');
    }
    MercadoPagoConfig::setAccessToken($mpAccessToken);

    // Leer body
    $raw = file_get_contents('php://input');
    $input = json_decode($raw, true);

    // Logging inicial
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - Webhook recibido: {$raw}" . PHP_EOL, FILE_APPEND);

    // Obtener payment id
    $paymentId = $input['data']['id'] ?? $_GET['id'] ?? $input['id'] ?? null;
    if (!$paymentId) {
        http_response_code(200);
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - webhook sin payment id" . PHP_EOL, FILE_APPEND);
        exit;
    }

    $paymentClient = new PaymentClient();
    $payment = $paymentClient->get((int)$paymentId);
    $status = $payment->status ?? null;

    // Buscar external_reference
    $externalReference = null;
    if (!empty($payment->order->id)) {
        $merchantClient = new MerchantOrderClient();
        $merchant = $merchantClient->get((int)$payment->order->id);
        $externalReference = $merchant->external_reference ?? null;
    }
    if (!$externalReference && !empty($payment->preference_id)) {
        $prefClient = new PreferenceClient();
        $pref = $prefClient->get((string)$payment->preference_id);
        $externalReference = $pref->external_reference ?? null;
    }
    if (!$externalReference && !empty($payment->external_reference)) {
        $externalReference = $payment->external_reference;
    }

    if (!$externalReference) {
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - webhook no pudo ubicar external_reference para payment {$paymentId}" . PHP_EOL, FILE_APPEND);
        http_response_code(200);
        exit;
    }

    $idCompra = intval($externalReference);
    if ($idCompra <= 0) {
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - external_reference inválido: {$externalReference}" . PHP_EOL, FILE_APPEND);
        http_response_code(200);
        exit;
    }

    // Mapear estado
    $map = [
        'approved' => 'Aprobado',
        'authorized' => 'Aprobado',
        'paid' => 'Aprobado',
        'pending' => 'Pendiente',
        'in_process' => 'En proceso',
        'rejected' => 'Rechazado',
        'cancelled' => 'Rechazado'
    ];
    $nuevoEstado = $map[strval($status)] ?? $status;

    // Obtener datos de compra
    $stmt = $conexion->prepare("SELECT productos_json, email_cliente, nombre_cliente, apellido_cliente, total FROM compras WHERE id = ?");
    $stmt->bind_param('i', $idCompra);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - compra no encontrada: {$idCompra}" . PHP_EOL, FILE_APPEND);
        http_response_code(200);
        exit;
    }
    $row = $res->fetch_assoc();
    $productos_json = $row['productos_json'];
    $email_cliente = $row['email_cliente'];
    $nombre_cliente = $row['nombre_cliente'];
    $apellido_cliente = $row['apellido_cliente'];
    $total_compra = $row['total'];
    $stmt->close();

    // Actualizar estado
    $stmtUpd = $conexion->prepare("UPDATE compras SET estado = ? WHERE id = ?");
    $stmtUpd->bind_param('si', $nuevoEstado, $idCompra);
    $stmtUpd->execute();
    $stmtUpd->close();

    // Si aprobado -> descontar stock y generar comprobante
    if (in_array(strval($status), ['approved', 'authorized', 'paid'], true)) {
        $productos_array = json_decode($productos_json, true) ?: [];

        file_put_contents($logFile, date('Y-m-d H:i:s') . " - Procesando compra {$idCompra} con productos: " . $productos_json . PHP_EOL, FILE_APPEND);

        $conexion->begin_transaction();
        $ok = true;

        $stmtStock = $conexion->prepare("UPDATE productos SET stock = stock - ? WHERE id = ? AND stock >= ?");
        foreach ($productos_array as $p) {
            $prodId = intval($p['id'] ?? 0);
            $cantidad = intval($p['cantidad'] ?? ($p['quantity'] ?? 0));
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - Intentando descontar producto {$prodId} cantidad {$cantidad}" . PHP_EOL, FILE_APPEND);

            if ($prodId <= 0 || $cantidad <= 0) continue;
            $stmtStock->bind_param('iii', $cantidad, $prodId, $cantidad);
            $stmtStock->execute();
            if ($stmtStock->affected_rows === 0) {
                $ok = false;
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - Stock insuficiente o producto inexistente (ID {$prodId})" . PHP_EOL, FILE_APPEND);
                break;
            }
        }
        $stmtStock->close();

        if ($ok) {
            $conexion->commit();

            // PDF con branding
            $logoPath = __DIR__ . '/imagenes/logo.png';
            $html = '
            <html>
            <head>
              <style>
                body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
                h1 { color: #c62828; margin-bottom: 0; }
                table { border-collapse: collapse; width: 100%; margin-top: 20px; }
                th, td { padding: 8px; border: 1px solid #ddd; }
                th { background-color: #f2f2f2; text-align: left; }
                .total { font-weight: bold; }
              </style>
            </head>
            <body>
              <div style="text-align:center;">
                <img src="' . $logoPath . '" style="max-height:80px;">
                <h1>Kuday Artesanías</h1>
                <p>Comprobante de Pago</p>
              </div>
              <p><strong>Compra ID:</strong> ' . $idCompra . '</p>
              <p><strong>Cliente:</strong> ' . htmlspecialchars($nombre_cliente . ' ' . $apellido_cliente) . '</p>
              <table>
                <tr><th>Producto</th><th>Cantidad</th><th>Precio unit.</th><th>Subtotal</th></tr>';
            foreach ($productos_array as $p) {
                $title = htmlspecialchars($p['name'] ?? $p['title'] ?? '');
                $qty = intval($p['cantidad'] ?? ($p['quantity'] ?? 0));
                $price = floatval($p['price'] ?? $p['unit_price'] ?? 0);
                $sub = $qty * $price;
                $html .= "<tr><td>{$title}</td><td>{$qty}</td><td>\$" . number_format($price, 2, ',', '.') . "</td><td>\$" . number_format($sub, 2, ',', '.') . "</td></tr>";
            }
            $html .= "<tr><td colspan='3' align='right' class='total'>Total</td><td class='total'>\$" . number_format($total_compra, 2, ',', '.') . "</td></tr>";
            $html .= '</table></body></html>';

            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $output = $dompdf->output();
            $filename = __DIR__ . '/facturas/factura_' . $idCompra . '_' . time() . '.pdf';
            file_put_contents($filename, $output);

            // Email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = $_ENV['SMTP_HOST'] ?? getenv('SMTP_HOST');
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['SMTP_USER'] ?? getenv('SMTP_USER');
                $mail->Password = $_ENV['SMTP_PASSWORD'] ?? getenv('SMTP_PASSWORD');
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = intval($_ENV['SMTP_PORT'] ?? getenv('SMTP_PORT') ?: 587);

                $from = $_ENV['SMTP_USER'] ?? getenv('SMTP_USER');
                $mail->setFrom($from, 'Kuday Artesanías');
                $mail->addAddress($email_cliente, $nombre_cliente . ' ' . $apellido_cliente);

                $mail->Subject = "Comprobante de compra #{$idCompra} - Kuday Artesanías";
                $mail->Body = "Hola {$nombre_cliente}, adjuntamos tu comprobante de pago. ¡Gracias por tu compra!";
                $mail->addAttachment($filename);

                $mail->send();
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - comprobante enviado a {$email_cliente} para compra {$idCompra}\n", FILE_APPEND);
            } catch (\Throwable $mailEx) {
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - Error enviando mail: " . $mailEx->getMessage() . PHP_EOL, FILE_APPEND);
            }
        } else {
            $conexion->rollback();
            $estadoErr = 'Error stock';
            $stmtErr = $conexion->prepare("UPDATE compras SET estado = ? WHERE id = ?");
            $stmtErr->bind_param('si', $estadoErr, $idCompra);
            $stmtErr->execute();
            $stmtErr->close();
        }
    }

    http_response_code(200);
    echo 'OK';
    exit;
} catch (\Throwable $e) {
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - webhook ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
    http_response_code(200);
    echo 'OK';
    exit;
}
