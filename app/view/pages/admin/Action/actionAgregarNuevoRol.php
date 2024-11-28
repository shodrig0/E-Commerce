<?php
require_once "../../../../../config.php"; 

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descripcion = trim($_POST['rodescripcion'] ?? '');

    if (empty($descripcion)) {
        $response['errorMsg'] = "Por favor, ingresa una descripción para el rol.";
    } else {
        $abmRol = new AbmRol();

        $data = [
            'rodescripcion' => $descripcion
        ];

        if ($abmRol->crearRol($data)) {
            $response['respuesta'] = "Rol agregado exitosamente.";
        } else {
            $response['errorMsg'] = "Ocurrió un error al intentar agregar el rol.";
        }
    }
} else {
    $response['errorMsg'] = "Método no permitido.";
}

header('Content-Type: application/json');
echo json_encode($response);
