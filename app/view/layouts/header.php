<?php

define('BASE_PATH', dirname(__DIR__, 3));
require_once BASE_PATH . '/config.php';

$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$rutaProyecto = "/E-Commerce/";
$baseURL = $protocolo . $host . $rutaProyecto;

$session = new Session();

$vistaAdmin = false;
$usuario = $session->getUsuario();
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elixir Patagónico</title>
    <link rel="icon" href="<?php echo $baseURL ?>app/view/assets/img/LogoFrenteFINALL.png">
    <link rel="stylesheet" href="<?php echo $baseURL ?>Semantic-UI/dist/semantic.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?php echo $baseURL ?>Semantic-UI/dist/semantic.min.js"></script>
    <script src="<?php echo $baseURL ?>app/view/js/btns.js"></script>
    <link rel="stylesheet" href="<?php echo $baseURL ?>app/view/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<header>
    <div class="ui grid" style="align-items: center; padding: 1em;">
        <div class="two wide column" style="text-align: left;">
            <button class="ui icon button" id="menuButton">
                <i class="bars icon"></i>
            </button>
        </div>
        <div class="twelve wide column" style="text-align: center;">
            <a href="<?php echo $baseURL ?>app/view/home/home.php">
                <img src="<?php echo $baseURL ?>app/view/assets/img/LogoFrenteFINALL.png" alt="Elixir Patagónico" style="height: 42px;">
            </a>
        </div>
        <div class="two wide column" style="text-align: right; display: flex; justify-content: flex-end; align-items: center; gap: 1em; padding-right: 1em;">
        <?php if (!$usuario): ?>
            <div class="ui buttons">
                <a href="<?php echo $baseURL ?>app/view/pages/admin/gestionUsuario.php" class="ui vertical animated button">
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
                    <a href="<?php echo $baseURL ?>app/view/pages/user/profile.php" class="item">Ver Perfil</a>
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

</header>
