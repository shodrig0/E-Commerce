<?php
require_once '../../../../../config.php';

$datos = darDatosSubmitted();
$objAbmRol = new AbmRol();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEnviado = $_POST['idRol'];
    $idRol = intval($idEnviado);  // Asegurarse de que el ID sea un entero
    $param = ['idrol' => $idRol];
    
    // Buscar el rol correspondiente
    $objRol = $objAbmRol->buscarRol($param);

    if ($objRol !== null) {
        // Si se encuentra el rol, crear el arreglo con la información
        $rolArray = [
            'idrol' => $objRol[0]->getIdRol(),
            'roldescripcion' => $objRol[0]->getRoDescripcion(),
        ];
        
        // Convertir el arreglo a JSON
        $dataJSON = json_encode($rolArray);
        echo $dataJSON;
    } else {
        // Si no se encuentra el rol, enviar un mensaje de error
        echo json_encode(['success' => false, 'message' => 'Rol no encontrado.']);
    }
}
