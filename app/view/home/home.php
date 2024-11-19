<?php
include_once '../../../config.php';
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

<?php include '../partials/navbar.php'; ?>

<?php if ($usuario): ?>
        <p>Bienvenido, <?= htmlspecialchars($usuario->getUsNombre()); ?>.</p>
        <a href="../usuario/Action/cerrar.php">Cerrar sesión</a>
        
        <?php if ($vistaAdmin): ?>
            <a href="../pages/store/gestionProducto.php"><button>ABM PRODUCTO</button></a>
        <?php endif; ?>
    <?php else: ?>
        <p>Usuario no logueado.</p>
    <?php endif; ?>
<a href="../usuario/gestionUsuario.php"><button>LOGIN</button></a>
<a href="../pages/admin/menu.php"><button>Script de Menu</button></a>
<div class="ui container">
    <h2 class="ui header my-4">Productos</h2>
    <button id="actualizarProductos" class="ui button">Actualizar Productos</button>
    <div id="galeriaProductos" class="ui three column grid"></div>
</div>
<script src="../js/mostrarProductos.js"></script>