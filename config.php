<?php

$PROYECTO = 'E-Commerce';

$pagTitulo = "Elixir Patagónico";

$ROOT = $_SERVER['DOCUMENT_ROOT'] . "/$PROYECTO/";

include_once($ROOT . 'app/utils/funcs.php');

include_once($ROOT . './vendor/autoload.php');

// Variable que define la pagina de autenticacion del proyecto
$INICIO = "Location:http://" . $_SERVER['HTTP_HOST'] . "/$PROYECTO/vista/login/login.php";

// variable que define la pagina principal del proyecto (menu principal)
$PRINCIPAL = "Location:http://" . $_SERVER['HTTP_HOST'] . "/$PROYECTO/principal.php";


$_SESSION['ROOT'] = $ROOT;
