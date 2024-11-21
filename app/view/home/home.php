<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';
?>

<style>
    .centrado {
        text-align: center;
        margin: 0.5em auto;
    }

    .icono {
        width: 30%;
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
    }
</style>

<div class="ui container">
    <h1 class="ui centrado">Elixir Patagónico</h1>
    <h4 class="ui centrado">Tu vinoteca de confianza</h4>

    <img src="../assets/img/bottle.svg" class="icono" alt="Botella de vino">

    <p></p>
</div>

<?php footer(); ?>