<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';

?>

<div class="ui container">
    <h2 class="ui header my-4">Productos</h2>
    <div id="galeriaProductos" class="ui three column grid"></div>
</div>
<script src="../js/mostrarProductos.js"></script>

<?php footer(); ?>