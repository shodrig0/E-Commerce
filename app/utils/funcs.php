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

spl_autoload_register(function ($class_name) {
    $directories = array(
        $_SERVER['ROOT'] . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . 'classes',
        $_SERVER['ROOT'] . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . 'connection',
        $_SERVER['ROOT'] . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . 'helpers',
        $_SERVER['ROOT'] . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . 'services'
    );

    foreach ($directories as $directory) {
        $file = $directory . DIRECTORY_SEPARATOR . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }

    throw new Exception("No cargó clase: $class_name", E_USER_WARNING);
});
