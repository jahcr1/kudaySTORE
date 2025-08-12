<?php

declare(strict_types=1);

// Ajuste zona horaria Argentina
date_default_timezone_set('America/Argentina/Buenos_Aires');

ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/componentes/conexion.php';
require_once __DIR__ . '/vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;

$logFile = __DIR__ . '/componentes/logs_errores_php.txt';

/**
 * === FUNCIONES UTILES (CAMBIO) ===
 * parse_float: limpia y convierte distintos formatos de string numérico a float.
 * Esto evita errores con number_format() cuando vienen strings con comas, puntos, símbolos, etc.
 */
function parse_float(mixed $val): float {
    if (is_float($val) || is_int($val)) {
        return (float)$val;
    }
    $s = (string)$val;
    $s = trim($s);
    if ($s === '') return 0.0;

    // quitar espacios NO separadores y caracteres no numéricos (salvo ,- .)
    $s = preg_replace('/[^\d\-,\.]/u', '', $s);

    // detectar si hay ambos separadores '.' y ','
    $lastDot = strrpos($s, '.');
    $lastComma = strrpos($s, ',');
    if ($lastDot !== false && $lastComma !== false) {
        // si la coma está después del punto, asumimos coma = decimal (1.234,56)
        if ($lastComma > $lastDot) {
            $s = str_replace('.', '', $s);     // eliminar miles
            $s = str_replace(',', '.', $s);    // convertir decimal
        } else {
            // punto está después -> 1,234.56 (coma miles, punto decimal)
            $s = str_replace(',', '', $s);
        }
    } elseif ($lastComma !== false && $lastDot === false) {
        // solo coma — probablemente decimal (e.g. "1234,56")
        $s = str_replace(',', '.', $s);
    } else {
        // solo punto o ninguno -> dejar como está (punto decimal o entero)
    }

    // finalmente casteamos
    return (float)$s;
}

