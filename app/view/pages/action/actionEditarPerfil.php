<?php

header('Content-Type: application/json');

require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';

$datos = darDatosSubmitted();
$response = [
    'success' => false,
    'message' => 'Hubo un error al procesar la solicitud.'
];
if (isset($datos)) {
    $objAbmUsuario = new AbmUsuario();
    $resp = $objAbmUsuario->modificarUsuario();

    if ($resp !== false) {
        $response['success'] = true;
        $response['message'] = "Los datos han sido actualizados correctamente";
    } else {
        $response['message'] = $resp;
    }
}

echo json_encode($response);
