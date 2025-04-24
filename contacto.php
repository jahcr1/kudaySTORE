<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
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
            $mail->setFrom($_ENV['SMTP_USER'], 'Formulario de contacto');
            $mail->addAddress($_ENV['SMTP_USER']);          // destino interno
            $mail->addReplyTo($correo, "$nombre $apellido");
            $mail->Subject = "Contacto: $asunto";
            $body  = "<b>Nombre:</b> $nombre $apellido<br>";
            $body .= "<b>Email:</b> $correo<br><hr>";
            $body .= nl2br(htmlspecialchars($mensaje,ENT_QUOTES,'UTF-8'));
            $mail->isHTML(true);
            $mail->Body = $body;
            $mail->send();

            /*  Mail de cortesía al usuario  */
            $mail->clearAllRecipients();
            $mail->addAddress($correo);
            $mail->Subject = '¡Gracias por contactarnos!';
            $mail->Body    = "Hola $nombre 👋🏼,\n\nRecibimos tu mensaje y te responderemos a la brevedad.\n\nSaludos,\nKuday Artesanías.";
            $mail->isHTML(false);
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
  <title>Contacto | Kuday</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Birthstone&family=Poiret+One:wght@400;700&display=swap" rel="stylesheet">
  <style>
        body{
            font-family:"Poiret One",sans-serif;
            background:linear-gradient(135deg,#f796ab 0%,#f1dbeb 100%);
            min-height:100vh;display:flex;align-items:center;justify-content:center;
        }
        h1{font-family:"Birthstone",cursive;font-size:3.5rem;color:#fff;text-shadow:0 1px 2px #00000040;}
        .contact-card{
            max-width:540px;background:#fff;border-radius:1rem;padding:2.5rem;
            box-shadow:0 8px 25px rgba(0,0,0,.12);
            animation:fade 0.8s ease;
        }
        @keyframes fade{0%{transform:translateY(30px);opacity:0;}100%{opacity:1;}}
        .form-control:focus{border-color:#f796ab;box-shadow:0 0 0 .2rem #f796ab55;}
        .btn-kuday{
            background:linear-gradient(135deg,#f796ab,#f1dbeb);border:none;font-weight:700;
        }
        .btn-kuday:hover{transform:scale(1.03);}
        .alert{font-size:0.95rem;padding:.7rem 1rem;}
        /* honeypot oculto */
        .honeypot{display:none !important;}
  </style>
  <!-- reCAPTCHA -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="contact-card">
        <h1 class="text-center mb-4">¡Hablemos!</h1>

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
                <input type="text" name="website" class="honeypot">

                <div class="col-12 d-flex justify-content-center">
                    <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($_ENV['RECAPTCHA_SITE_KEY']) ?>"></div>
                </div>

                <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn btn-kuday px-5 py-2">Enviar</button>
                </div>
            </div>
        </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
