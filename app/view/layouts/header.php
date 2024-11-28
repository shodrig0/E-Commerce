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
            <div class="two wide column" style="text-align: right;">
                <h3 id="relojito"></h3>
            </div>
        </div>
    </header>

    <script>
        function reloj() {
            const horaActual = new Date();
            const hora = horaActual.getHours();
            const minutos = horaActual.getMinutes();
            const formato = hora >= 12 ? 'PM' : 'AM';

            const horaFormateada = hora % 12 || 12;
            const minutosFormateados = minutos.toString().padStart(2, '0');

            document.getElementById('relojito').textContent = `Hora: ${horaFormateada}:${minutosFormateados} ${formato}`;
        }
        reloj();
        setInterval(reloj, 1000);
    </script>
    <?php
    navbar($userRoles, $usuario);
    ?>