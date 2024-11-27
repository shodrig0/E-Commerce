<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
$url = BASE_URL . 'app/view/home/home.php';

$session = Session::getInstance();
$usuario = $session->getUsuario();
$carrito = $session->getCarritoSession();
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
    <script src="<?php echo BASE_URL ?>app/view/js/shop_handler.js"></script>
    <link rel="stylesheet" href="<?php echo BASE_URL ?>app/view/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .carrito-desplegable {
            width: 600px;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            transform: translateX(100%);
            height: 100vh;
            overflow-y: auto;
            z-index: 1050;
            right: 0;
            top: 0;
            position: fixed;
        }

        .carrito-desplegable.mostrado {
            transform: translateX(0);
        }

        .cerrarCarrito {
            background: transparent;
            border: none;
            font-size: 1em;
            cursor: pointer;
            color: #333;
        }
    </style>
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
                    <img src="<?php echo BASE_URL ?>app/view/assets/img/LogoFrenteFINALL.png" alt="Elixir Patagónico"
                        style="height: 42px;">
                </a>
            </div>
            <div class="two wide column"
                style="text-align: right; display: flex; justify-content: flex-end; align-items: center; gap: 1em; padding-right: 1em;">
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
                            <a href="<?php echo BASE_URL ?>app/view/pages/perfil.php" class="item"><i
                                    class="ui id badge outline icon"></i>Ver Perfil</a>
                            <a href="#" class="accion-btns item" data-action="cerrarSesion"><i
                                    class="ui logout icon"></i>Cerrar Sesión</a>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="ui buttons">
                        <a href="<?php echo BASE_URL ?>app/view/pages/client/carrito.php" class="ui vertical animated button">
                            <div class="hidden content">Carro</div>
                            <div class="visible content">
                                <i class="shopping cart icon"></i>
                            </div>
                        </a>
                    </div>
            </div>
            

            <div id="modalCerrarSesion" class="ui small modal">
                <div class="header">
                    <i class="sign out alternate icon"></i> Cerrar Sesión
                </div>
                <div class="content">
                    <p>¿Estás seguro de que deseas cerrar sesión?</p>
                </div>
                <div class="actions">
                    <button class="ui red button" id="cancelCerrarSesion">Cancelar</button>
                    <button class="ui green button" id="confirmCerrarSesion">Confirmar</button>
                </div>
            </div>
            <div class="ui basic modal" id="modalResultado">
                <div class="ui icon header" id="modalResultadoIcon">
                </div>
                <div class="content">
                    <p id="modalResultadoMensaje"></p>
                </div>
            </div>
            <div id="confirmarModal" class="ui modal">
                <div class="header">Confirmar eliminación</div>
                <div class="content">
                    <p>¿Estás seguro de que deseas eliminar este usuario?</p>
                </div>
                <div class="actions">
                    <div class="ui button" onclick="$('#confirmarModal').modal('hide');">Cancelar</div>
                    <div id="confirmarBaja" class="ui red button">Confirmar</div>
                </div>
            </div>

            <script>
                $('.ui.dropdown').dropdown();
                const BASE_URL = "<?php echo BASE_URL; ?>";
            </script>
    </header>
    <?php
    navbar($userRoles, $usuario);
    ?>