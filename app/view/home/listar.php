<?php

include_once '../../model/connection/BaseDatos.php';
include_once '../../model/Producto.php';

$producto = new Producto();
$conexion = new BaseDatos();

$sql = "SELECT * FROM producto";
$statement = $conexion->prepare($sql);
var_dump($statement);
$valor = $statement->execute();

if ($valor){
    while ($resultado = $statement->fetch(PDO::FETCH_ASSOC)){
        $data["pronombre"][] = $resultado;
    }
    echo json_encode($data);
}else{
    echo "echo";
}

$statement->closeCursor();
$conexion = null;