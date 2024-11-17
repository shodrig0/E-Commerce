<?php

require_once '../../../configuracion.php';
require_once '../../controller/helpers/Session.php';
require_once '../../controller/services/AbmUsuario.php';
require_once '../../model/classes/Usuario.php';

$datos = darDatosSubmitted();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $datos['usnombre'];
    $contraseniaHash = $datos['uspass']; // ya viene hasheada
    var_dump($nombre);
    var_dump($contraseniaHash);
    var_dump($_POST);
    $nuevaSesion = new Session();
    $inicioExitoso = $nuevaSesion->iniciar($nombre, $contraseniaHash);

    if ($inicioExitoso) {
        echo 'Inicio de sesión exitoso';
    } else {
        echo 'Error: credenciales incorrectas';
    }
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../../Semantic-UI/dist/semantic.min.css">
</head>

<body>
    <br>
    <form action="cerrar.php" method="post">
        <button type="submit" class="ui blue button vertical animated">
            <div class="hidden content">
                <i class="window close icon"></i>
            </div>
            <div class="visible content">
                Cerrar Sesión
            </div>
        </button>
    </form>
    <a href="../home/home.php">
        <button class="ui blue button animated horizontal">
            <div class="visible content">
                <i class="arrow left icon"></i>
            </div>
            <div class="hidden content">
                Volver
            </div>
        </button>
    </a>

</body>

</html>