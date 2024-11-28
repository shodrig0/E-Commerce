<?php
header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate ");

// ////////////////////////
// // CONFIGURACION APP //
// //////////////////////

$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];

$PROYECTO = "E-Commerce";

define('BASE_URL', $protocolo . $host . "/" . $PROYECTO . "/");
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . "/" . $PROYECTO . "/");

$GLOBALS['ROOT'] = BASE_PATH;

// Configuración de la zona horaria en PHP
date_default_timezone_set('America/Argentina/Buenos_Aires');

// Includes requeridos
require_once($GLOBALS['ROOT'] . 'app/utils/funcs.php');
require_once($GLOBALS['ROOT'] . 'app/model/connection/BaseDatos.php');

// Función para incluir el navbar
function navbar($userRoles, $usuario)
{
    include $GLOBALS['ROOT'] . 'app/view/partials/navbar.php';
}

function footer()
{
    include $GLOBALS['ROOT'] . 'app/view/layouts/footer.php';
}
