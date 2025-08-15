<?php
declare(strict_types=1);

// Zona horaria Argentina
date_default_timezone_set('America/Argentina/Buenos_Aires');

ini_set('display_errors', '1'); // en prod ponelo en 0
error_reporting(E_ALL);

require_once __DIR__ . '/componentes/conexion.php';
require_once __DIR__ . '/vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;
use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;

$logFile = __DIR__ . '/componentes/logs_errores_php.txt';

// === UTIL: log corto ===
function log_msg(string $msg) {
    global $logFile;
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - $msg\n", FILE_APPEND);
}

/**
 * === UTIL: parse_float (ya la tenías) ===
 * parse_float: limpia y convierte distintos formatos de string numérico a float.
 * Esto evita errores con number_format() cuando vienen strings con comas, puntos, símbolos, etc.
 */
function parse_float(mixed $val): float {
    if (is_float($val) || is_int($val)) return (float)$val;
    $s = trim((string)$val);
    if ($s === '') return 0.0;

    // quitar espacios NO separadores y caracteres no numéricos (salvo ,- .)
    $s = preg_replace('/[^\d\-,\.]/u', '', $s);

    // detectar si hay ambos separadores '.' y ','
    $lastDot = strrpos($s, '.');
    $lastComma = strrpos($s, ',');

    if ($lastDot !== false && $lastComma !== false) {
        // si la coma está después del punto, asumimos coma = decimal (1.234,56)
        if ($lastComma > $lastDot) { 
            $s = str_replace('.', '', $s);  // eliminar miles
            $s = str_replace(',', '.', $s); // convertir decimal
         } else {
            // punto está después -> 1,234.56 (coma miles, punto decimal)
            $s = str_replace(',', '', $s);
         }
    } elseif ($lastComma !== false && $lastDot === false) {
        // solo coma — probablemente decimal (e.g. "1234,56")
        $s = str_replace(',', '.', $s);
    }
    // finalmente casteamos
    return (float)$s;
}

