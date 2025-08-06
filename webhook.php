<?php
require_once 'conexion.php';
require './vendor/autoload.php';

MercadoPago\SDK::setAccessToken('TU_ACCESS_TOKEN');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents("php://input");
    $event = json_decode($input, true);

    if ($event['type'] === 'payment') {
        $payment_id = $event['data']['id'];
        $payment = MercadoPago\Payment::find_by_id($payment_id);

        if ($payment->status === 'approved') {
            $emailComprador = $payment->payer->email;

            // Buscar compra pendiente
            $stmt = $conexion->prepare("SELECT * FROM compras WHERE email_cliente = ? AND estado = 'Pendiente' ORDER BY id DESC LIMIT 1");
            $stmt->bind_param("s", $emailComprador);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $compra = $result->fetch_assoc();
                $id_compra = $compra['id'];
                $productos = json_decode($compra['productos_json'], true);

                // 1. Actualizar estado
                $conexion->prepare("UPDATE compras SET estado = 'Confirmada' WHERE id = ?")->bind_param("i", $id_compra)->execute();

                // 2. Restar stock
                foreach ($productos as $producto) {
                    $id_prod = intval($producto['id']);
                    $cantidad = intval($producto['cantidad']);
                    $conexion->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?")->bind_param("ii", $cantidad, $id_prod)->execute();
                }

                // 3. Enviar PDF y correo
                // 🔁 Copiar aquí la lógica de DomPDF y PHPMailer de tu archivo original (lo hacemos si querés en el siguiente paso)
            }
        }
    }
}
http_response_code(200);
