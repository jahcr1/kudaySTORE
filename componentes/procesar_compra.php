    <?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    ob_start(); // Inicia el buffer de salida para evitar problemas con el JSON

    require_once 'conexion.php';
    require_once '../vendor/autoload.php'; // Cargar Dompdf

    use Dompdf\Dompdf;
    use Dompdf\Options;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Limpiar el buffer de salida
        ob_end_clean();
        header('Content-Type: application/json');
        $response = [];

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
            $costoEnvio = floatval($_POST['costoEnvio'] ?? 0);
            $subtotal = $total - $costoEnvio;


            // Decodificar el email en caso de que haya codificación
            $email = urldecode($email);  // Decodificamos el email

            // Validación básica
            if (!$nombre || !$apellido || !$telefono || !$email || !$direccion || !$provincia || !$ciudad || !$codigopostal || empty($productos) || $total <= 0 || $costoEnvio < 0) {
                throw new Exception("Datos incompletos o incorrectos o negativos.");
            }

            // Decodificar los productos
            $productos_array = json_decode($productos, true);
            if (!is_array($productos_array)) {
                throw new Exception("Formato de productos incorrecto.");
            }

            $productos_json = json_encode($productos_array, JSON_UNESCAPED_UNICODE);

            // Insertar la compra en la base de datos
            $estado = 'Pendiente'; // Valor por defecto

            $stmt = $conexion->prepare("INSERT INTO compras (nombre_cliente, apellido_cliente, telefono_cliente, email_cliente, direccion, provincia, ciudad, codigopostal, productos_json, total, estado, fecha_compra) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("sssssssssds", $nombre, $apellido, $telefono, $email, $direccion, $provincia, $ciudad, $codigopostal, $productos_json, $total, $estado);

            $stmt->execute();

            if ($stmt->error) {
                throw new Exception("Error en la consulta: " . $stmt->error);
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

                    .container {
                        padding: 20px;
                    }

                    .productos-comprados {
                        margin-top: 10px;
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
                        position: fixed;
                        bottom: 0;
                        background: rgb(243, 165, 217);
                        padding: 20px;
                        text-align: center;
                        font-size: 14px;
                        border: 1px solid #000;
                        border-collapse: collapse;

                    }

                    /* Asegura que la primera fila esté centrada */
                    .footer-comprados .row {
                        display: block;
                        text-align: center;
                    }

                    /* Estilos para "Datos de pago:" */
                    .footer-comprados .datos-pagos {
                        margin-top: 10px;
                    }

                    /* Título "Datos de pago" centrado */
                    .footer-comprados div.datos-pagos>p {
                        font-size: 16px;
                        text-align: left;
                        font-weight: bold;
                        margin-bottom: 10px;
                    }

                    table.metodos-pago {
                        width: 100%;
                        border: 1px solid #000;
                        border-collapse: collapse;
                    }

                    thead>tr>th {
                        font-size: 14px;
                        border: 1px solid #000;
                        background-color: #cccccc;
                        padding: 10px;
                    }

                    tbody {
                        border: 1px solid #000;
                        background: #ffffff;
                    }

                    td {
                        border: 1px solid #000;
                        padding: 10px;
                        vertical-align: top;
                        text-align: left;
                    }

                    td>p {
                        text-align: center;
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
                    <p><strong>Subtotal:</strong> $<?php echo number_format($subtotal, 2); ?></p>
                    <p><strong>Costo de Envío:</strong> $<?php echo number_format($costoEnvio, 2); ?></p>
                    <p><strong>Total:</strong> $<?php echo number_format($total, 2); ?></p>

                    <p><strong>Fecha de la Compra:</strong> <?php echo $fechaHoraCompra; ?></p>
                </div>
                <div class="footer-comprados">
                    <div class="row">
                        <p><strong>IMPORTANTE: Este comprobante de factura tiene validez por (7) días. Realizar el pago antes de la semana para garantizar su compra ya que tenemos Stock Limitado. En la brevedad nos comunicaremos con Ud.</strong></p>
                    </div>
                    <div class="datos-pagos">
                        <p>Datos para realizar el pago</p>
                    </div>
                    <div>
                        <table class="metodos-pago">
                            <thead>
                                <tr>
                                    <th>Mercado Pago</th>
                                    <th>Datos Bancarios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <p><strong>Daiana Rocío Quiroga</strong></p>
                                        <p><strong>Alias:</strong> <?php echo $_ENV['ALIAS_MP']; ?></p>
                                        <p><strong>CVU:</strong> <?php echo $_ENV['CVU_MP']; ?></p>
                                        <p><strong>CUIT/CUIL:</strong> <?php echo $_ENV['CUITCUIL']; ?></p>
                                    </td>
                                    <td>
                                        <p><strong>Daiana Rocío Quiroga</strong></p>
                                        <p><strong>Cuenta Bancaria:</strong> <?php echo $_ENV['CUENTA_BANCARIA']; ?></p>
                                        <p><strong>CBU:</strong> <?php echo $_ENV['CBU']; ?></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </body>

            </html>
    <?php
            $html = ob_get_clean();


            // Configuración de Dompdf
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true); // Habilitar HTML5
            $options->set("isPhpEnabled", true);
            $options->set('isRemoteEnabled', true); // Habilita carga remota de imágenes
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            //Guardar pdf
            $pdfOutput = $dompdf->output();

            // Comprobar si el contenido del PDF es válido
            if (empty($pdfOutput)) {
                die("Error: DomPDF no generó contenido.");
            }

            $pdfPath = "../facturas/factura_" . time() . ".pdf";
            file_put_contents($pdfPath, $pdfOutput);



            // Enviar correo con PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = $_ENV['SMTP_HOST'];
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['SMTP_USER'];
                $mail->Password = $_ENV['SMTP_PASSWORD'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;
                $mail->CharSet = 'UTF-8';
                $mail->setFrom($_ENV['SMTP_USER'], 'Tienda Kuday Online');
                $mail->addAddress($email, "$nombre $apellido");
                $mail->Subject = 'Confirmación de Compra';
                $mail->Body = "Gracias por tu compra, $nombre. Adjuntamos tu factura con los datos para realizar el pago en PDF.";
                $mail->addAttachment($pdfPath);
                $mail->send();
            } catch (Exception $e) {
                throw new Exception("Error al enviar el correo: " . $mail->ErrorInfo);
            }

            // Limpiar carrito de la sesión si la compra fue exitosa
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            unset($_SESSION['carrito']);
            unset($_SESSION['cartCount']);
            session_destroy();


            // Ejemplo de respuesta exitosa
            $response = [
                'success' => true,
                'message' => 'Compra procesada con éxito',
                'pdfUrl' => "descargar_pdf.php?file=" . urlencode(basename($pdfPath))
            ];
        } catch (Exception $e) {
            $response = ['success' => false, 'message' => $e->getMessage()];
        }
        echo json_encode($response);
    }
    ?>