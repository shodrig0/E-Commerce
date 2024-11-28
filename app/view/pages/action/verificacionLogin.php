<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';

$datos = darDatosSubmitted();
$mensaje = '';

try {
    if (empty($datos['usnombre']) || empty($datos['uspass'])) {
        $mensaje = '<div class="ui red message">Faltan datos obligatorios</div>';
    } else {
        $session = Session::getInstance();
        $nombre = htmlspecialchars($datos['usnombre']); // Sanitizar para prevenir XSS
        $password = $datos['uspass'];

        if ($session->iniciar($nombre, $password)) {
            $mensaje = '<div class="ui green message">¡Bienvenido!</div>';
            exit();
        } else {
            $mensaje = '<div class="ui red message">Usuario o contraseña incorrectos. Intente nuevamente.</div>';
        }
    }
} catch (PDOException $e) {
    $mensaje = '<div class="ui red message">Ocurrió un problema en el servidor. Por favor, intente más tarde.</div>';
}
?>

<div class="ui container" style="margin-top: 20px;">
    <?php echo $mensaje; ?>
</div>

<?php footer(); ?>
