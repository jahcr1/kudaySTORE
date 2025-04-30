<?php
if (isset($_POST['provincia'])) {
    $provincia = $_POST['provincia'];

    // Simulación de costos de envío según provincia
    $costosEnvio = [
        "Buenos Aires" => 28500,   // Buenos Aires
        "Cordoba" => 23500,   // Córdoba
        "Santa Cruz" => 5000,   // Santa Cruz
        "Catamarca" => 26900,   // Catamarca
        "Chaco" => 28500,   // Chaco
        "Chubut" => 10500,   // Chubut
        "Corrientes" => 26500,   // Corrientes
        "Entre Rios" => 26500,   // Entre Rios
        "Formosa" => 27500,   // Formosa
        "Jujuy" => 26500,   // Jujuy
        "La Pampa" => 18500,   // La Pampa
        "La Rioja" => 25500,   // La Rioja
        "Mendoza" => 24500,   // Mendoza
        "Misiones" => 26500,   // Misiones
        "Neuquen" => 18500,   // Neuquén
        "Rio Negro" => 15500,   // Rio Negro
        "Salta" => 27500,   // Salta
        "San Juan" => 23500,   // San Juan
        "San Luis" => 20500,   // San Luis
        "Santa Fe" => 22500,   // Santa Fe
        "Santiago Del Estero" => 29500,   // Santiago Del Estero
        "Tierra Del Fuego" => 28000,   // Tierra Del Fuego
        "Tucuman" => 28500,   // Tucumán
        // Agregar más provincias con sus respectivos costos
    ];

    $costoEnvio = isset($costosEnvio[$provincia]) ? $costosEnvio[$provincia] : 10000;

    echo json_encode(["costoEnvio" => $costoEnvio]);
}
?>
