<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';

$sesion = Session::getInstance();
$response = [];

if ($sesion->validar()) {
    $sesion->cerrar();
    $response = [
        'success' => true,
        'message' => 'Sesión cerrada correctamente.'
    ];
    // header('Location: ' . BASE_URL . 'app/view/home/home.php');
    // exit();
} else {
    $response = [
        'success' => false,
        'message' => 'No hay sesión activa para cerrar.'
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
