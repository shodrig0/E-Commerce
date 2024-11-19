<?php

require_once '../../../../config.php';
require_once '../../../controller/Session.php';

$sesion = new Session();
if ($sesion->validar()) {
    $sesion->cerrar();
    $msj = "ta bien cerrado";
} else {
    $msj = "nada que cerrar";
}
echo $msj;
