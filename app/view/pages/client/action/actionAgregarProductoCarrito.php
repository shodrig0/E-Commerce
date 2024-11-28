<?php
require_once '../../../../../config.php';

$datos = darDatosSubmitted();
header('Content-Type: application/json');

try {
    if (isset($datos)) {
        $abmCarrito = new AbmCarrito();
        $param = [
            'idproducto' => $datos['idproducto'],
            'cantidad' => $datos['cantidad']
        ];
        $productoAgregado = $abmCarrito->agregarProductoCarrito($param);

        if ($productoAgregado) {
            $carrito = $abmCarrito->obtenerCarrito();
            $precioTotal = 0;

            foreach ($carrito as $producto) {
                $precioTotal += $producto['precio'] * $producto['cantidadproducto'];
            }
            $producto = null;
            foreach ($carrito as $item) {
                if ($item['idproducto'] == $datos['idproducto']) {
                    $producto = $item;
                    break;
                }
            }

            echo json_encode([
                'success' => true,
                'message' => 'Producto agregado correctamente.',
                'carrito' => $carrito, 
                'precioTotal' => $precioTotal,
                'producto' => $producto
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'No se pudo agregar el producto al carrito.'
            ]);
        }
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor: ' . $e->getMessage()
    ]);
}
