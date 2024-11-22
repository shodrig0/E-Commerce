<?php

header('Content-Type: text/html; charset=utf-8');

require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';

$datos = darDatosSubmitted();  // Asegúrate de que esto obtiene los datos correctamente

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idUsuario'])) {
    $idUsuario = intval($_POST['idUsuario']);

    $abmUsuario = new ABMUsuario();

    $resultado = $abmUsuario->habilitarUsuario($idUsuario);

    // Comprobar el resultado de la operación
    if ($resultado) {
        $mensaje = "El usuario ha sido habilitado correctamente. Ahora tiene acceso al sistema.";
        $claseMensaje = "success";  // Clase para mensaje exitoso
    } else {
        $mensaje = "Hubo un problema al intentar habilitar al usuario. Por favor, inténtalo nuevamente.";
        $claseMensaje = "error";  // Clase para mensaje de error
    }
} else {
    // Si no se encuentra el idUsuario, mensaje de error
    $mensaje = "Petición inválida. No se encontró el ID del usuario.";
    $claseMensaje = "error";  // Clase para mensaje de error
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de la Acción</title>
    <style>
        .success {
            background-color: #21ba45;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin: 20px;
        }
        .error {
            background-color: #db2828;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin: 20px;
        }
    </style>
</head>
<body>
    <div class="ui container">
        <div class="ui message <?php echo $claseMensaje; ?>">
            <div class="header">
                <?php echo $mensaje; ?>
            </div>
        </div>
    </div>
</body>
</html>