try {
    // 1. Configurar Mercado Pago
    $mpAccessToken = $_ENV['MP_ACCESS_TOKEN'] ?? getenv('MP_ACCESS_TOKEN') ?: null;
    if (!$mpAccessToken) {
        throw new Exception('MP access token no definido');
    }
    MercadoPagoConfig::setAccessToken($mpAccessToken);

    // 2. Leer body crudo y logearlo para debug
    $raw = file_get_contents('php://input');
    $input = json_decode($raw, true);
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - Webhook recibido: {$raw}" . PHP_EOL, FILE_APPEND);

    /**
     * 3. DETECCIÓN DE paymentId robusta
     * ------------------------------------------------
     * Mercado Pago envía distintos formatos:
     * - Formato viejo con "topic" y "resource" o "data.id"
     * - Formato nuevo con "type" y "data.id"
     * Este bloque detecta todos los casos posibles.
     */
    $paymentId = null;

    // Caso formato viejo con 'topic'
    if (($input['topic'] ?? '') === 'payment') {
        if (!empty($input['data']['id'])) {
            $paymentId = $input['data']['id'];
        } elseif (!empty($input['resource'])) {
            // Puede ser solo un número o una URL completa
            if (is_numeric($input['resource'])) {
                $paymentId = $input['resource'];
            } else {
                $paymentId = basename(parse_url($input['resource'], PHP_URL_PATH));
            }
        }
    }
    // Caso formato nuevo con 'type', acá entra por positivo
    elseif (($input['type'] ?? '') === 'payment' && !empty($input['data']['id'])) {
        $paymentId = $input['data']['id'];
    }
    // Si es merchant_order lo ignoramos (opcional)
    elseif (($input['topic'] ?? '') === 'merchant_order') {
        http_response_code(200);
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - Notificación merchant_order ignorada\n", FILE_APPEND);
        exit;
    }

    // Si sigue sin ID, salir
    if (!$paymentId) {
        http_response_code(200);
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - webhook sin payment id" . PHP_EOL, FILE_APPEND);
        exit;
    }

    /**
     * 4. Recuperar información del pago desde la API
     */
    $paymentClient = new PaymentClient();
    $payment = $paymentClient->get((int)$paymentId);
    $status = $payment->status ?? null;
    $externalReference = $payment->external_reference ?? null;

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

    // 5. Evitar reprocesar compra ya aprobada
    $stmtCheck = $conexion->prepare("SELECT estado FROM compras WHERE id = ?");
    $stmtCheck->bind_param('i', $idCompra);
    $stmtCheck->execute();
    $resCheck = $stmtCheck->get_result();
    $estadoActual = $resCheck->fetch_assoc()['estado'] ?? '';
    $stmtCheck->close();

    if ($estadoActual === 'Aprobado') {
        file_put_contents($logFile, date('Y-m-d H:i:s') . " - compra {$idCompra} ya procesada\n", FILE_APPEND);
        http_response_code(200);
        exit;
    }

    // 6. Mapear estado de Mercado Pago
    $map = [
        'approved'   => 'Aprobado',
        'authorized' => 'Aprobado',
        'paid'       => 'Aprobado',
        'pending'    => 'Pendiente',
        'in_process' => 'En proceso',
        'rejected'   => 'Rechazado',
        'cancelled'  => 'Rechazado'
    ];
    $nuevoEstado = $map[strval($status)] ?? $status;

    // 7. Obtener datos de la compra
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
    // === CAMBIO: sanitizar y castear total a float para evitar TypeError en number_format por PHP 8+ === 
    $total_compra = parse_float($row['total'] ?? 0);
    $stmt->close();

    // 8. Actualizar estado (se actualiza; si falla stock más abajo se reescribirá a Error stock)
    $stmtUpd = $conexion->prepare("UPDATE compras SET estado = ? WHERE id = ?");
    $stmtUpd->bind_param('si', $nuevoEstado, $idCompra);
    $stmtUpd->execute();
    $stmtUpd->close();

    
    // 9. Si aprobado → descontar stock y generar comprobante
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

            //  PREPARAR FACTURA / PDF 
            // Asegurarse que el directorio exista
            $facturasDir = __DIR__ . '/facturas';
            if (!is_dir($facturasDir)) {
                @mkdir($facturasDir, 0755, true);
            }

            // Logo: usar file:// si existe
            $logoPath = __DIR__ . '/images/logo/logo1.png';
            $logoTag = '';
            if (file_exists($logoPath)) {
                $logoReal = realpath($logoPath);
                // Dompdf puede necesitar file:// para rutas locales
                $logoSrc = 'file://' . $logoReal;
                $logoTag = '<img src="' . $logoSrc . '" style="max-height:80px;">';
            }

            // Construir HTML de la factura (asegurando casts)
            $html = '
            <html>
            <head>
              <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
              <div style="text-align:center;">' . $logoTag . '<h1>Kuday Artesanías</h1><p>Comprobante de Pago</p></div>
              <p><strong>Compra ID:</strong> ' . $idCompra . '</p>
              <p><strong>Cliente:</strong> ' . htmlspecialchars($nombre_cliente . ' ' . $apellido_cliente) . '</p>
              <table>
                <tr><th>Producto</th><th>Cantidad</th><th>Precio unit.</th><th>Subtotal</th></tr>';

            foreach ($productos_array as $p) {
                $title = htmlspecialchars($p['name'] ?? $p['title'] ?? '');
                $qty = intval($p['cantidad'] ?? ($p['quantity'] ?? 0));
                // === CAMBIO: parsear el precio robustamente ===
                $price = parse_float($p['price'] ?? $p['unit_price'] ?? 0);
                $sub = (float)($qty * $price);
                // Asegurar que number_format reciba float (cast explícito)
                $html .= "<tr><td>{$title}</td><td>{$qty}</td><td>\$" . number_format((float)$price, 2, ',', '.') . "</td><td>\$" . number_format((float)$sub, 2, ',', '.') . "</td></tr>";
            }

            $html .= "<tr><td colspan='3' align='right' class='total'>Total</td><td class='total'>\$" . number_format((float)$total_compra, 2, ',', '.') . "</td></tr>";
            $html .= '</table></body></html>';

            // === RENDERIZAR PDF con opciones (soporte utf8 y remote images) ===
            try {
                $options = new Options();
                $options->set('isRemoteEnabled', true);
                $options->set('defaultFont', 'DejaVu Sans'); // fuente con soporte Unicode
                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($html);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();
                $output = $dompdf->output();
                $filename = $facturasDir . '/factura_' . $idCompra . '_' . time() . '.pdf';
                file_put_contents($filename, $output);
            } catch (\Throwable $pdfEx) {
                // no dejamos que un error en PDF rompa todo; lo logeamos
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - Error generando PDF: " . $pdfEx->getMessage() . PHP_EOL, FILE_APPEND);
                $filename = null;
            }

            // === ENVIAR EMAIL (si tenemos archivo) ===
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = $_ENV['SMTP_HOST'] ?? getenv('SMTP_HOST');
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['SMTP_USER'] ?? getenv('SMTP_USER');
                $mail->Password = $_ENV['SMTP_PASSWORD'] ?? getenv('SMTP_PASSWORD');
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = intval($_ENV['SMTP_PORT'] ?? getenv('SMTP_PORT') ?: 587);
                $mail->CharSet = 'UTF-8';
                $from = $_ENV['SMTP_USER'] ?? getenv('SMTP_USER');
                $mail->setFrom($from, 'Tienda Kuday Online');
                $mail->addAddress($email_cliente, $nombre_cliente . ' ' . $apellido_cliente);
                $mail->isHTML(true);
                $mail->Subject = "Comprobante de compra #{$idCompra} - Kuday Artesanías";
                $mail->Body = "<p>Hola " . htmlspecialchars($nombre_cliente) . ",</p><p>Adjuntamos tu comprobante de pago. ¡Gracias por tu compra!</p>";
                $mail->AltBody = "Hola " . $nombre_cliente . ", adjuntamos tu comprobante de pago. Gracias.";
                if (!empty($filename) && file_exists($filename)) {
                    $mail->addAttachment($filename);
                }
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