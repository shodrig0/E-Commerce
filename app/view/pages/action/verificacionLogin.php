<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';

$datos = darDatosSubmitted();
$mensaje = '';
$redireccion = BASE_URL . "app/view/home/home.php";

try {
    if (empty($datos['usnombre']) || empty($datos['uspass'])) {
        $mensaje = '<div class="ui red message">Faltan datos obligatorios</div>';
    } else {
        $session = Session::getInstance();
        $nombre = htmlspecialchars($datos['usnombre']);
        $password = $datos['uspass'];

        if ($session->iniciar($nombre, $password)) {
            header("Location: $redireccion");
            exit();
        } else {
            $mensaje = '<div class="ui red message">Usuario o contraseña incorrectos. Intente nuevamente.</div>';
        }
    }
} catch (PDOException $e) {
    $mensaje = '<div class="ui red message">Ocurrió un problema en el servidor. Por favor, intente más tarde.</div>';
}
// header("Refresh: 2; url= $redireccion");
