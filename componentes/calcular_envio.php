<?php
if (isset($_POST['provincia'])) {
    $provincia = $_POST['provincia'];

    // Simulación de costos de envío según provincia
    $costosEnvio = [
        "1" => 500,   // Buenos Aires
        "2" => 700,   // Córdoba
        "3" => 900,   // Santa Cruz
        "4" => 900,   // Catamarca
        "5" => 900,   // Chaco
        "6" => 900,   // Chubut
        "7" => 900,   // Corrientes
        "8" => 900,   // Entre Rios
        "9" => 900,   // Formosa
        "10" => 900,   // Jujuy
        "11" => 900,   // La Pampa
        "12" => 900,   // La Rioja
        "13" => 900,   // Mendoza
        "14" => 900,   // Misiones
        "15" => 900,   // Neuquén
        "16" => 900,   // Rio Negro
        "17" => 900,   // Salta
        "18" => 900,   // San Juan
        "19" => 900,   // San Luis
        "20" => 900,   // Santa Fe
        "21" => 900,   // Santiago Del Estero
        "22" => 900,   // Tierra Del Fuego
        "23" => 900,   // Tucumán
        // Agregar más provincias con sus respectivos costos
    ];

    $costoEnvio = isset($costosEnvio[$provincia]) ? $costosEnvio[$provincia] : 1000;

    echo json_encode(["costoEnvio" => $costoEnvio]);
}
?>
