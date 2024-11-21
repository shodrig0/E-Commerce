<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => 'Ocurrió un error inesperado.'
];

$datos = darDatosSubmitted();

if (isset($datos) && isset($datos['idUsuario']) && isset($datos['idRol'])) {
    $idUsuario = $datos['idUsuario'];
    $idRol = $datos['idRol'];

    $objAbmUsuario = new AbmUsuario();
    $objUsuario = $objAbmUsuario->buscarUsuario("idusuario =" . $idUsuario);
    if ($objUsuario) {
        $objAbmRol = new AbmRol();
        $objRol = $objAbmRol->buscarRol($idRol);
        if ($objRol) {
            $objAbmUsuarioRol = new AbmUsuarioRol();
            $agregar = $objAbmUsuarioRol->agregarUsuarioRol($objUsuario, $objRol);
            if ($agregar) {
                $response['success'] = true;
                $response['message'] = 'Rol asignado exitosamente.';
            } else {
                $response['message'] = 'No se pudo asignar el rol. Intente nuevamente.';
            }
        } else {
            $response['message'] = 'El rol especificado no existe.';
        }
    } else {
        $response['message'] = 'El usuario especificado no existe.';
    }
} else {
    $response['message'] = 'Datos insuficientes para procesar la solicitud.';
}

echo json_encode($response);
exit;
