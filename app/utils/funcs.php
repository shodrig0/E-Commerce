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
        $GLOBALS['ROOT'] . 'app/model/',
        $GLOBALS['ROOT'] . 'app/model/connection/',
        $GLOBALS['ROOT'] . 'app/controller/'
    );
    foreach ($directorys as $directory) {
        $filePath = $directory . $class_name . '.php';
        if (file_exists($filePath)) {
            require_once($filePath);
            // var_dump("Cargando clase: $class_name desde $filePath");
            return;
        } else {
            // var_dump("No se encontró el archivo para la clase: $class_name en $filePath");
        }
    }
});
