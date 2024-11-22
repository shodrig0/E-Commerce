<?php
header('Content-Type: application/json; charset=utf-8');

require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';

$datos = darDatosSubmitted();
$salida = []; // Inicializamos la salida

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $abmUsuario = new AbmUsuario();
    $resultado = $abmUsuario->registrar($datos);

    if ($resultado['success']) {
        $salida['resp'] = 'Éxito';
        $salida['message'] = $resultado['message'];
        $salida['usnombre'] = $datos['usnombre'];
        $salida['usemail'] = $datos['usemail'];
    } else {
        $salida['resp'] = 'Error';
        $salida['error'] = $resultado['error'];
        http_response_code(400); // Error del cliente
    }
} else {
    $salida['resp'] = 'Método no permitido';
    $salida['error'] = true;
    http_response_code(405); // Método no permitido
}
?>

    <div class="ui container" style="margin-top: 50px;">
        <?php if (isset($salida['resp']) && $salida['resp'] === 'Error'): ?>
            <div class="ui negative message">
                <div class="header">Error</div>
                <p><?php echo htmlspecialchars($salida['error']); ?></p>
            </div>
        <?php elseif (isset($salida['resp']) && $salida['resp'] === 'Método no permitido'): ?>
            <div class="ui negative message">
                <div class="header">Método no permitido</div>
                <p><?php echo htmlspecialchars($salida['resp']); ?></p>
            </div>
        <?php else: ?>
            <div class="ui positive message">
                <div class="header">¡Usuario agregado exitosamente!</div>
                <p><strong>Nombre:</strong> <?php echo htmlspecialchars($salida['usnombre']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($salida['usemail']); ?></p>
                <p><?php echo htmlspecialchars($salida['message']); ?></p>
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
