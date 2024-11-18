<?php
include_once '../layouts/header.php';

require_once '../../controller/Session.php';
// require_once '../../controller/AbmUsuario'

$session = new Session();

// Redirigir si no está logueado
// if (!$session->validar()) {
//     header("Location: home.php");
//     exit();
// }

$usuario = $session->getUsuario();
if ($usuario) {
    echo "Bienvenido, " . htmlspecialchars($usuario->getUsNombre()) . ".";
    echo '<a href="logout.php">Cerrar sesión</a>';
}

?>

<a href="../pages/menuProductos.php"><button>ABM PRODUCTO</button></a>
<a href="../usuario/gestionUsuario.php"><button>LOGIN</button></a>
<div class="ui container">
    <h2 class="ui header my-4">Productos</h2>
    <div id="galeriaProductos" class="ui three column grid"></div>
</div>

<script src="../js/mostrarProductos.js"></script>