<?php
require_once "../../../../../config.php"; 

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $detalle = trim($_POST['detalle'] ?? '');
    $precio = floatval($_POST['precio'] ?? 0);
    $stock = intval($_POST['stock'] ?? 0);

    // Validación básica de los campos
    if (empty($nombre) || $precio <= 0 || $stock < 0) {
        $response['errorMsg'] = "Por favor, completa todos los campos correctamente.";
    } else {
        $abmProducto = new AbmProducto();

        // Datos del producto a insertar
        $data = [
            'pronombre' => $nombre,
            'prodetalle' => $detalle,
            'proprecio' => $precio,
            'procantstock' => $stock
        ];

        // Intentar crear el producto
        if ($abmProducto->alta($data)) {
            $response['respuesta'] = "Producto agregado exitosamente.";
        } else {
            $response['errorMsg'] = "Ocurrió un error al intentar agregar el producto.";
        }
    }
} else {
    $response['errorMsg'] = "Método no permitido.";
}

// Devolver la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
