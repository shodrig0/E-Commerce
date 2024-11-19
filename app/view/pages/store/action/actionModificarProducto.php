<?php
require_once '../../../../../config.php';
require_once '../../../../model/Producto.php';
require_once '../../../../controller/AbmProducto.php';

require_once '../../../../../config.php';
require_once '../../../../model/Producto.php';
require_once '../../../../controller/AbmProducto.php';

$objAbmProducto = new AbmProducto();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEnviado = $_POST['idProducto'];
    $idProducto = intval($idEnviado);

    // Busca producto
    $objProducto = $objAbmProducto->buscarProducto($idProducto);

    if ($objProducto !== null) {
        $productoArray = [
            'idproducto' => $objProducto->getIdProducto(),
            'pronombre' => $objProducto->getPronombre(),
            'prodetalle' => $objProducto->getProdetalle(),
            'precio' => $objProducto->getPrecio(),
            'procantstock' => $objProducto->getProcantstock(),
        ];
        $data = $productoArray;
        $dataJSON = json_encode($productoArray);
        echo $dataJSON;
    } else {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado.']);
    }
}

