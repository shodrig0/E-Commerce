<?php

include_once '../../../../model/connection/BaseDatos.php';
include_once '../../../../model/Rol.php';

$rol = new Rol();
$roles = $rol->listar(); 
$arregloRoles = [];

foreach ($roles as $rol) {
    $arregloRoles[] = array(
        'idrol' => $rol->getIdRol(),
        'rodescripcion' => $rol->getRoDescripcion()
    );
}

if (!empty($arregloRoles)) {
    $data = ["roles" => $arregloRoles];
    $datosJSON = json_encode($data);
    echo $datosJSON;
} else {
    echo json_encode(["roles" => []]);
}
