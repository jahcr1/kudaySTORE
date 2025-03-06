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

        $logoPath = '../images/logo/logo1.png'; // Ruta de la imagen en el servidor
        $type = pathinfo($logoPath, PATHINFO_EXTENSION);
        $data = file_get_contents($logoPath);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

        // Generar HTML para la factura
        ob_start();
?>
        <html>

        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                    color: #333;
                    margin: 0;
                    padding: 0;
                    border: 1px solid black;
                    border-collapse: collapse;
                }

                .header-comprados {
                    background: #ff69b4;
                    color: white;
                    padding: 10px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    height: 120px;
                    overflow: hidden;
                    border: 1px solid black;
                    border-collapse: collapse;
                }

                .logo-container {
                    display: flex;
                    align-items: center;
                    max-width: 200px;
                    max-height: 60px;
                }

                .header-comprados img.logo-comprado {
                    width: 100%;
                    max-height: 100%;
                    object-fit: contain;
                }

                .header-comprados .info {
                    text-align: right;
                    font-size: 12px;
                }

                .footer-comprados {
                    background: #add8e6;
                    /* Color celeste claro */
                    padding: 20px;
                    text-align: center;
                    font-size: 14px;
                    border: 1px solid black;
                    border-collapse: collapse;
                }

                /* Asegura que la primera fila esté centrada */
                .footer-comprados .row {
                    width: 100%;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    text-align: center;
                }

                /* Estilos para "Datos de pago:" */
                .footer-comprados .datos-pagos {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    margin-top: 10px;
                }

                /* Título "Datos de pago" centrado */
                .footer-comprados .datos-pagos>p {
                    font-size: 16px;
                    font-weight: bold;
                    margin-bottom: 10px;
                }

                .metodos-pago {
                    display: flex;
                    flex-direction: column;
                    justify-content: space-between;
                    gap: 20px; /* Espacio entre los bloques, si lo deseas */
                }

                /* Estilos de cada bloque (Mercado Pago y Datos Bancarios) */
                .metodos-pago > div {
                    flex: 1; /* Hace que cada bloque ocupe un espacio igual */
                    background: #ffffff;
                    padding: 15px;
                    border-radius: 5px;
                    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    /* Alinea el texto a la izquierda */
                }




                .container {
                    padding: 20px;
                }

                .productos-comprados {
                    margin-top: 10px;
                }
            </style>
        </head>

        <body>
            <div class="header-comprados">
                <div class="logo-container">
                    <img src="<?php echo $base64; ?>" alt="Logobase64" class="logo-comprado">
                </div>
                <div class="info">
                    <p>Fecha de emisión: <?php echo $fechaHoraCompra; ?></p>
                    <p>Tel: +54 297 4321 429 | Email: kudayartesanias@gmail.com | Dirección: General Aráoz de Lamadrid 425</p>
                </div>
            </div>
            <div class="container">
                <h2>Factura de Compra</h2>
                <p><strong>Cliente:</strong> <?php echo "$nombre $apellido"; ?></p>
                <p><strong>Teléfono:</strong> <?php echo $telefono; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
                <p><strong>Dirección:</strong> <?php echo "$direccion, $ciudad, $provincia."; ?></p>
                <p><strong>Código Postal:</strong> <?php echo $codigopostal; ?></p>
                <h3>Productos</h3>
                <ul class="productos-comprados">
                    <?php foreach ($productos_array as $producto): ?>
                        <li><?php echo $producto['name'] . " - Cantidad: " . $producto['cantidad'] . " - Precio: $" . $producto['price']; ?></li>
                    <?php endforeach; ?>
                </ul>
                <p><strong>Total:</strong> $<?php echo number_format($total, 2); ?></p>
                <p><strong>Fecha de la Compra:</strong> <?php echo $fechaHoraCompra; ?></p>
            </div>
            <div class="footer-comprados">
                <div class="row">
                    <p><strong>IMPORTANTE: Este comprobante de factura tiene validez por (7) días. Realizar el pago antes de la semana para garantizar su compra ya que tenemos Stock Limitado. En la brevedad nos comunicaremos con Ud.</strong></p>
                </div>
                <div class="row datos-pagos">
                    <p>Datos de pago:</p>
                </div>
                <table class="metodos-pago" style="width: 100%;">
                    <td style="width: 50%;">
                        <p><strong>Mercado Pago</strong></p>
                        <p>Daiana Rocío Quiroga</p>
                        <p>Alias: <?php echo getenv('ALIAS_MP'); ?></p>
                        <p>CVU: <?php echo getenv('CVU_MP'); ?></p>
                        <p>CUIT/CUIL: <?php echo getenv('CUITCUIL'); ?></p>
                    </td>
                    <td style="width: 50%;">
                        <p><strong>Datos Bancarios</strong></p>
                        <p>Daiana Rocío Quiroga</p>
                        <p>Cuenta Bancaria: <?php echo getenv('CUENTA_BANCARIA'); ?></p>
                        <p>CBU: <?php echo getenv('CBU'); ?></p>
                    </td>
                </table>
            </div>


        </body>

        </html>
<?php
        $html = ob_get_clean();

        // Configuración de Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true); // Habilitar HTML5
        $options->set('isRemoteEnabled', true); // Habilita carga remota de imágenes
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
            $mail->Host = getenv('SMTP_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = getenv('SMTP_USER');
            $mail->Password = getenv('SMTP_PASS');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom(getenv('SMTP_USER'), 'Tienda Kuday Online');
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
