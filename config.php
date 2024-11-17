<?php
header('Content-Type: text/html; charset=utf-8');
header("Cache-Control: no-cache, must-revalidate ");

////////////////////////
// CONFIGURACION APP //
//////////////////////

$PROYECTO = 'E-Commerce';
$GLOBALS['ROOT'] = $_SERVER['DOCUMENT_ROOT'] . "/$PROYECTO/";

require_once($ROOT . './app/utils/funcs.php');
// require_once($ROOT . './vendor/autoload.php');
require_once($ROOT . './app/model/connection/BaseDatos.php');
