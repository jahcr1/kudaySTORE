<?php
session_start();
$usuario_session = $_POST['usuario-admin'];
$password_session = $_POST['pass-admin'];

if ($usuario_session == 'dai' && $password_session == 'dai123') {
  $_SESSION['administrador'] = $usuario_session;
  header("Location: ../panel.php?success#session-adm");
} else {
  header("Location: ../panel.php?error#msj-session");
  
}

?>