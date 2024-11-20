<?php

require_once '../../../../config.php';

$sesion = new Session();
$response = [];

if ($sesion->validar()) {
    $sesion->cerrar();
    $response = [
        'success' => true,
        'message' => 'Sesión cerrada correctamente.'
    ];
} else {
    $response = [
        'success' => false,
        'message' => 'No hay sesión activa para cerrar.'
    ];
}

// Retornar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
