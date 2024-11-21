<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';

$response = [
    'success' => false, // Indicador de éxito o error
    'message' => '',    // Mensaje para el cliente
];

if (isset($_POST['idRol']) && isset($_POST['idUsuario'])) {
    $idRol = $_POST['idRol'];
    $idUsuario = $_POST['idUsuario'];

    $abmUsuarioRol = new AbmUsuarioRol();

    if ($abmUsuarioRol->buscarUsuarioRol($idUsuario) > 1) {
        $resultado = $abmUsuarioRol->eliminarUsuarioRol(); // Asegúrate de pasar los parámetros necesarios
        if ($resultado) {
            $response['success'] = true;
            $response['message'] = 'Rol eliminado correctamente.';
        } else {
            $response['message'] = 'Error al eliminar el rol.';
        }
    } else {
        $response['message'] = 'No se puede eliminar el único rol del usuario.';
    }
} else {
    $response['message'] = 'Datos insuficientes para realizar la operación.';
}

// Devolver respuesta en formato JSON
header('Content-Type: application/json');
echo json_encode($response);
