<?php
session_start();

// Verifica si el usuario es un administrador antes de cerrar la sesión
if (isset($_SESSION['administrador'])) {
    // Destruye todas las variables de sesión
    session_unset();

    // Destruye la sesión
    session_destroy();

    // Redirige a la página de inicio o a donde desees
    header("Location: ../panel.php");
    exit();
} else {
    // Si no es administrador, redirige a una página de acceso restringido o login
    header("Location: ../index.php");
    exit();
}
?>