<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';

header('Content-Type: text/html; charset=utf-8');

$datos = darDatosSubmitted();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idUsuario'])) {
    $idUsuario = intval($_POST['idUsuario']);

    $abmUsuario = new ABMUsuario(); 

    $resultado = $abmUsuario->borrarLogico($idUsuario);

    if ($resultado) {
        $mensaje = "El usuario ha sido deshabilitado correctamente. Ya no tiene acceso al sistema.";
        $claseMensaje = "success";
    } else {
        $mensaje = "Hubo un problema al intentar deshabilitar al usuario. Por favor, inténtalo nuevamente.";
        $claseMensaje = "error";
    }
} else {
    $mensaje = "Petición inválida. No se encontró el ID del usuario.";
    $claseMensaje = "error";
}

?>
    <head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .mensaje {
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 500px;
            text-align: center;
        }

        .success {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }

        .error {
            background-color: #F44336;
            color: white;
            border: 1px solid #F44336;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            text-decoration: none;
            color: white;
            background-color: #2196F3;
            border-radius: 5px;
        }

        a:hover {
            background-color: #0b7dda;
        }
    </style>
</head>

    <div class="mensaje <?php echo $claseMensaje; ?>">
        <p><?php echo $mensaje; ?></p>
        <!-- <a href="../../../index.php">Volver al inicio</a> -->
    </div>
