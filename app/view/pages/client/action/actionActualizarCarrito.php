<?php
require_once '../../../../../config.php';

header('Content-Type: application/json');

$datos = darDatosSubmitted();

if (isset($datos)) {
    $abmCarrito = new AbmCarrito;
    $param = [
        'idproducto' => $datos['idproducto'],
        'cantidad' => $datos['cantidad']
    ];
    $abmCarrito->agregarProductoCarrito($param);
}

try {
    echo json_encode([
        'success' => true,
        'message' => 'Todo salió bien' . $datos['idproducto']
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor: ' . $e->getMessage()
    ]);
}