<?php
require_once '../../../../../config.php';
require_once '../../../../model/Producto.php';
require_once '../../../../controller/AbmProducto.php';

$objAbmProducto = new AbmProducto();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operacion = $_POST['operacion'] ?? null; 
    $idProducto = intval($_POST['idProducto'] ?? 0); 
    $nombreProducto = $_POST['nombreProducto'] ?? null; 
    $precioProducto = $_POST['precioProducto'] ?? null;
    $stockProducto = intval($_POST['stockProducto'] ?? 0);

    switch ($operacion) {
        case 'agregar':
            if ($nombreProducto && $precioProducto && $stockProducto > 0) {
                $producto = new Producto();
                $producto->setPronombre($nombreProducto);
                $producto->setPrecio($precioProducto);
                $producto->setProcantstock($stockProducto);

                if ($objAbmProducto->agregarProducto($producto)) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Producto agregado exitosamente.',
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error al agregar el producto.',
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Por favor, complete todos los campos obligatorios para agregar el producto.',
                ]);
            }
            break;

        case 'actualizar':
            if ($idProducto && $nombreProducto && $precioProducto && $stockProducto >= 0) {
                $producto = $objAbmProducto->buscarProducto($idProducto);
                if ($producto) {
                    $producto->setPronombre($nombreProducto);
                    $producto->setPrecio($precioProducto);
                    $producto->setProcantstock($stockProducto);

                    if ($objAbmProducto->modificarProducto($producto)) {
                        echo json_encode([
                            'success' => true,
                            'message' => 'Producto actualizado exitosamente.',
                        ]);
                    } else {
                        echo json_encode([
                            'success' => false,
                            'message' => 'Error al actualizar el producto.',
                        ]);
                    }
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Producto no encontrado.',
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Por favor, complete todos los campos obligatorios para actualizar el producto.',
                ]);
            }
            break;

        case 'borrar':
            if ($idProducto) {
                if ($objAbmProducto->eliminarProducto($idProducto)) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Producto eliminado exitosamente.',
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error al eliminar el producto.',
                    ]);
                }
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'ID del producto no proporcionado para borrar.',
                ]);
            }
            break;

        default:
            echo json_encode([
                'success' => false,
                'message' => 'Operación no válida.',
            ]);
            break;
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.',
    ]);
}
?>
