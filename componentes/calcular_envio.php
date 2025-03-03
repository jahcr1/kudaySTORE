<?php
if (isset($_POST['provincia'])) {
    $provincia = $_POST['provincia'];

    // Simulación de costos de envío según provincia
    $costosEnvio = [
        "Buenos Aires" => 500,   // Buenos Aires
        "Cordoba" => 700,   // Córdoba
        "Santa Cruz" => 900,   // Santa Cruz
        "Catamarca" => 900,   // Catamarca
        "Chaco" => 900,   // Chaco
        "Chubut" => 900,   // Chubut
        "Corrientes" => 900,   // Corrientes
        "Entre Rios" => 900,   // Entre Rios
        "Formosa" => 900,   // Formosa
        "Jujuy" => 900,   // Jujuy
        "La Pampa" => 900,   // La Pampa
        "La Rioja" => 900,   // La Rioja
        "Mendoza" => 900,   // Mendoza
        "Misiones" => 900,   // Misiones
        "Neuquen" => 900,   // Neuquén
        "Rio Negro" => 900,   // Rio Negro
        "Salta" => 900,   // Salta
        "San Juan" => 900,   // San Juan
        "San Luis" => 900,   // San Luis
        "Santa Fe" => 900,   // Santa Fe
        "Santiago Del Estero" => 900,   // Santiago Del Estero
        "Tierra Del Fuego" => 900,   // Tierra Del Fuego
        "Tucuman" => 900,   // Tucumán
        // Agregar más provincias con sus respectivos costos
    ];

    $costoEnvio = isset($costosEnvio[$provincia]) ? $costosEnvio[$provincia] : 1000;

    echo json_encode(["costoEnvio" => $costoEnvio]);
}
?>
