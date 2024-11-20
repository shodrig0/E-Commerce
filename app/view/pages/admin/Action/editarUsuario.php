<?php
require_once('../../../../config.php');
require_once('../../../model/Usuario.php');
require_once('../../../controller/AbmUsuario.php');
require_once('../../../model/UsuarioRol.php');
require_once('../../../controller/AbmUsuarioRol.php');
require_once('../../../model/Rol.php');
require_once('../../../controller/AbmRol.php');

if (isset($_POST['idUsuario'])) {
    $idUsuario = $_POST['idUsuario'];
    $abmUsuario = new AbmUsuario();
    $cond = "idusuario = " . $idUsuario;
    $usuario = $abmUsuario->buscarUsuario($cond);

    $abmUsuarioRol = new AbmUsuarioRol();
    $abmRol = new AbmRol();

    $colUsRol = $abmUsuarioRol->buscarUsuarioRol($idUsuario); // Roles asignados
    $rolesAsignados = [];
    foreach ($colUsRol as $usRol) {
        $rolesAsignados[] = $usRol->getRol();
    }

    $rolesDisponibles = $abmRol->listarRoles();

    if ($usuario) {
        ?>
        <form id="formEditarUsuario" class="ui form">
            <h4><i class="tag icon"></i>ID del Usuario: <?php echo htmlspecialchars($idUsuario); ?></h4>
            <input type="hidden" value="<?php echo $idUsuario ?>" name="idUsuario" id="idUsuario">
            <h4 class="ui dividing header">Editar Usuario</h4>
            <div class="field">
                <label>Nombre</label>
                <input type="text" name="usNombre" value="<?php echo htmlspecialchars($usuario->getUsNombre()); ?>">
            </div>
            <div class="field">
                <label>Email</label>
                <input type="email" name="usMail" value="<?php echo htmlspecialchars($usuario->getUsMail()); ?>">
            </div>
            <div class="field">
                <label>Roles Asignados</label>
                <div class="ui list">
                    <?php foreach ($rolesAsignados as $rol): ?>
                        <div class="item">
                            <div class="content">
                                <span><?php echo htmlspecialchars($rol->getRoDescripcion()); ?></span>
                                <?php if (count($rolesAsignados) > 1): ?>
                                    <button type="button" class="ui red button mini"
                                        onclick="eliminarRol(<?php echo $rol->getIdRol(); ?>, <?php echo $idUsuario; ?>)">
                                        Eliminar
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="field">
                <label>Agregar Roles</label>
                <?php if (count($rolesDisponibles) !== count($rolesAsignados)) { ?>
                    <select name="roles" id="roles">
                        <option value="0" selected>Seleccionar</option>
                        <?php foreach ($rolesDisponibles as $rol): ?>
                            <?php if (!in_array($rol, $rolesAsignados)): ?>
                                <option value="<?php echo $rol->getIdRol(); ?>">
                                    <?php echo htmlspecialchars($rol->getRoDescripcion()); ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                <?php } else { ?>
                    <div class="ui green message">Todos los Roles disponibles se le han sido asignados a este usuario</div>
                <?php } ?>
            </div>


            <button type="button" class="ui button primary" onclick="guardarCambios()">Guardar</button>
        </form>
        <?php
    } else {
        echo "<p>Usuario no encontrado.</p>";
    }
} else {
    echo "<p>ID de usuario no proporcionado.</p>";
}
?>
<script></script>