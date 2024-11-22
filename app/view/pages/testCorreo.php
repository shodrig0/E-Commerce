<?php
require_once '../../controller/Mail.php';

$mailService = new Mail();

$email = 'celayes.brisaabril@gmail.com';
$nombre = 'De cejita';
$asunto = 'uwu boba';
$contenidoHtml = '<h1>Boba</h1><p>Boba.</p>';
$contenidoAlt = 'Esto es un test. Mensaje enviado desde el sistema.';

try {
    $resultado = $mailService->enviarCorreo($email, $nombre, $asunto, $contenidoHtml, $contenidoAlt);
    echo $resultado['message'];  // Muestra el resultado del envío
} catch (Exception $e) {
    echo "Error al enviar correo: " . $e->getMessage();
}