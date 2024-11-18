<?php 
require_once('../../../../config.php');
require_once('../../../model/Usuario.php');
require_once('../../../controller/AbmUsuario.php');
require_once '../../../controller/AbmUsuarioRol.php';
require_once '../../../model/UsuarioRol.php';
require_once '../../../controller/AbmRol.php';
require_once '../../../model/Rol.php';

$datos = darDatosSubmitted();
$abmUsuario = new AbmUsuario();
$mensaje = $abmUsuario->modificarUsuario();

?>
<body>
    <div class="ui container">
        <h2 class="ui header">Modificar Usuario</h2>
        <?php if (!empty($mensaje)): ?>
            <?php if (strpos($mensaje, 'exitosamente') !== false): ?>
                <div class="ui positive message">
                    <i class="close icon"></i>
                    <div class="header">Éxito</div>
                    <p><?= $mensaje; ?></p>
                </div>
            <?php elseif (strpos($mensaje, 'Error') !== false): ?>
                <div class="ui negative message">
                    <i class="close icon"></i>
                    <div class="header">Error</div>
                    <p><?= $mensaje; ?></p>
                </div>
            <?php else: ?>
                <div class="ui info message">
                    <i class="close icon"></i>
                    <div class="header">Información</div>
                    <p><?= $mensaje; ?></p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <script>
        // Permitir cerrar mensajes
        $('.message .close').on('click', function() {
            $(this).closest('.message').transition('fade');
        });
    </script>
</body>
</html>
