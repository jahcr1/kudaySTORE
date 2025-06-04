<?php
session_start();
$cartCount = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;

require_once './componentes/conexion.php';           // para cargar dotenv y tener $_ENV
require_once 'vendor/autoload.php';    // PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$successMsg = $errorMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /* ---------- 1.  Sanitizar & validar ---------- */
    $nombre   = trim($_POST['nombre']   ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $correo   = trim($_POST['correo']   ?? '');
    $asunto   = trim($_POST['asunto']   ?? '');
    $mensaje  = trim($_POST['mensaje']  ?? '');
    $website  = $_POST['website'] ?? '';           // honeypot

    if ($website !== '') {                       // bot atrapado
        $errorMsg = 'Envío inválido.';
    }

    // reCAPTCHA
    if (!$errorMsg) {
        $token = $_POST['g-recaptcha-response'] ?? '';
        $resp  = file_get_contents(
            "https://www.google.com/recaptcha/api/siteverify?secret="
            . urlencode($_ENV['RECAPTCHA_SECRET_KEY'])
            . "&response=" . urlencode($token)
        );
        $resp = json_decode($resp,true);
        if (!$resp['success']) $errorMsg = 'Captcha no verificado.';
    }

    // Validaciones básicas
    if (!$errorMsg && (!filter_var($correo,FILTER_VALIDATE_EMAIL) || !$nombre || !$asunto || !$mensaje)) {
        $errorMsg = 'Completa todos los campos correctamente.';
    }

    /* ---------- 2.  Enviar mail ---------- */
    if (!$errorMsg) {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST']; // Servidor Gmail
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USER']; // Correo kuday
            $mail->Password   = $_ENV['SMTP_PASSWORD']; // Contraseña de aplicacion
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';

            /*  Mail a la tienda  */
            $mail->setFrom($_ENV['SMTP_USER'], 'Formulario Web'); // Quien envia, tiene q coincidir USER
            $mail->addAddress($_ENV['SMTP_USER']);          // A mi propio mail
            $mail->addReplyTo($correo, "$nombre $apellido");
            $mail->Subject = "Nuevo mensaje de contacto: $nombre";
            // Correo en HTML
            $mail->isHTML(true);
            $mail->Body = "
                <h2>Nuevo mensaje de sección Contacto</h2>
                <p><strong>Nombre:</strong> {$nombre}</p>
                <p><strong>Email:</strong> {$correo}</p>
                <p><strong>Asunto:</strong> {$asunto}</p>
                <hr>
                <p><strong>Mensaje:</strong><br>" . nl2br(htmlspecialchars($mensaje)) . "</p>";
            // Versión en texto plano
            $mail->AltBody = "Nombre: $nombre\nEmail: $correo\nAsunto: $asunto\n\nMensaje:\n$mensaje";
            $mail->send();

            /*  Mail de cortesía al Visitante  */
            $mail->clearAllRecipients();
            $mail->setFrom($_ENV['SMTP_USER'], 'Kuday'); // Desde tu correo
            $mail->addAddress($correo); // Al mail del visitante
            $mail->addReplyTo($_ENV['SMTP_USER'], 'Kuday'); // A mi como respuesta
            
            $mail->Subject = "Gracias por contactarnos, $nombre 🙌🏼";
            $mail->isHTML(true);
            $mail->Body = "
                <p>Hola <strong>$nombre</strong> 👋🏼,</p>
                <p>Recibí tu mensaje y en breve te estaré respondiendo. Gracias por tomarte el tiempo de escribirme.</p>
                <hr>
                <p><strong>Este fue tu mensaje:</strong><br>" . nl2br(htmlspecialchars($mensaje)) . "</p>
                <br>
                <p>Saludos,<br><strong>Daiana de Kuday Artesanias</strong></p>
            ";
            $mail->AltBody = "Hola $nombre,\n\nRecibí tu mensaje:\n\n$mensaje\n\nGracias por escribir.\n\nEquipo Kuday";
            $mail->send();

            $successMsg = '¡Mensaje enviado correctamente! 😀';
        } catch (Exception $e) {
            $errorMsg = 'No se pudo enviar el mensaje. Intenta más tarde.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon estándar -->
    <link rel="icon" type="image/png" sizes="512x512" href="images/favicon/favicon-512x512-transparent.png">

    <!-- Manifest para navegadores que lo usen -->
    <link rel="manifest" href="images/favicon/site-transparent.webmanifest">

    <title>Contacto | Kuday</title>

    <!-- FAMILIAS TIPOGRAFICAS DE GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Birthstone&family=Delius+Unicase:wght@400;700&family=Fuzzy+Bubbles:wght@400;700&family=Gwendolyn:wght@400;700&family=Homemade+Apple&family=Just+Me+Again+Down+Here&family=Kablammo&family=Klee+One&family=Ms+Madi&family=Mystery+Quest&family=Pacifico&family=Playwrite+IT+Moderna:wght@100..400&family=Poiret+One&family=Teko:wght@300..700&family=Unkempt:wght@400;700&family=Vibur&family=Yomogi&display=swap" rel="stylesheet">

    <!-- ICONOS DE BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- ICONOS DE FONTAWESOME -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" rel="stylesheet">

    <!-- CSS DE BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- CSS PROPIO-->
    <link rel="stylesheet" href="./CSS/styles.css">

    <!-- reCAPTCHA v2 Google -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body id="contacto">
    <header>
        <nav class="navbar navbar-expand-xl index-nav fixed-top">
            <div class="container-fluid" style="flex-wrap: wrap;">
                <a class="navbar-brand d-flex align-items-center brand-logo" href="index.php#inicio">
                <!-- Logo como imagen SVG -->
                <img src="images/logo/logo.png" alt="Kuday Artesanías" class="logo-img" />
                <span class="logo-text">Kuday Artesanias</span>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 700px; margin-right:50px;">
                    <li class="nav-item">
                    <a class="nav-link active boton-nav" href="contacto.php#contact-form">Inicio</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active boton-nav" aria-current="page" href="index.php#titulo_tienda">Tienda</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active boton-nav" aria-current="page" href="#seccion_footer">Quiénes Somos</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active boton-nav" href="./contacto.php" target="_blank">Contactános</a>
                    </li>
                    <li class="nav-item cart-item">
                    <a href="./carrito.php" class="cart-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-cart">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a1 1 0 0 0 1 .86h9.72a1 1 0 0 0 1-.76l2.54-9.24a1 1 0 0 0-.96-1.24H5.21"></path>
                        </svg>
                        <span id="cart-count"><?php echo $cartCount; ?></span>
                    </a>
                    </li>

                </ul>
                </div>
            </div>
        </nav>
    </header>

    <section id="contact-form" class="container" >
        <div class="contact-card">
            <h1 class="text-center mb-4 titulo-contacto">¡Hablemos!</h1>

            <?php if($successMsg): ?>
                <div class="alert alert-success"><?= $successMsg;?></div>
            <?php elseif($errorMsg): ?>
                <div class="alert alert-danger"><?= $errorMsg;?></div>
            <?php endif; ?>

            <form method="POST" novalidate>
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="apellido" placeholder="Apellido" required>
                    </div>
                    <div class="col-12">
                        <input type="email" class="form-control" name="correo" placeholder="Correo electrónico" required>
                    </div>
                    <div class="col-12">
                        <input type="text" class="form-control" name="asunto" placeholder="Asunto" required>
                    </div>
                    <div class="col-12">
                        <textarea class="form-control" name="mensaje" rows="5" placeholder="Tu mensaje..." required></textarea>
                    </div>

                    <!-- Honeypot -->
                    <input type="text" name="website" class="honeypot" autocomplete="off" aria-hidden="true">

                    <div class="col-12 d-flex justify-content-center">
                        <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($_ENV['RECAPTCHA_SITE_KEY']) ?>"></div>
                    </div>

                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="btn btn-kuday px-5 py-2">Enviar</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <footer class="footer" id="seccion_footer">
        <main class="container-fluid">
        <div class="row contenedor_footer align-items-center">

            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-10 p-2 pb-5">

            <h6 class="h6-footer"><i class="bi bi-tencent-qq pinguin"></i> CONTÁCTANOS</h6>
            <div class="box_1">
                <p class="p-footer"><i class="bi bi-envelope-at correo"></i>kudayartesanias@gmail.com</p>
                <p class="p-footer"><i class="bi bi-whatsapp wsp"></i> +54 9 0297 432-1429</p>
                <p class="p-footer"><i class="bi bi-geo-alt-fill ubic"></i> Gral. Araóz de Lamadrid 425</p>

                <!-- Mini mapa responsive -->
                <div class="map-container">
                <a
                    href="https://www.google.com/maps?q=-31.409736861796983,-64.16100064468557&z=17"
                    target="_blank"
                    title="Abrir ubicación en Google Maps">
                    <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3664.3467339192976!2d-64.16100064468557!3d-31.409736861796983!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0:0x0!2z-31.409736861796983_-64.16100064468557!5e0!3m2!1sen!2sar!4v1696990000000"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
                </a>
                </div>
            </div>
            </div>

            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-8 p-2">

            <h6 class="h6-footer"><i class="bi bi-tencent-qq pinguin"></i> MEDIOS DE PAGO</h6>
            <div class="contenedor-cards p-2">
                <img src="./images/cards/visa.png" alt="mp">
                <img src="./images/cards/naranja.png" alt="visa">
                <img src="./images/cards/mercadopago2.png" alt="visa">
                <img src="./images/cards/pagofacil.png" alt="visa">
                <img src="./images/cards/efectivo.png" alt="visa">
                <img src="./images/cards/rapipago.png" alt="">
            </div>

            <h6 class="h6-footer"><i class="bi bi-tencent-qq pinguin"></i> FORMAS DE ENVIO</h6>
            <div class="contenedor-cards p-2">
                <img src="./images/cards/andreani.png" alt="">
                <img src="./images/cards/correoarg.png" alt="">
            </div>

            <h6 class="h6-footer" style="text-wrap: wrap!important;"><i class="bi bi-tencent-qq pinguin"></i> SEGUINOS EN NUESTRAS REDES!</h6>
            <div class="redes-icons-footer">
                <a href="https://www.facebook.com/dai.quiroga.7" target="_blank"><i class="bi bi-facebook fb"></i></a>
                <a href="https://www.facebook.com/dai.quiroga.7" target="_blank"><i class="bi bi-instagram ig"></i></a>
                
            </div>
            </div>

        </div>
        </main>

        <p style="font-size:10px;background-color:white; color:black;width:100%;padding:0 5px;"><i class="bi bi-c-circle"></i> 2021 Kuday Artesanias & jahcr1. Todos los derechos reservados.</p>

    </footer>

    <!-- Incluyendo BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
