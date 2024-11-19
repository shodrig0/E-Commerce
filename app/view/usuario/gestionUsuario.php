<?php
include_once '../layouts/header.php';
include_once '../../controller/Session.php';

$session = new Session();

if (!$session->validar()) {
    // header("Location: home.php");
    // exit();
}

// var_dump($_SESSION);

$vistaAdmin = false;
$usuario = $session->getUsuario();
// var_dump($usuario);
if ($usuario) {
    $roles = $session->getRol();
    if ($roles) {
        foreach ($roles as $rol) {
            if ($rol['rodescripcion'] === 'Administrador') {
                $vistaAdmin = true;
                break;
            }
        }
    }
}

?>

<div class="ui top attached tabular menu">
    <a class="item active" data-tab="login">Login</a>
    <?php if ($vistaAdmin): ?>
        <a class="item" data-tab="miembros">Miembros</a>
    <?php endif; ?>
</div>

<div class="ui bottom attached tab segment active" id="tab-login" data-tab="login"></div>
<div class="ui bottom attached tab segment" id="tab-miembros" data-tab="miembros"></div>

<script src="../js/cargarGestionUsuario.js"></script>
<script src="../js/eliminarRol.js"></script>