<?php
if (isset($_GET['file'])) {
    $file = basename($_GET['file']); // Evita rutas maliciosas
    $filePath = __DIR__ . "/facturas/" . $file;

    if (file_exists($filePath)) {
        // Configurar encabezados para la descarga
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $file . '"');
        readfile($filePath);
        exit;
    } else {
        die("Error: El archivo no existe.");
    }
} else {
    die("Error: No se especificó ningún archivo.");
}
?>
