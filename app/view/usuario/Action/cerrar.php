<?php

require_once '../../../configuracion.php';
require_once '../../controller/helpers/Session.php';

$sesion = new Session();
if ($sesion->validar()) {
    $sesion->cerrar();
    $msj = "ta bien cerrado";
} else {
    $msj = "nada que cerrar";
}
echo $msj;
