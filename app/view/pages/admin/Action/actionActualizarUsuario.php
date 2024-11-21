<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = darDatosSubmitted();

    if (isset($datos['idUsuario'])) {
        $id = intval($datos['idUsuario']);
        $objAbmUsuario = new AbmUsuario();
        $objUsuario = $objAbmUsuario->buscarUsuario("idusuario = " . $id);

        if (!is_null($objUsuario)) {
            if (isset($datos["accion"]) && $datos["accion"] === "pedir_datos") {
                $objAbmUsuarioRol = new AbmUsuarioRol();
                $objAbmRol = new AbmRol();

                // Roles del usuario
                $colRolesUsuario = $objAbmUsuarioRol->buscarUsuarioRol($id);
                $usRoles = [];
                foreach ($colRolesUsuario as $rolObj) {
                    $usRoles[] = [
                        'idRol' => $rolObj->getRol()->getIdRol(),
                        'nombreRol' => $rolObj->getRol()->getRoDescripcion(),
                    ];
                }

                $colRoles = $objAbmRol->listarRoles();
                $roles = [];
                foreach ($colRoles as $objRol) {
                    $roles[] = [
                        'idRol' => $objRol->getIdRol(),
                        'nombreRol' => $objRol->getRoDescripcion(),
                    ];
                }

                $datosUsuario = [
                    'idUsuario' => $objUsuario->getIdUsuario(),
                    'usnombre' => $objUsuario->getUsNombre(),
                    'usmail' => $objUsuario->getUsMail(),
                    'usdeshabilitado' => $objUsuario->getUsDeshabilitado(),
                    'usrol' => $usRoles,
                ];

                $response = [
                    'success' => true,
                    'roles' => $roles,
                    'usuario' => $datosUsuario,
                ];
            } elseif ($datos['accion'] === 'actualizar_datos') {
                $objUsuario = new Usuario();
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Acción no válida.',
                ];
            }
        } else {
            $response = [
                'success' => false,
                'message' => 'Usuario no encontrado.',
            ];
        }
    } else {
        $response = [
            'success' => false,
            'message' => 'ID de usuario no proporcionado.',
        ];
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Método no permitido.',
    ];
}

echo json_encode($response);
exit;
