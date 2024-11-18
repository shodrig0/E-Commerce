<?php
include_once '../layouts/header.php';
?>

<div class="ui top attached tabular menu">
    <a class="item active" data-tab="login">Login</a>
    <a class="item" data-tab="miembros">Miembros</a>
</div>

<div class="ui bottom attached tab segment active" id="tab-login" data-tab="login"></div>
<div class="ui bottom attached tab segment" id="tab-miembros" data-tab="miembros"></div>

<script src="../js/cargarGestionUsuario.js"></script>
<script src="../js/eliminarRol.js"></script>