<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';
?>

<div class="ui container">
    <div class="ui container">
    <div class="ui segment">
        <h2 class="ui header"><i class="user icon"></i> Perfil de Usuario</h2>
        <div class="ui grid stackable">
            <div class="sixteen wide column">
                <div id="datosUsuario" class="ui raised fluid card">
                    <div class="content">
                        <div class="header" style="font-size: 2em; display: flex; align-items: center;">
                            <i class="user circle icon" style="font-size: 1.7em; margin-right: 10px; margin-top: 10px; color: #4183c4;"></i> 
                            <?= htmlspecialchars($usuario->getUsNombre()) ?>
                        </div>
                        <div class="ui divider"></div>
                        <div class="meta" style="font-size: 1.2em;">
                            <p><i class="mail icon"></i> 
                               <strong>Email:</strong> <?= htmlspecialchars(substr($usuario->getUsMail(), 0, 3)) . '***' . htmlspecialchars(substr($usuario->getUsMail(), -3)) ?>
                            </p>
                        </div>
                        <div class="description" style="font-size: 1.2em;">
                            <p><i class="lock icon"></i> 
                               <strong>Contraseña:</strong> <span style="color: gray;">********</span>
                            </p>
                        </div>
                    </div>
                    <div class="extra content" style="text-align: center;">
                        <button id="editarBtn" class="ui huge blue button">
                            <i class="edit outline icon"></i> Editar Datos
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="formularioEdicion" style="display: none;">
            <form id="formEditarUsuario" class="ui form">
                <h3 class="ui dividing header"><i class="edit icon"></i> Editar Datos</h3>
                <input type="hidden" name="idUsuario" id="idUsuario" value="<?= htmlspecialchars($usuario->getIdUsuario()) ?>">
                <div class="field">
                    <label for="usnombre"><i class="user icon"></i> Nombre</label>
                    <input type="text" name="usnombre" id="usnombre" value="<?= htmlspecialchars($usuario->getUsNombre()) ?>" required>
                </div>

                <div class="field">
                    <label for="usmail"><i class="mail icon"></i> Email</label>
                    <input type="email" name="usmail" id="usmail" value="<?= htmlspecialchars($usuario->getUsMail()) ?>" required>
                </div>

                <div class="field">
                    <label for="uspass"><i class="lock icon"></i> Contraseña</label>
                    <input type="password" name="uspass" id="uspass" placeholder="Dejar vacío para no cambiarla">
                </div>

                <div class="ui buttons">
                    <button type="submit" class="ui green button"><i class="save icon"></i> Guardar Cambios</button>
                    <div class="or"></div>
                    <button type="button" id="cancelarBtn" class="ui red button"><i class="times icon"></i> Volver</button>
                </div>
            </form>
        </div>
    </div>
    <div class="ui modal" id="modalMensaje">
        <div class="header" id="modalHeader"></div>
        <div class="content" id="modalContent"></div>
        <div class="actions">
            <button class="ui blue button" id="modalCerrar">Aceptar</button>
        </div>
    </div>
</div>
<script src="../js/perfil.js"></script>
<script src="../js/api.js"></script>
<?php footer(); ?>
