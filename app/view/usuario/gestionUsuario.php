<?php
include_once '../layouts/header.php';
?>

<div class="ui top attached tabular menu">
    <a class="item active" data-tab="login">Login</a>
    <a class="item" data-tab="miembros">Miembros</a>
</div>

<div class="ui bottom attached tab segment active" id="tab-login" data-tab="login">
    <!-- Este contenido se cargará dinámicamente -->
</div>
<div class="ui bottom attached tab segment" id="tab-miembros" data-tab="miembros">
    <!-- Este contenido se cargará dinámicamente -->
</div>

<script>
    // Inicialización de tabs con Semantic UI
    $('.menu .item').tab();

    // Cargar dinámicamente el contenido al hacer clic en cada tab
    $('[data-tab="login"]').on('click', function () {
        $('#tab-login').load('./login.php');
    });

    $('[data-tab="miembros"]').on('click', function () {
        $('#tab-miembros').load('./miembros.php');
    });

    // Cargar contenido por defecto para la pestaña activa
    $(document).ready(function () {
        $('#tab-login').load('./login.php');
    });
</script>
