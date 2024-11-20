<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
// var_dump($GLOBALS);
$url = BASE_URL . 'app/view/home/home.php';
$session = Session::getInstance();

$usuario = $session->getUsuario();
$roles = $session->getRol();

$userRoles = [];
if ($roles && is_array($roles)) {
    foreach ($roles as $rol) {
        if (isset($rol['rodescripcion'])) {
            $userRoles[] = $rol['rodescripcion'];
        }
    }
}

$vistaAdmin = in_array('Administrador', $userRoles);
$vistaDeposito = in_array('Deposito', $userRoles);
$vistaCliente = in_array('Cliente', $userRoles);

if (!$session->validar() && strpos($_SERVER['REQUEST_URI'], '../pages/perfil.php')) {
    header("Location: " . $url . "home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elixir Patagónico</title>
    <link rel="icon" href="<?php echo BASE_URL ?>app/view/assets/img/LogoFrenteFINALL.png">
    <link rel="stylesheet" href="<?php echo BASE_URL ?>Semantic-UI/dist/semantic.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo BASE_URL ?>Semantic-UI/dist/semantic.min.js"></script>
    <script src="<?php echo BASE_URL ?>app/view/js/btns.js"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>app/view/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <header>
        <div class="ui grid" style="align-items: center; padding: 1em;">
            <div class="two wide column" style="text-align: left;">
                <?php if ($usuario): ?>
                    <h3>Bienvenido, <?= htmlspecialchars($usuario->getUsNombre()); ?>.</h3>
                    <?php else: ?>
                        <h3></h3>
                <?php endif; ?>
            </div>
            <div class="twelve wide column" style="text-align: center;">
                <a href="<?php echo BASE_URL ?>app/view/home/home.php">
                    <img src="<?php echo BASE_URL ?>app/view/assets/img/LogoFrenteFINALL.png" alt="Elixir Patagónico" style="height: 42px;">
                </a>
            </div>
            <div class="two wide column" style="text-align: right; display: flex; justify-content: flex-end; align-items: center; gap: 1em; padding-right: 1em;">
                <?php if (!$usuario): ?>
                    <div class="ui buttons">
                        <a href="<?php echo BASE_URL ?>app/view/pages/admin/gestionUsuario.php" class="ui vertical animated button">
                            <div class="hidden content">Login</div>
                            <div class="visible content">
                                <i class="user circle outline icon"></i>
                            </div>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="ui dropdown item" style="display: flex; align-items: center; gap: 0.5em; cursor: pointer;">
                        <i class="user circle icon" style="font-size: 1.5em;"></i>
                        <span style="font-weight: bold;"><?php echo htmlspecialchars($usuario->getUsNombre()); ?></span>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <a href="<?php echo BASE_URL ?>app/view/pages/user/profile.php" class="item">Ver Perfil</a>
                            <a href="#" class="accion-btns item" data-action="cerrarSesion">Cerrar Sesión</a>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="ui vertical animated button" style="width: auto; height: auto; overflow: visible;">
                    <div class="visible content">
                        <i class="shop icon"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui basic modal" id="modalCerrarSesion">
            <div class="ui icon header">
                <i class="sign out alternate icon"></i>
                Cerrar Sesión
            </div>
            <div class="content">
                <p>¿Estás seguro de que quieres cerrar sesión?</p>
            </div>
            <div class="actions">
                <div class="ui red cancel inverted button">
                    <i class="remove icon"></i>
                    No
                </div>
                <div class="ui green ok inverted button" id="confirmCerrarSesion">
                    <i class="checkmark icon"></i>
                    Sí
                </div>
            </div>
        </div>
        <div class="ui basic modal" id="modalResultado">
            <div class="ui icon header" id="modalResultadoIcon">
            </div>
            <div class="content">
                <p id="modalResultadoMensaje"></p>
            </div>
        </div>
        <script>
            $('.ui.dropdown').dropdown();
        </script>
    </header>
    <?php
        navbar($userRoles, $usuario);
    ?>