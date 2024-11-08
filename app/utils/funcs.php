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
        $_SESSION['ROOT'] . 'model/',
        $_SESSION['ROOT'] . 'model/connector/',
        $_SESSION['ROOT'] . 'control/',
    );

    foreach ($directorys as $directory) {
        if (file_exists($directory . $class_name . '.php')) {
            require_once($directory . $class_name . '.php');
            return;
        }
    }
});