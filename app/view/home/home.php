<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';
?>

<style>
    .centrado {
        text-align: center;
    }
</style>
<div class="ui container">
    <h1 class="centrado">Elixir Patagónico</h1>
</div>



<div class="ui container">
    <h2 class="ui header my-4">Productos</h2>
    <button id="actualizarProductos" class="ui button">Actualizar Productos</button>
    <div id="galeriaProductos" class="ui three column grid"></div>
</div>
<script src="../js/mostrarProductos.js"></script>
