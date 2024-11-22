<?php
header('Content-Type: application/json; charset=utf-8');

require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/controller/Mail.php'; // Incluye la clase Mail

$datos = darDatosSubmitted();
$salida = [];

if (isset($datos['usnombre'], $datos['usemail'], $datos['uspass']) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $userName = $datos['usnombre'];
    $email = $datos['usemail'];
    $passwordHash = $datos['uspass'];

    // Crear objeto para la gestión del usuario
    $objAbmUsuario = new AbmUsuario();
    $query = $objAbmUsuario->agregarUsuario($userName, $email, $passwordHash);

    if (isset($query['error'])) {
        http_response_code(409);
        $salida['resp'] = 'Error';
        $salida['error'] = true;
    } else {
        $salida['resp'] = 'Éxito';
        $salida['usnombre'] = $userName;
        $salida['usemail'] = $email;

        // Configurar el correo
        $mailService = new Mail();
        $asunto = 'Bienvenido a nuestra plataforma';
        $contenidoHtml = "
        <h1>¡Hola {$userName}!</h1>
        <p>Gracias por registrarte en nuestro sistema.</p>
        <p>Esperamos que disfrutes de tu experiencia.</p>
        <p>Saludos,<br>El equipo de Soporte</p>
        ";
        $contenidoAlt = "¡Hola {$userName}! Gracias por registrarte en nuestro sistema. Esperamos que disfrutes de tu experiencia.";

        // Intentar enviar el correo
        try {
            $mailService->enviarCorreo($email, $userName, $asunto, $contenidoHtml, $contenidoAlt);
        } catch (Exception $e) {
            $salida['resp'] = 'Registro exitoso, pero no se pudo enviar el correo.';
            $salida['error'] = false;
        }
    }
} else {
    $salida['resp'] = 'Faltan datos';
    $salida['error'] = true;
    http_response_code(400);
}
?>


    <div class="ui container" style="margin-top: 50px;">
        <?php if (isset($salida['error']) && $salida['error']): ?>
            <div class="ui negative message">
                <div class="header">Error</div>
                <p><?php echo htmlspecialchars($salida['resp']); ?></p>
            </div>
        <?php else: ?>
            <div class="ui positive message">
                <div class="header">¡Usuario agregado exitosamente!</div>
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($salida['usnombre']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($salida['usemail']); ?></p>
            </div>
            <div class="ui active progress">
                <div class="bar" style="width: 100%;"></div>
                <div class="label">Usted será redirigido brevemente...</div>
            </div>
        <?php endif; ?>
        <a href="../home/home.php" class="ui button">
            <i class="arrow left icon"></i> Volver
        </a>
    </div>
