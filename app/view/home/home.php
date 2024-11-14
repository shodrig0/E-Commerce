<?php
include_once '../layouts/header.php';
?>

<div class="ui container">
    <h2 class="ui header my-4">Productos</h2>
    <div id="galeriaProductos" class="ui three column grid"></div>
</div>

<style>
.imagen {
    height: 230px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.producto-imagen {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
}
</style>

<script src="../js/mostrarProductos.js"></script>
