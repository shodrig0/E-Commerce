<?php

header('Content-Type: application/json; charset=utf-8');

require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';

$datos = darDatosSubmitted();
// $salida = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idUsuario'])) {
    $idUsuario = intval($_POST['idUsuario']);
    $abmUsuario = new $abmUsuario();

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
    <title>Action del borrado</title>
</head>

<body>

    <a href="../../../index.php">
        volver
    </a>
</body>

</html>