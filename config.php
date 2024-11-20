<?php
header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate ");

// ////////////////////////
// // CONFIGURACION APP //
// //////////////////////

$PROYECTO = 'E-Commerce';

$GLOBALS['ROOT'] = $_SERVER['DOCUMENT_ROOT'] . "/$PROYECTO/";

define('BASE_URL', "/" . $PROYECTO);
// define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . "/$PROYECTO/");


require_once($GLOBALS['ROOT'] . './app/utils/funcs.php');
// require_once($ROOT . './vendor/autoload.php');
require_once($GLOBALS['ROOT'] . './app/model/connection/BaseDatos.php');

function navbar($userRoles, $usuario)
{
    include $GLOBALS['ROOT'] . './app/view/partials/navbar.php';
}
