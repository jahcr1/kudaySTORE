<?php
declare(strict_types=1);

ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/componentes/conexion.php';
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
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

    // Obtener payment id (variantes: payload->data->id, query id, etc.)
    $paymentId = null;
    if (!empty($input['data']['id'])) {
        $paymentId = $input['data']['id'];
    } elseif (!empty($_GET['id'])) {
        $paymentId = $_GET['id'];
    } elseif (!empty($input['id'])) {
        $paymentId = $input['id'];
    }

    if (!$paymentId) {
        // No hay id de pago -> responder 200 para que MP no reintente infinitamente
        http_response_code(200);
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - webhook sin payment id: " . $raw . PHP_EOL, FILE_APPEND);
        exit;
    }

    $paymentClient = new PaymentClient();
    $payment = $paymentClient->get((int)$paymentId);

    // Obtener estado del pago
    $status = $payment->status ?? null; // ej. 'approved', 'pending', 'rejected'

    // Intentar obtener external_reference (idCompra) de distintas fuentes
    $externalReference = null;

    // 1) Si el payment tiene campo order.id -> pedir merchant order y leer external_reference
    if (!empty($payment->order) && !empty($payment->order->id)) {
        $merchantClient = new MerchantOrderClient();
        $merchant = $merchantClient->get((int)$payment->order->id);
        $externalReference = $merchant->external_reference ?? null;
    }

    // 2) Si el payment trae preference_id -> pedir preference y ver external_reference
    if (!$externalReference && !empty($payment->preference_id)) {
        $prefClient = new PreferenceClient();
        $pref = $prefClient->get((string)$payment->preference_id);
        $externalReference = $pref->external_reference ?? null;
    }

    // 3) fallback: ¿viene en el payment directamente?
    if (!$externalReference && !empty($payment->external_reference)) {
        $externalReference = $payment->external_reference;
    }

    if (!$externalReference) {
        // No podemos relacionar con la compra -> log y salir 200
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

    // Mapear estado MP => estado local
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

    // Actualizar estado en BD
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

    // Actualizar estado de la compra
    $stmtUpd = $conexion->prepare("UPDATE compras SET estado = ? WHERE id = ?");
    $stmtUpd->bind_param('si', $nuevoEstado, $idCompra);
    $stmtUpd->execute();
    $stmtUpd->close();

    // Si está aprobado (o similar) -> descontar stock y generar comprobante
    if (in_array(strval($status), ['approved', 'authorized', 'paid'], true)) {
        // Descontar stock: hacemos en transacción
        $productos_array = json_decode($productos_json, true);
        if (!is_array($productos_array)) $productos_array = [];

        $conexion->begin_transaction();

        $ok = true;
        $stmtStock = $conexion->prepare("UPDATE productos SET stock = stock - ? WHERE id = ? AND stock >= ?");
        if (!$stmtStock) {
            $ok = false;
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - prepare stock failed: {$conexion->error}" . PHP_EOL, FILE_APPEND);
        }

        foreach ($productos_array as $p) {
            $prodId = intval($p['id'] ?? 0);
            $cantidad = intval($p['cantidad'] ?? ($p['quantity'] ?? 0));
            if ($prodId <= 0 || $cantidad <= 0) continue;
            $stmtStock->bind_param('iii', $cantidad, $prodId, $cantidad);
            $stmtStock->execute();
            if ($stmtStock->affected_rows === 0) {
                // No hay suficiente stock o producto no existe
                $ok = false;
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - stock insuficiente o producto no existe (producto: {$prodId}, qty: {$cantidad})" . PHP_EOL, FILE_APPEND);
                break;
            }
        }
        if ($stmtStock) $stmtStock->close();

        if ($ok) {
            $conexion->commit();

            // Generar PDF (usando Dompdf)
            $dompdf = new Dompdf();
            $html = '<h1>Comprobante de Pago - Fatto In Casa</h1>';
            $html .= '<p>Compra ID: ' . $idCompra . '</p>';
            $html .= '<p>Cliente: ' . htmlspecialchars($nombre_cliente . ' ' . $apellido_cliente) . '</p>';
            $html .= '<table border="1" cellpadding="6" cellspacing="0" width="100%">';
            $html .= '<tr><th>Producto</th><th>Cantidad</th><th>Precio unit.</th><th>Subtot.</th></tr>';
            $sum = 0;
            foreach ($productos_array as $p) {
                $title = htmlspecialchars($p['name'] ?? $p['title'] ?? '');
                $qty = intval($p['cantidad'] ?? ($p['quantity'] ?? 0));
                $price = floatval($p['price'] ?? $p['unit_price'] ?? 0);
                $sub = $qty * $price;
                $sum += $sub;
                $html .= "<tr><td>{$title}</td><td>{$qty}</td><td>\$" . number_format($price, 2, ',', '.') . "</td><td>\$" . number_format($sub, 2, ',', '.') . "</td></tr>";
            }
            $html .= "<tr><td colspan='3' align='right'><strong>Total</strong></td><td><strong>\$" . number_format($total_compra, 2, ',', '.') . "</strong></td></tr>";
            $html .= '</table>';
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $output = $dompdf->output();
            $filename = __DIR__ . '/facturas/factura_' . $idCompra . '_' . time() . '.pdf';
            file_put_contents($filename, $output);

            // Enviar email con PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = $_ENV['MAIL_HOST'] ?? getenv('MAIL_HOST');
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['MAIL_USERNAME'] ?? getenv('MAIL_USERNAME');
                $mail->Password = $_ENV['MAIL_PASSWORD'] ?? getenv('MAIL_PASSWORD');
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = intval($_ENV['MAIL_PORT'] ?? getenv('MAIL_PORT') ?: 587);

                $from = $_ENV['MAIL_FROM'] ?? getenv('MAIL_FROM');
                $fromName = $_ENV['MAIL_FROM_NAME'] ?? getenv('MAIL_FROM_NAME') ?? 'Fatto In Casa';
                $mail->setFrom($from, $fromName);
                $mail->addAddress($email_cliente, $nombre_cliente . ' ' . $apellido_cliente);

                $mail->Subject = "Comprobante de compra #{$idCompra} - Fatto In Casa";
                $mail->Body = "Hola {$nombre_cliente}, adjuntamos tu comprobante de pago. Gracias por tu compra.";
                $mail->addAttachment($filename);

                $mail->send();
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - comprobante enviado a {$email_cliente} para compra {$idCompra}\n", FILE_APPEND);
            } catch (Throwable $mailEx) {
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - Error enviando mail: " . $mailEx->getMessage() . PHP_EOL, FILE_APPEND);
            }

        } else {
            $conexion->rollback();
            // marcar la compra con estado de problema si querés
            $stmtErr = $conexion->prepare("UPDATE compras SET estado = ? WHERE id = ?");
            $estadoErr = 'Error stock';
            $stmtErr->bind_param('si', $estadoErr, $idCompra);
            $stmtErr->execute();
            $stmtErr->close();
            file_put_contents($logFile, date('Y-m-d H:i:s') . " - rollback por stock insuficiente en compra {$idCompra}\n", FILE_APPEND);
        }
    }

    // Responder 200 OK para que MP no reintente
    http_response_code(200);
    echo 'OK';
    exit;

} catch (Throwable $e) {
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - webhook ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n", FILE_APPEND);
    // responder 200 para que MP no reintente infinitamente (o 500 si preferís)
    http_response_code(200);
    echo 'OK';
    exit;
}
