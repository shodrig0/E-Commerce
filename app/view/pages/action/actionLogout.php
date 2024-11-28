<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';

$sesion = Session::getInstance();
$message = "";

if ($sesion->validar()) {
    $sesion->cerrar();
    $message = "Sesión cerrada correctamente.";
} else {
    $message = "No hay sesión activa para cerrar.";
}
$param = "";
$arg = "";
header("Refresh: 3; url=" . BASE_URL . "app/view/home/home.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';
?>

<title>Cerrar Sesión</title>
<style>
    #messageContainer {
        padding: 20px;
        margin: 20px auto;
        max-width: 600px;
        text-align: center;
        border: 1px solid #ccc;
        border-radius: 10px;
        background-color: #f9f9f9;
        font-size: 1.2em;
    }
</style>

<div id="messageContainer">
    <?= htmlspecialchars($message) ?>
    <br><br>
    Redirigido al inicio en unos segundos...
</div>
<?php footer() ?>