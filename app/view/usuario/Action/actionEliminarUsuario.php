<?php

header('Content-Type: application/json; charset=utf-8');
ob_clean();

require_once('../../../../config.php');
require_once('../../../model/Usuario.php');
require_once('../../../controller/ABMUsuario.php');
require_once '../../../controller/AbmUsuarioRol.php';
require_once '../../../model/UsuarioRol.php';
require_once '../../../controller/AbmRol.php';
require_once '../../../model/Rol.php';


$datos = darDatosSubmitted();
// $salida = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idUsuario'])) {
    $idUsuario = intval($_POST['idUsuario']);
    $abmUsuario = new AbmUsuario();

    $resultado = $abmUsuario->borrarLogico($idUsuario);
    if ($resultado) {
        echo json_encode(['success' => true, 'message' => 'Usuario deshabilitado correctamente']);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al deshabilitar']);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Peticion inválida']);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>ASction del borrado</title>
</head>

<body>
    
        <a href="../../../index.php">
            volver
        </a>
</body>

</html>