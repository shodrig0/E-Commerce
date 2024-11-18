<?php
require_once('../layouts/header.php');
require_once('../../../config.php');
include_once '../../controller/AbmRol.php';
include_once '../../model/Rol.php';

$objAbmRol = new AbmRol();
$roles = $objAbmRol->listarRoles();
?>
<link rel="stylesheet" href="../../../Semantic-UI/dist/semantic.min.css">

<div class="ui middle aligned center aligned grid" style="height: 100vh; margin: 0;">
    <div class="column" style="max-width: 450px;">
        <h2 class="ui teal header">
            <i class="user plus icon"></i>
            <div class="content">
                Registrar Usuario
            </div>
        </h2>
        <form class="ui large form" method="post" action="./Action/actionRegistrarUsuario.php" name="formulario" id="formulario">
            <input id="accion" name="accion" value="login" type="hidden">

            <div class="field">
                <label for="usnombre">Nombre:</label>
                <div class="ui left icon input">
                    <i class="user icon"></i>
                    <input id="usnombre" name="usnombre" type="text" placeholder="Ingresa tu nombre">
                </div>
            </div>

            <div class="field">
                <label for="usemail">Email:</label>
                <div class="ui left icon input">
                    <i class="mail icon"></i>
                    <input name="usemail" id="usemail" type="email" placeholder="example@example.com" aria-label="example">
                </div>
            </div>

            <div class="field">
                <label for="uspass">Contraseña:</label>
                <div class="ui left icon input">
                    <i class="lock icon"></i>
                    <input id="uspass" name="uspass" type="password" placeholder="Ingresa tu contraseña">
                </div>
            </div>

            <div class="field">
                <label for="rol">Rol:</label>
                <select name="rol" id="rol" class="ui dropdown">
                    <option value="">Selecciona un Rol</option>
                    <?php foreach ($roles as $rol): ?>
                        <option value="<?php echo htmlspecialchars($rol->getIdRol()); ?>">
                            <?php echo htmlspecialchars($rol->getRoDescripcion()); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button class="ui teal fluid large button" type="submit" onclick="formSubmit()">Registrar</button>
        </form>

        <div class="ui message" id="formMessage" style="display: none;"></div>
    </div>
</div>

<script>
    $('.ui.dropdown').dropdown();
</script>
<script src="../js/api.js"></script>