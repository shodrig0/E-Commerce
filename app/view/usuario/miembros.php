<?php
require_once('../../../config.php');
require_once('../../model/Usuario.php');
require_once('../../controller/AbmUsuario.php');
require_once '../../controller/AbmUsuarioRol.php';
require_once '../../model/UsuarioRol.php';
require_once '../../controller/AbmRol.php';
require_once '../../model/Rol.php';

$abmUsuario = new AbmUsuario();
$usuarios = $abmUsuario->listarUsuarios();
?>

<table class="ui celled table">
    <thead>
        <tr>
            <th>ID Usuario</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Deshabilitado</th>
            <th>Roles</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario->getIdUsuario()); ?></td>
                <td><?php echo htmlspecialchars($usuario->getUsNombre()); ?></td>
                <td><?php echo htmlspecialchars($usuario->getUsMail()); ?></td>
                <td><?php if ($usuario->getUsDeshabilitado() === null) {
                    echo "Miembro Habilitado";
                } else {
                    echo htmlspecialchars($usuario->getUsDeshabilitado());
                } ?>
                </td>
                <td>
                    <?php
                    $objUsRol = new AbmUsuarioRol();
                    $roles = $objUsRol->buscarUsuarioRol($usuario->getIdUsuario);
                    var_dump($roles);
                    foreach ($roles as $rolInd) {
                        $rolesString .= $rolInd->getRoDescripcion();
                    }
                    ?>
                    <div id="roles" class="ui list hidden"><?php echo htmlspecialchars($rolesString); ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>