<?php
require_once '../../../../../config.php';

$datos = darDatosSubmitted();header('Content-Type: application/json');

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
        'message' => 'Todo salió bien'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error del servidor: ' . $e->getMessage()
    ]);
}





























































// $idproducto = $_POST['idproducto'] ?? null;
// $cantidad = $_POST['cantidad'] ?? 1;

// if ($idproducto) {
//     if (isset($_SESSION['carrito'])) {
//         $carrito = $_SESSION['carrito'];
//     } else {
//         $carrito = isset($_COOKIE['carrito']) ? json_decode($_COOKIE['carrito'], true) : [];
//     }

//     if (isset($carrito[$idproducto])) {
//         $carrito[$idproducto]['cantidad'] += $cantidad;
//     } else {
//         // Obtener detalles del producto desde la base de datos o fuente
//         $objAbmProducto = new AbmProducto();
//         $producto = $objAbmProducto->buscarProducto($idproducto);
//         if ($producto) {
//             $carrito[$idproducto] = [
//                 'idproducto' => $idproducto,
//                 'pronombre' => $producto->getProNombre(),
//                 'prodetalle' => $producto->getProDetalle(),
//                 'precio' => $producto->getPrecio(),
//                 'cantidad' => $cantidad,
//             ];
//         }
//     }

//     if (isset($_SESSION['carrito'])) {
//         $_SESSION['carrito'] = $carrito;
//     } else {
//         setcookie('carrito', json_encode($carrito), time() + 3600, '/');
//     }

//     echo json_encode(['success' => true]);
// } else {
//     echo json_encode(['success' => false, 'message' => 'Producto inválido']);
// }
