<?php
require_once '../../../../../config.php';
require_once '../../../../model/Producto.php';
require_once '../../../../controller/AbmProducto.php';

require_once '../../../../../config.php';
require_once '../../../../model/Producto.php';
require_once '../../../../controller/AbmProducto.php';

$datos = darDatosSubmitted();
$objAbmProducto = new AbmProducto();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEnviado = $_POST['idProducto'];
    $idProducto = intval($idEnviado);
    $param = ['idproducto' => $idProducto];
    $objProducto = $objAbmProducto->buscar($param);


    if ($objProducto !== null) {
        $productoArray = [
            'idproducto' => $objProducto[0]->getIdProducto(),
            'pronombre' => $objProducto[0]->getPronombre(),
            'prodetalle' => $objProducto[0]->getProdetalle(),
            'precio' => $objProducto[0]->getPrecio(),
            'procantstock' => $objProducto[0]->getProcantstock(),
        ];
        $data = $productoArray;
        $dataJSON = json_encode($productoArray);
        echo $dataJSON;
    } else {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado.']);
    }
}

