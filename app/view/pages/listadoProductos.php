<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';

?>

<div class="ui container">
    <h2 class="ui header my-4">Productos</h2>
    <div id="galeriaProductos" class="ui three column grid"></div>
</div>
<script src="../js/mostrarProductos.js?v=1.0.1"></script>

<div class="ui modal" id="modalConfirmacion">
    <i class="close icon"></i>
    <div class="header">
        Producto Agregado al Carrito
    </div>
    <div class="content">
        <p id="productoNombre"></p>
        <p id="productoCantidad"></p>
        <p id="productoPrecio"></p>
    </div>
    <div class="actions">
        <div class="ui green button" id="irAlCarrito">
            Ver Carrito
        </div>
        <div class="ui red button">
            Cerrar
        </div>
    </div>
</div>

<?php footer(); ?>