<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';

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
    // var_dump("Datos procesados: ", $datos);

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

    <div class="ui field container" style="margin-top: 20px;">
        <?php if (isset($mensaje)) echo $mensaje; ?>
    </div>

</body>

<?php footer(); ?>