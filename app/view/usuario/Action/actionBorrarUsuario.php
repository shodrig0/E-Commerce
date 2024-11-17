<?php

require_once('../../../configuracion.php');
require_once('../../model/classes/Usuario.php');
require_once('../../controller/services/AbmUsuario.php');
require_once '../../controller/services/AbmUsuarioRol.php';
require_once '../../model/classes/UsuarioRol.php';
require_once '../../controller/services/AbmRol.php';
require_once '../../model/classes/Rol.php';

$datos = darDatosSubmitted();
$salida = [];

if (isset($datos['usemail']) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $datos['usemail'];

    $objAbmUsuario = new AbmUsuario();

    try {
        $usuario = $objAbmUsuario->buscarUsuario("usemail='" . $email . "'");

        if ($usuario) {
            $resultado = $objAbmUsuario->borrarLogico($usuario->getIdUsuario());

            if ($resultado) {
                $salida['resp'] = 'Éxito';
                $salida['mensaje'] = 'Usuario borrado bien';
            } else {
                $salida['resp'] = 'Error';
                $salida['mensaje'] = 'ERrror al borrar usduario';
                http_response_code(500);
            }
        } else {
            $salida['resp'] = 'Error';
            $salida['mensaje'] = 'No encontrado';
            http_response_code(404);
        }
    } catch (Exception $e) {
        $salida['resp'] = 'Error';
        $salida['mensaje'] = 'Error: ' . $e->getMessage();
        http_response_code(500);
    }
} else {
    $salida['resp'] = 'Faltan datos';
    $salida['mensaje'] = 'Faltan datos';
    http_response_code(400);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>ASction del borrado</title>
</head>

<body>
    <div style="margin-top: 50px;">
        <?php if (isset($salida['resp']) && $salida['resp'] === 'Éxito'): ?>
            <div>
                <div>Borradisimo pa</div>
                <p><?php echo htmlspecialchars($salida['mensaje']); ?></p>
            </div>
        <?php else: ?>
            <div>
                <div>Error</div>
                <p><?php echo htmlspecialchars($salida['mensaje']); ?></p>
            </div>
        <?php endif; ?>

        <a href="../../../index.php">
            volver
        </a>
    </div>
</body>

</html>