<?php
if (isset($_POST['provincia'])) {
    $provincia = $_POST['provincia'];

    // Simulación de costos de envío según provincia
    $costosEnvio = [
        "Buenos Aires" => 15500,   // Buenos Aires
        "Cordoba" => 8500,   // Córdoba
        "Santa Cruz" => 18500,   // Santa Cruz
        "Catamarca" => 16900,   // Catamarca
        "Chaco" => 18500,   // Chaco
        "Chubut" => 18500,   // Chubut
        "Corrientes" => 16500,   // Corrientes
        "Entre Rios" => 16500,   // Entre Rios
        "Formosa" => 17500,   // Formosa
        "Jujuy" => 18500,   // Jujuy
        "La Pampa" => 18500,   // La Pampa
        "La Rioja" => 15500,   // La Rioja
        "Mendoza" => 16500,   // Mendoza
        "Misiones" => 18500,   // Misiones
        "Neuquen" => 18500,   // Neuquén
        "Rio Negro" => 18500,   // Rio Negro
        "Salta" => 17500,   // Salta
        "San Juan" => 15500,   // San Juan
        "San Luis" => 16500,   // San Luis
        "Santa Fe" => 16500,   // Santa Fe
        "Santiago Del Estero" => 18500,   // Santiago Del Estero
        "Tierra Del Fuego" => 28000,   // Tierra Del Fuego
        "Tucuman" => 18500,   // Tucumán
        // Agregar más provincias con sus respectivos costos
    ];

    $costoEnvio = isset($costosEnvio[$provincia]) ? $costosEnvio[$provincia] : 10000;

    echo json_encode(["costoEnvio" => $costoEnvio]);
}
