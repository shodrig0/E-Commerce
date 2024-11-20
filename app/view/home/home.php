<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';


?>


<?php if ($usuario): ?>
    <p>Bienvenido, <?= htmlspecialchars($usuario->getUsNombre()); ?>.</p>
    <a href="../usuario/Action/cerrar.php">Cerrar sesión</a>

    <?php if ($vistaAdmin): ?>
        <a href="../pages/store/gestionProducto.php"><button>ABM PRODUCTO</button></a>
    <?php endif; ?>
<?php else: ?>
    <p>Usuario no logueado.</p>
<?php endif; ?>
<a href="../pages/public/login.php"><button>LOGIN</button></a>
<a href="../pages/admin/menu.php"><button>Script de Menu</button></a>
<div class="ui container">
    <h2 class="ui header my-4">Productos</h2>
    <button id="actualizarProductos" class="ui button">Actualizar Productos</button>
    <div id="galeriaProductos" class="ui three column grid"></div>
</div>
<script src="../js/mostrarProductos.js"></script>