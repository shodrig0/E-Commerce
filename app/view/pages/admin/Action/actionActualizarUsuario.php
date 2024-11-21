<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = darDatosSubmitted();
    $id = $datos['idUsuario'];

    if (isset($id)) {
        $objAbmUsuario = new AbmUsuario();
        $objUsuario = $objAbmUsuario->buscarUsuario("idusuario = " . $id);

        if (!is_null($objUsuario)) {
            $objAbmUsuarioRol = new AbmUsuarioRol;
            $colRoles = $objAbmUsuarioRol->buscarUsuarioRol($id);
            
            $roles = [];
            foreach ($colRoles as $rolObj) {
                $roles[] = [
                    'idRol' => $rolObj->getRol()->getIdRol(),
                    'nombreRol' => $rolObj->getRol()->getRoDescripcion(),
                ];
            }

            $datosUsuario = [
                'idUsuario' => $objUsuario->getIdUsuario(),
                'usnombre' => $objUsuario->getUsNombre(),
                'usmail' => $objUsuario->getUsMail(),
                'usdeshabilitado' => $objUsuario->getUsDeshabilitado(),
                'rol' => $roles
            ];

            echo json_encode([
                'success' => true,
                'usuario' => $datosUsuario,
            ]);
            exit;
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Usuario no encontrado.',
            ]);
            exit;
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'ID de usuario no proporcionado.',
        ]);
        exit;
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.',
    ]);
    exit;
}
