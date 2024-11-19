<?php


    $id = intval($_POST['id']);
    $producto = new Producto();
    $producto->setIdProducto($id);
    var_dump($producto);
    $objProducto = $producto->buscar();
    $prodFinal = [
        'idproducto' => $producto->getIdProducto(),
        'pronombre' => $producto->getPronombre(),
        'prodetalle' => $producto->getProdetalle(),
        'precio' => $producto->getPrecio(),
        'procantstock' => $producto->getProcantstock()
    ];

if(!empty($prodFinal)){
    $data = ["producto" => $prodFinal];
    $datosJSON = json_encode($data);
    echo $datosJSON;
} else {
    echo json_encode(["producto" => []]);
}
?>
|