<?php

require_once('../../../../config.php');
require_once('../../../model/Usuario.php');
require_once('../../../controller/AbmUsuario.php');
require_once '../../../controller/AbmUsuarioRol.php';
require_once '../../../model/UsuarioRol.php';
require_once '../../../controller/AbmRol.php';
require_once '../../../model/Rol.php';

$datos = darDatosSubmitted();
$salida = [];

if (isset($datos['usnombre'], $datos['usemail'], $datos['uspass']) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $userName = $datos['usnombre'];
    $email = $datos['usemail'];
    $passwordHash = $datos['uspass'];

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
    }
} else {
    $salida['resp'] = 'Faltan datos';
    $salida['error'] = true;
    http_response_code(400);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Confirmación de Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css">
</head>

<body>
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
</body>

</html>