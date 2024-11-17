<?php

function darDatosSubmitted()
{
    $datos = [];
    foreach ($_GET as $key => $value) {
        $datos[$key] = $value;
    }
    foreach ($_POST as $key => $value) {
        $datos[$key] = $value;
    }
    return $datos;
}

function verEstructura($e)
{
    echo "<pre>";
    print_r($e);
    echo "</pre>";
}

spl_autoload_register(function ($class_name) {
    $directorys = array(
        $GLOBALS['ROOT'] . 'model/',
        $GLOBALS['ROOT'] . 'model/connection/',
        $GLOBALS['ROOT'] . 'controller/'
    );

    // foreach ($directorys as $directory) {
    //     if (file_exists($directory . $class_name . '.php')) {
    //         require_once($directory . $class_name . '.php');
    //         return;
    //     }
    // }
    foreach ($directorys as $directory) {
        $filePath = $directory . $class_name . '.php';
        if (file_exists($filePath)) {
            require_once($filePath);
            var_dump("Cargando clase: $class_name desde $filePath");
            return;
        } else {
            var_dump("No se encontró el archivo para la clase: $class_name en $filePath");
        }
    }
});
