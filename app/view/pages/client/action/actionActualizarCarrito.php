<?php
require_once '../../../../../config.php';

header('Content-Type: application/json');

// Obtener los datos del formulario (producto y cantidad)
$datos = darDatosSubmitted();

if (isset($datos['idproducto']) && isset($datos['cantidad'])) {
    try {
        $abmCarrito = new AbmCarrito;
        $param = [
            'idproducto' => $datos['idproducto'],
            'cantidad' => $datos['cantidad']
        ];
        $abmCarrito->agregarProductoCarrito($param);
        $carritoConPrecios = $abmCarrito->obtenerCarritoConPrecios();

        echo json_encode([
            'success' => true,
            'message' => 'Carrito actualizado',
            'carrito' => $carritoConPrecios['carrito'],
            'precioTotal' => number_format($carritoConPrecios['precioTotal'], 2)
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al actualizar el carrito: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Datos incompletos o incorrectos'
    ]);
}
