<?php
session_start();

require_once __DIR__ . '/../config.php';

$usuario_session = $_POST['usuario-admin'];
$password_session = $_POST['pass-admin'];

if ($usuario_session == $_ENV['PAN_USER'] && $password_session == $_ENV['PAN_PASS']) {
  $_SESSION['administrador'] = $usuario_session;
  header("Location: ../panel.php?success#session-adm");
} else {
  header("Location: ../panel.php?error#msj-session");
  
}

?>