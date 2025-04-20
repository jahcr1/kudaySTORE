<?php
if (isset($_POST['provincia'])) {
    $provincia = $_POST['provincia'];

    // Simulación de costos de envío según provincia
    $costosEnvio = [
        "Buenos Aires" => 8500,   // Buenos Aires
        "Cordoba" => 3500,   // Córdoba
        "Santa Cruz" => 10500,   // Santa Cruz
        "Catamarca" => 6900,   // Catamarca
        "Chaco" => 10500,   // Chaco
        "Chubut" => 9500,   // Chubut
        "Corrientes" => 6500,   // Corrientes
        "Entre Rios" => 6500,   // Entre Rios
        "Formosa" => 7500,   // Formosa
        "Jujuy" => 6500,   // Jujuy
        "La Pampa" => 6500,   // La Pampa
        "La Rioja" => 5500,   // La Rioja
        "Mendoza" => 6500,   // Mendoza
        "Misiones" => 6500,   // Misiones
        "Neuquen" => 8500,   // Neuquén
        "Rio Negro" => 8500,   // Rio Negro
        "Salta" => 7500,   // Salta
        "San Juan" => 6500,   // San Juan
        "San Luis" => 6500,   // San Luis
        "Santa Fe" => 6500,   // Santa Fe
        "Santiago Del Estero" => 9500,   // Santiago Del Estero
        "Tierra Del Fuego" => 11000,   // Tierra Del Fuego
        "Tucuman" => 7500,   // Tucumán
        // Agregar más provincias con sus respectivos costos
    ];

    $costoEnvio = isset($costosEnvio[$provincia]) ? $costosEnvio[$provincia] : 10000;

    echo json_encode(["costoEnvio" => $costoEnvio]);
}
?>
