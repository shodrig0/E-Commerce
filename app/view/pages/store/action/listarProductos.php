<?php

include_once '../../../../model/connection/BaseDatos.php';
include_once '../../../../model/Producto.php';

$producto = new Producto();
$productos = $producto->listar();
$arregloProductos=[];

foreach ($productos as $producto) {
    $arregloProductos[] = array(
        'idproducto' => $producto->getIdProducto(),
        'pronombre' => $producto->getPronombre(),
        'prodetalle' => $producto->getProdetalle(),
        'precio' => $producto->getPrecio(),
        'procantstock' => $producto->getProcantstock(),
    );
}

if(!empty($arregloProductos)){
    $data = ["producto" => $arregloProductos];
    $datosJSON = json_encode($data);
    echo $datosJSON;
} else {
    echo json_encode(["producto" => []]);
}