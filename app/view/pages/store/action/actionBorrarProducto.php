<?php 
require_once '../../../../../config.php';
header('Content-Type: application/json');
$datos = darDatosSubmitted();

if (isset($datos['idProducto']) && !empty($datos['idProducto'])) {
    $idProducto = $datos['idProducto'];

    $abmProducto = new AbmProducto();

    $param = ['idproducto' => $idProducto];

    $respuesta = $abmProducto->baja($param);

    if ($respuesta) {
        echo json_encode([
            'success' => true,
            'message' => 'Producto deshabilitado correctamente.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'No se pudo deshabilitar el producto.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No se recibió el ID del producto'
    ]);
}
?>
