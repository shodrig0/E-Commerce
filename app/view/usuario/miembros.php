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
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo htmlspecialchars($usuario->getIdUsuario()); ?></td>
                <td><?php echo htmlspecialchars($usuario->getUsNombre()); ?></td>
                <td><?php echo htmlspecialchars($usuario->getUsMail()); ?></td>
                <td><?php echo $usuario->getUsDeshabilitado() === null ? "Miembro Habilitado" : htmlspecialchars($usuario->getUsDeshabilitado()); ?></td>
                <td>
                    <?php
                    $objUsRol = new AbmUsuarioRol();
                    $colUsRol = $objUsRol->buscarUsuarioRol($usuario->getIdUsuario());
                    $roles = [];
                    foreach ($colUsRol as $usRol) {
                        $roles[] = $usRol->getRol()->getRoDescripcion();
                    }
                    $rolesString = implode(", ", $roles);
                    ?>
                    <div class="ui list"><?php echo htmlspecialchars($rolesString); ?></div>
                </td>
                <td>
                    <button class="ui button accion-btns" data-action="editar" data-id="<?php echo htmlspecialchars($usuario->getIdUsuario()); ?>">Editar</button>
                    <button class="ui button accion-btns" data-action="eliminar" data-id="<?php echo htmlspecialchars($usuario->getIdUsuario()); ?>">Eliminar</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div id="cargarCont" class="ui segment"></div>

<script src="../js/btns.js"></script>
