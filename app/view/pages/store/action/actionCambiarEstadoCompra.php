<?php
require_once '../../../../../config.php';

$datos = darDatosSubmitted();
if (!isset($datos['accion'])) {
    $resp['mensaje'] = 'No se especificó la acción';
    exit();
}

$accion = $datos['accion'];
$abmCompra = new abmCompra();
$abmCompraEstado = new AbmCompraEstado();

var_dump($datos);

switch ($accion) {
    case 'cancelar':
        if (isset($datos['idcompra']) || !empty($datos['idcompra'])) {
            if($abmCompraEstado->cancelarCompra($datos)){
                $resp['success'] = true;
                $resp['mensaje'] = 'Compra cancelada con exito';
            }else{
                $resp["mensaje"] = "No se pudo cancelar la compra";
            }                       
        }else{
            $resp["mensaje"] = "Datos no proporcionados";
        }
        break;
    case 'siguienteEstado':
        if(isset($datos['idcompra']) || !empty($datos['idcompra'])){
            if($abmCompraEstado->cambiarEstado($datos)){
                $resp['mensaje'] = 'Compra actualizada con exito';
            }else{
                $resp["mensaje"] = "No se pudo actualizar la compra";
            }
        }
    
    break;
}
header('Content-Type: application/json');
echo json_encode($resp);

