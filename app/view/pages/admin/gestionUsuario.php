<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';


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
<div id="formularioEdicionUsuario">
    <form id="formEditarUsuario" class="ui form">
        <div class="field">
            <label><i class="user icon"></i> ID Usuario</label>
            <div class="ui disabled input">
                <input type="text" readonly>
            </div>
        </div>
        <div class="field">
            <label><i class="id badge icon"></i> Nombre</label>
            <input type="text" readonly>
        </div>
        <div class="field">
            <label><i class="envelope icon"></i> Email</label>
            <div class="ui disabled input">
                <input type="text" readonly>
            </div>
        </div>
        <div class="field">
            <label><i class="ban icon"></i> Deshabilitado</label>
            <div class="ui toggle checkbox">
                <input type="checkbox" name="usDeshabilitado" {DESHABILITADO_CHECKED}>
                <label>Deshabilitar Usuario</label>
            </div>
        </div>
        <div class="field">
            <label><i class="tag icon"></i> Roles</label>
            <div class="ui multiple selection dropdown">
                <input type="hidden" name="roles">
                <i class="dropdown icon"></i>
                <div class="default text">Seleccionar Roles</div>
                <div class="menu">
                    {OPCIONES_ROLES}
                </div>
            </div>
        </div>
        <button type="button" class="ui button primary" onclick="guardarCambios()">Guardar Cambios</button>
    </form>
</div>
<div id="cargarCont" class="ui segment"></div>

<script src="../../js/btns.js"></script>
<script src="../../js/eliminarRol.js"></script>