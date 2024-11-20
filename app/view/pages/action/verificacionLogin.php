<?php

require_once '../../../../config.php';
require_once '../../layouts/header.php';

$datos = darDatosSubmitted();

try {
    if (empty($datos['usnombre']) || empty($datos['uspass'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Faltan datos obligatorios'
        ]);
        exit();
    }

    $session = Session::getInstance();
    $nombre = $datos['usnombre'];
    $password = $datos['uspass'];
    var_dump("Datos procesados: ", $datos);

    if ($session->iniciar($nombre, $password)) {
        echo json_encode([
            'status' => 'ok',
            'message' => 'Sesion iniciada correctamente'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Usuario o pass incorrectos'
        ]);
    }
} catch (PDOException $e) {
    // var_dump("Error en login: " . $e->getMessage());
    echo json_encode([
        'status' => 'error',
        'message' => 'Ocurrió un problema en el servidor'
    ]);
}
?>

<body>
    <div class="ui container" style="margin-top: 20px;">
        <div class="ui grid" style="display: flex; justify-content: center; gap: 10px;">
            <form action="cerrar.php" method="post">
                <button type="submit" class="ui red button animated fade">
                    <div class="visible content">Cerrar Sesión</div>
                    <div class="hidden content">
                        <i class="power off icon"></i>
                    </div>
                </button>
            </form>
            <a href="../../home/home.php" class="ui blue button animated fade">
                <div class="visible content center">&nbsp;&nbsp;Volver</div>
                <div class="hidden content">
                    <i class="arrow left icon"></i>
                </div>
            </a>
        </div>
        <div class="ui field container" style="margin-top: 20px;">
            <?php if (isset($mensaje)) echo $mensaje; ?>
        </div>
    </div>
</body>

</html>