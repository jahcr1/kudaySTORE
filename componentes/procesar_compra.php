<?php
require_once 'conexion.php';
require_once '../vendor/autoload.php'; // Cargar Dompdf
use Dompdf\Dompdf;
use Dompdf\Options;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Recibir datos del formulario
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $direccion = trim($_POST['direccion'] ?? '');
        $provincia = trim($_POST['provincia'] ?? '');
        $ciudad = trim($_POST['ciudad'] ?? '');
        $codigopostal = trim($_POST['codigopostal'] ?? '');
        $productos = $_POST['productos'] ?? '[]';
        $total = floatval($_POST['total'] ?? 0);

        // Validación básica
        if (!$nombre || !$apellido || !$telefono || !$email || !$direccion || !$provincia || !$ciudad || !$codigopostal || empty($productos) || $total <= 0) {
            throw new Exception("Datos incompletos o incorrectos.");
        }

        // Decodificar los productos
        $productos_array = json_decode($productos, true);
        if (!is_array($productos_array)) {
            throw new Exception("Formato de productos incorrecto.");
        }

        $productos_json = json_encode($productos_array, JSON_UNESCAPED_UNICODE);

        // Insertar la compra en la base de datos
        $stmt = $conexion->prepare("INSERT INTO compras (nombre_cliente, apellido_cliente, telefono_cliente, email_cliente, direccion, provincia, ciudad, codigopostal, productos_json, total, fecha_compra) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssssssssd", $nombre, $apellido, $telefono, $email, $direccion, $provincia, $ciudad, $codigopostal, $productos_json, $total);
        $stmt->execute();

        if ($stmt->error) {
            echo "Error en la consulta: " . $stmt->error;
        }

        if ($stmt->affected_rows <= 0) {
            throw new Exception("Error al registrar la compra.");
        }

        // Para mostrar fecha y hora
        date_default_timezone_set('America/Argentina/Buenos_Aires');

        $fechaHoraCompra = date("d/m/Y H:i:s"); // Para mostrar fecha y hora

        // Generar HTML para la factura
        ob_start();
?>
        <html>

        <body>
            <h2>Factura de Compra</h2>
            <p><strong>Cliente:</strong> <?php echo "$nombre $apellido"; ?></p>
            <p><strong>Teléfono:</strong> <?php echo $telefono; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>Dirección:</strong> <?php echo "$direccion, $ciudad, $provincia."; ?></p>
            <p><strong>Código Postal:</strong> <?php echo $codigopostal; ?></p>
            <h3>Productos</h3>
            <ul>
                <?php foreach ($productos_array as $producto): ?>
                    <li><?php echo $producto['name'] . " - Cantidad: " . $producto['cantidad'] . " - Precio: $" . $producto['price']; ?></li>
                <?php endforeach; ?>
            </ul>
            <p><strong>Total:</strong> $<?php echo number_format($total, 2); ?></p>
            <p><strong>Fecha de la Compra:</strong> <?php echo $fechaHoraCompra; ?></p> <!-- Agregar la fecha aquí -->
        </body>

        </html>
<?php
        $html = ob_get_clean();

        // Configuración de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true); // Habilitar HTML5
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfOutput = $dompdf->output();
        $pdfPath = "../facturas/factura_" . time() . ".pdf";
        file_put_contents($pdfPath, $pdfOutput);

        // Enviar correo con PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.tudominio.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tuemail@tudominio.com';
            $mail->Password = 'tucontraseña';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom('tuemail@tudominio.com', 'Tienda Online');
            $mail->addAddress($email, "$nombre $apellido");
            $mail->Subject = 'Confirmación de Compra';
            $mail->Body = "Gracias por tu compra, $nombre. Adjuntamos tu factura en PDF.";
            $mail->addAttachment($pdfPath);
            $mail->send();
        } catch (Exception $e) {
            throw new Exception("Error al enviar el correo: " . $mail->ErrorInfo);
        }

        echo json_encode(["success" => true, "message" => "Compra registrada y correo enviado con éxito."]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