try {
    // 1. Configurar Mercado Pago
    $mpAccessToken = $_ENV['MP_ACCESS_TOKEN'] ?? getenv('MP_ACCESS_TOKEN') ?: null;
    if (!$mpAccessToken) throw new Exception('MP access token no definido');
    MercadoPagoConfig::setAccessToken((string)$mpAccessToken);

    // 2. Leer body crudo y logearlo para debug
    $raw = file_get_contents('php://input');
    $input = json_decode($raw, true);
    log_msg("Webhook recibido: {$raw}");

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
        if (!empty($input['data']['id'])) $paymentId = $input['data']['id'];
        elseif (!empty($input['resource'])) {
            // Puede ser solo un número o una URL completa
            if (is_numeric($input['resource'])) $paymentId = $input['resource'];
            else $paymentId = basename(parse_url($input['resource'], PHP_URL_PATH));
        }
    }
    // Caso formato nuevo con 'type', acá entra por positivo 
    elseif (($input['type'] ?? '') === 'payment' && !empty($input['data']['id'])) {
        $paymentId = $input['data']['id'];
    } 
    // Si es merchant_order lo ignoramos (opcional)
    elseif (($input['topic'] ?? '') === 'merchant_order') {
        http_response_code(200);
        log_msg("Notificación merchant_order ignorada");
        exit;
    }

    // Si sigue sin ID, salir
    if (!$paymentId) {
        http_response_code(200);
        log_msg("webhook sin payment id");
        exit;
    }

    // 4. Recuperar información del pago desde la API
    $paymentClient = new PaymentClient();
    $payment = $paymentClient->get((int)$paymentId);
    $status = $payment->status ?? null;
    $externalReference = $payment->external_reference ?? null;

    if (!$externalReference) {
        log_msg("no se pudo ubicar external_reference para payment {$paymentId}");
        http_response_code(200);
        exit;
    }

    $idCompra = (int)$externalReference;
    if ($idCompra <= 0) {
        log_msg("external_reference inválido: {$externalReference}");
        http_response_code(200);
        exit;
    }

    // 5. Mapear estado MP → nuestro estado
    $map = [
        'approved'   => 'Aprobado',
        'authorized' => 'Aprobado',
        'paid'       => 'Aprobado',
        'pending'    => 'Pendiente',
        'in_process' => 'En proceso',
        'rejected'   => 'Rechazado',
        'cancelled'  => 'Rechazado',
    ];
    $nuevoEstado = $map[strval($status)] ?? (string)$status;

    // 6. Obtener datos de la compra
    $stmt = $conexion->prepare("SELECT productos_json, email_cliente, nombre_cliente, apellido_cliente, total, estado FROM compras WHERE id = ?");
    $stmt->bind_param('i', $idCompra);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
        log_msg("compra no encontrada: {$idCompra}");
        http_response_code(200);
        exit;
    }
    $row = $res->fetch_assoc();
    $stmt->close();

    $productos_json = $row['productos_json'];
    $email_cliente  = $row['email_cliente'];
    $nombre_cliente = $row['nombre_cliente'];
    $apellido_cliente = $row['apellido_cliente'];
    // sanitizar y castear total a float para evitar TypeError en number_format por PHP 8+ === 
    $total_compra   = parse_float($row['total'] ?? 0);
    $estadoActual   = (string)($row['estado'] ?? '');

    /*
    ──────────────────────────────────────────────────────────────
    === BLOQUE NUEVO: Concurrencia e idempotencia con TX y FOR UPDATE
    ──────────────────────────────────────────────────────────────
    Idea:
    - Si el pago NO está aprobado/autorizado/pagado → solo actualizamos estado y salimos.
    - Si está aprobado/autorizado/pagado → abrimos TRANSACTION, hacemos
      SELECT ... FOR UPDATE sobre la fila de compras (bloqueo de fila),
      rechecamos estado, descontamos stock, y recién ahí marcamos Aprobado y COMMIT.
      (PDF + mail después del commit, sin mantener el lock).
    */

    $aprobados = ['approved','authorized','paid'];

    if (!in_array(strval($status), $aprobados, true)) {
        // === Caso no aprobado: actualizar estado y salir (igual que antes)
        if ($estadoActual !== $nuevoEstado) {
            $stmtUpd = $conexion->prepare("UPDATE compras SET estado = ? WHERE id = ?");
            $stmtUpd->bind_param('si', $nuevoEstado, $idCompra);
            $stmtUpd->execute();
            $stmtUpd->close();
        }
        http_response_code(200);
        echo 'OK';
        exit;
    }

    // === Caso APROBADO/AUTHORIZED/PAID → proteger con transacción y bloqueo de fila
    $conexion->begin_transaction();

    // Bloqueamos la fila de compras para este id (evita carreras entre 2 webhooks)
    $stmtLock = $conexion->prepare("SELECT estado FROM compras WHERE id = ? FOR UPDATE");
    $stmtLock->bind_param('i', $idCompra);
    $stmtLock->execute();
    $resLock = $stmtLock->get_result();
    $lockRow = $resLock->fetch_assoc();
    $stmtLock->close();

    $estadoLock = (string)($lockRow['estado'] ?? '');

    if ($estadoLock === 'Aprobado') {
        // Ya se procesó (otra petición ganó la carrera)
        $conexion->commit(); // liberamos el lock
        log_msg("compra {$idCompra} ya procesada (detectado en lock)");
        http_response_code(200);
        echo 'OK';
        exit;
    }

    // Descontar stock dentro de la misma transacción
    $productos_array = json_decode($productos_json, true) ?: [];
    log_msg("Procesando compra {$idCompra} con productos: " . $productos_json);

    $ok = true;
    $stmtStock = $conexion->prepare("UPDATE productos SET stock = stock - ? WHERE id = ? AND stock >= ?");
    foreach ($productos_array as $p) {
        $prodId   = (int)($p['id'] ?? 0);
        $cantidad = (int)($p['cantidad'] ?? ($p['quantity'] ?? 0));
        log_msg("Intentando descontar producto {$prodId} cantidad {$cantidad}");
        if ($prodId <= 0 || $cantidad <= 0) continue;
        $stmtStock->bind_param('iii', $cantidad, $prodId, $cantidad);
        $stmtStock->execute();
        if ($stmtStock->affected_rows === 0) {
            $ok = false;
            log_msg("Stock insuficiente o producto inexistente (ID {$prodId})");
            break;
        }
    }
    $stmtStock->close();

    if ($ok) {
        // Marcamos Aprobado DENTRO de la transacción, junto con el stock
        $estadoAprobado = 'Aprobado';
        $stmtUpdOk = $conexion->prepare("UPDATE compras SET estado = ? WHERE id = ?");
        $stmtUpdOk->bind_param('si', $estadoAprobado, $idCompra);
        $stmtUpdOk->execute();
        $stmtUpdOk->close();

        // Listo: persistimos todo antes de PDF/email
        $conexion->commit();
    } else {
        // Revertimos cualquier cambio parcial de stock
        $conexion->rollback();

        // Fuera de la transacción, dejamos el estado en "Error stock"
        $estadoErr = 'Error stock';
        $stmtErr = $conexion->prepare("UPDATE compras SET estado = ? WHERE id = ?");
        $stmtErr->bind_param('si', $estadoErr, $idCompra);
        $stmtErr->execute();
        $stmtErr->close();

        http_response_code(200);
        echo 'OK';
        exit;
    }

    // === PDF (fuera de la transacción; el estado ya quedó "Aprobado")
    $facturasDir = __DIR__ . '/facturas';
    if (!is_dir($facturasDir)) { @mkdir($facturasDir, 0755, true); }

    $logoPath = __DIR__ . '/images/logo/logo1.png';
    $logoTag = '';
    if (file_exists($logoPath)) {
        $logoReal = realpath($logoPath);
        $logoSrc = 'file://' . $logoReal;
        $logoTag = '<img src="' . $logoSrc . '" style="max-height:80px;">';
    }

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
        $qty   = (int)($p['cantidad'] ?? ($p['quantity'] ?? 0));
        $price = parse_float($p['price'] ?? $p['unit_price'] ?? 0);
        $sub   = (float)($qty * $price);
        $html .= "<tr><td>{$title}</td><td>{$qty}</td><td>\$" . number_format((float)$price, 2, ',', '.') . "</td><td>\$" . number_format((float)$sub, 2, ',', '.') . "</td></tr>";
    }
    $html .= "<tr><td colspan='3' align='right' class='total'>Total</td><td class='total'>\$" . number_format((float)$total_compra, 2, ',', '.') . "</td></tr>";
    $html .= '</table></body></html>';

    try {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $output = $dompdf->output();
        $filename = $facturasDir . '/factura_' . $idCompra . '_' . time() . '.pdf';
        file_put_contents($filename, $output);
    } catch (\Throwable $pdfEx) {
        log_msg("Error generando PDF: " . $pdfEx->getMessage());
        $filename = null;
    }

    // === Email (con debug solo en local o si se fuerza por env)
    $appEnv = $_ENV['APP_ENV'] ?? getenv('APP_ENV') ?? 'production';
    $smtpDebugLevel = (int)($_ENV['SMTP_DEBUG'] ?? getenv('SMTP_DEBUG') ?? ($appEnv === 'local' ? 2 : 0));

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST'] ?? getenv('SMTP_HOST');
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USER'] ?? getenv('SMTP_USER');
        $mail->Password   = $_ENV['SMTP_PASSWORD'] ?? getenv('SMTP_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = (int)($_ENV['SMTP_PORT'] ?? getenv('SMTP_PORT') ?: 587);
        $mail->CharSet    = 'UTF-8';

        $from = $_ENV['SMTP_USER'] ?? getenv('SMTP_USER');
        $mail->setFrom($from, 'Tienda Kuday Online');
        $mail->addAddress($email_cliente, $nombre_cliente . ' ' . $apellido_cliente);
        $mail->isHTML(true);
        $mail->Subject = "Comprobante de compra #{$idCompra} - Kuday Artesanías";
        $mail->Body    = "<p>Hola " . htmlspecialchars($nombre_cliente) . ",</p><p>Adjuntamos tu comprobante de pago. ¡Gracias por tu compra!</p>";
        $mail->AltBody = "Hola " . $nombre_cliente . ", adjuntamos tu comprobante de pago. Gracias.";

        if (!empty($filename) && file_exists($filename)) {
            $mail->addAttachment($filename);
        }

        // Solo spamea si estás en local o lo forzás con SMTP_DEBUG
        $mail->SMTPDebug = $smtpDebugLevel;
        if ($smtpDebugLevel > 0) {
            $mail->Debugoutput = function($str, $level) use ($logFile) {
                file_put_contents($logFile, date('Y-m-d H:i:s') . " - SMTP Debug: $str\n", FILE_APPEND);
            };
        }

        $mail->send();
        log_msg("comprobante enviado a {$email_cliente} para compra {$idCompra}");
    } catch (\Throwable $e) {
        log_msg("Error enviando mail: " . ($e->getMessage() ?: 'sin detalle'));
    }

    http_response_code(200);
    echo 'OK';
    exit;

} catch (\Throwable $e) {
    log_msg("webhook ERROR: " . $e->getMessage());
    http_response_code(200);
    echo 'OK';
    exit;
}
