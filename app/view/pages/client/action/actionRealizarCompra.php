<?php
require_once '../../../../../config.php';
header('Content-Type: application/json');
$response = array('respuesta' => false);

$data = darDatosSubmitted();

if (isset($data['idproducto'])) {
    $compra = new AbmCompra();
    if ($compra->realizarCompra()) {
        $response['respuesta'] = true;
        $response['mensaje'] = 'Compra confirmada';
    } else {
        $response['mensaje'] = 'Error al confirmar la compra';
    }
} else {
    $response['mensaje'] = 'Datos incompletos';
}

// if (isset($data['limpiar'])) {
//     $session->setCarritoSession([]);
//     $response['respuesta'] = true;
//     $response['mensaje'] = 'Carrito limpiado';
// }

echo json_encode($response);
