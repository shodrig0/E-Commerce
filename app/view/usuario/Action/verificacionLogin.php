<?php

require_once '../../layouts/header.php';
require_once '../../../../config.php';
require_once '../../../controller/Session.php';
require_once '../../../controller/AbmUsuario.php';
require_once '../../../model/Usuario.php';
require_once '../../../controller/AbmUsuarioRol.php';
require_once '../../../model/UsuarioRol.php';
require_once '../../../controller/AbmRol.php';
require_once '../../../model/Rol.php';

$datos = darDatosSubmitted();

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $nombre = $datos['usnombre'];
//     $contraseniaHash = $datos['uspass']; // ya viene hasheada
//     var_dump($nombre);
//     var_dump($contraseniaHash);
//     var_dump($_POST);
//     $nuevaSesion = new Session();
//     $inicioExitoso = $nuevaSesion->iniciar($nombre, $contraseniaHash);

//     if ($inicioExitoso) {
//         echo 'Inicio de sesión exitoso';
//     } else {
//         echo 'Error: credenciales incorrectas';
//     }
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $datos['usnombre'];
    $contraseniaHash = $datos['uspass'];

    $nuevaSesion = new Session();
    $inicioExitoso = $nuevaSesion->iniciar($nombre, $contraseniaHash);

    if ($inicioExitoso) {
        $mensaje = "<div class='ui positive message'>Inicio de sesión exitoso</div>";
    } else {
        $mensaje = "<div class='ui negative message'>Error: credenciales incorrectas</div>";
        $mensaje .= "";
    }
}
?>

<body>
<div class="ui container" style="margin-top: 20px;">
    <div class="ui grid" style="display: flex; justify-content: center; gap: 10px;">
        <form action="cerrar.php" method="post">
            <button type="submit" class="ui red button animated fade">
                <div class="visible content">Cerrar Sesión</div>
                <div class="hidden content">
                    <i class="power off icon"></i>
                </div>
            </button>
        </form>
        <a href="../../home/home.php" class="ui blue button animated fade">
            <div class="visible content center">&nbsp;&nbsp;Volver</div>
            <div class="hidden content">
                <i class="arrow left icon"></i>
            </div>
        </a>
    </div>
    <div class="ui field container" style="margin-top: 20px;">
        <?php if (isset($mensaje)) echo $mensaje; ?>
    </div>
</div>
</body>
</html>