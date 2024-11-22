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
                <td><?php echo $usuario->getUsDeshabilitado() === null ? "Miembro Habilitado" : $usuario->getUsDeshabilitado(); ?></td>
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
                    <button class="ui button accion-btns" data-action="editar" data-id="<?php echo htmlspecialchars($usuario->getIdUsuario()); ?>" 
                    <?php if (!(is_null($usuario->getUsDeshabilitado()))) { echo htmlspecialchars("disabled");} ?>>Editar</button>
                    <?php if (!is_null($usuario->getUsDeshabilitado())): ?>
                        <button class="ui button accion-btns" data-action="alta" data-id="<?php echo htmlspecialchars($usuario->getIdUsuario()); ?>">Dar de Alta</button>
                    <?php else: ?>
                        <button class="ui button accion-btns" data-action="eliminar" data-id="<?php echo htmlspecialchars($usuario->getIdUsuario()); ?>">Dar de Baja</button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div id="cargarCont" class="ui segment"></div>
<div class="ui modal" id="modalResultado">
    <div class="header">Resultado de la Acción</div>
    <div class="content">
        <i id="modalResultadoIcon" class="check circle green icon"></i>
        <span id="modalResultadoMensaje"></span>
    </div>
</div>
<div id="modalConfirmacion" class="ui modal">
    <div class="header">Confirmar operación</div>
    <div class="content">
        <p id="mensajeConfirmacion"></p>
    </div>
    <div class="actions">
        <button class="ui button red" id="cancelarOperacion">Cancelar</button>
        <button class="ui button green" id="confirmarOperacion">Confirmar</button>
    </div>
</div>
<script src="../../js/btns.js"></script>
<script src="../../js/eliminarRol.js"></script>
<?php footer(); ?>