<?php
if (isset($_POST['provincia'])) {
    $provincia = $_POST['provincia'];

    // Simulación de costos de envío según provincia
    $costosEnvio = [
        "1" => 500,   // Buenos Aires
        "2" => 700,   // Córdoba
        "3" => 900,   // Santa Cruz
        // Agregar más provincias con sus respectivos costos
    ];

    $costoEnvio = isset($costosEnvio[$provincia]) ? $costosEnvio[$provincia] : 1000;

    echo json_encode(["costoEnvio" => $costoEnvio]);
}
?>
