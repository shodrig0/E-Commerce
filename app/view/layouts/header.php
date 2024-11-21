<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
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

$rolesPagina = [
    'admin' => ['Administrador'],
    'client' => ['Cliente', 'Administrador'],
    'deposito' => ['Deposito', 'Administrador']
];

$rutaActual = str_replace(BASE_PATH, '', $_SERVER['SCRIPT_FILENAME']); // dependiendo el nombre redirigirá o no

foreach ($rolesPagina as $carpeta => $rolesPermitidos) {
    if (strpos($rutaActual, "app/view/pages/{$carpeta}") !== false) {
        if (!$session->validar() || !array_intersect($userRoles, $rolesPermitidos)) {
            header("Location: $url");
            exit();
        }
    }
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
    <!-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> -->
</head>

<body>
    <header>
        <div class="ui grid" style="align-items: center; padding: 1em;">
            <div class="two wide column" style="text-align: left;">
                <div style="position: absolute; width: 800px; top: 0;">
                    <?php if ($usuario): ?>
                        <h3>Hola, <?= htmlspecialchars($usuario->getUsNombre()); ?>.</h3>
                    <?php else: ?>
                        <h3 style="margin:0;">Bienvenido An&oacute;nimo</h3>
                        <h5 style="margin:0;">No te olvides de ingresar para comprar</h5>
                    <?php endif; ?>
                </div>
            </div>
            <div class="twelve wide column" style="text-align: center;">
                <a href="<?php echo BASE_URL ?>app/view/home/home.php">
                    <img src="<?php echo BASE_URL ?>app/view/assets/img/LogoFrenteFINALL.png" alt="Elixir Patagónico" style="height: 42px;">
                </a>
            </div>
            <div class="two wide column" style="text-align: right; display: flex; justify-content: flex-end; align-items: center; gap: 1em; padding-right: 1em;">
                <?php if (!$usuario): ?>
                    <div class="ui buttons">
                        <a href="<?php echo BASE_URL ?>app/view/pages/login.php" class="ui vertical animated button">
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
                            <a href="<?php echo BASE_URL ?>app/view/pages/user/profile.php" class="item"><i class="ui id badge outline icon"></i>Ver Perfil</a>
                            <a href="#" class="accion-btns item" data-action="cerrarSesion"><i class="ui logout icon"></i>Cerrar Sesión</a>
                        </div>
                    </div>
                <?php endif; ?>
                <div>
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
            <script>
                const BASE_URL = "<?php echo BASE_URL; ?>";
            </script>
    </header>
    <?php
    navbar($userRoles, $usuario);
    ?>