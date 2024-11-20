<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';


?>

<div class="ui top attached tabular menu">
    <a class="item active" data-tab="login">Login</a>
    <?php if ($vistaAdmin): ?>
        <a class="item" data-tab="miembros">Miembros</a>
    <?php endif; ?>
</div>

<div class="ui bottom attached tab segment active" id="tab-login" data-tab="login"></div>
<div class="ui bottom attached tab segment" id="tab-miembros" data-tab="miembros"></div>

<script src="../../js/cargarGestionUsuario.js"></script>
<script src="../../js/eliminarRol.js"></script>