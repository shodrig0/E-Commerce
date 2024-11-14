<?php

include_once '../../model/connection/BaseDatos.php';
include_once '../../model/Producto.php';

$producto = new Producto();
$conexion = new BaseDatos();

$sql = "SELECT * FROM producto";
$statement = $conexion->prepare($sql);
$valor = $statement->execute();

if ($valor){
    while ($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
        $data["producto"][] = $resultado;
    }
    $datosJSON = json_encode($data);
    echo $datosJSON;
} else {
    echo "echo";
}

$statement->closeCursor();
$conexion = null;

