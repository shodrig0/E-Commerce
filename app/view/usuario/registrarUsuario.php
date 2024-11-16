<?php
require_once('../../../config.php');
include_once '../layouts/header.php';
include_once '../../controller/AbmRol.php';
include_once '../../model/Rol.php';
include_once '../../model/connection/BaseDatos.php';

$objAbmRol = new AbmRol();
$roles = $objAbmRol->listarRoles();
?>


<div class="ui middle aligned center aligned grid" style="height: 100vh; margin: 0;">
    <div class="column" style="max-width: 450px;">
        <h2 class="ui teal image header">
            <div class="content">
                Registrar Usuario
            </div>
        </h2>
        <div class="ui stacked segment">
            <form method="post" action="Action/actionRegistrarUsuario.php" name="formulario" id="formulario" class="ui form">
                <input id="accion" name="accion" value="login" type="hidden">
                
                <div class="field">
                    <label for="usnombre">Nombre:</label>
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input id="usnombre" name="usnombre" type="text" placeholder="Nombre de usuario">
                    </div>
                </div>

                <div class="field">
                    <label for="usmail">Email:</label>
                    <div class="ui left icon input">
                        <i class="envelope icon"></i>
                        <input name="usmail" id="usmail" type="text" placeholder="example@example.com" aria-label="example">
                    </div>
                </div>

                <div class="field">
                    <label for="uspass">Contraseña:</label>
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input id="uspass" name="uspass" type="password" placeholder="Contraseña">
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

                <button type="button" class="ui teal fluid large button" onclick="formSubmit()">Registrar</button>
            </form>
        </div>

        <div class="ui message">
            ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a>
        </div>
    </div>
</div>

<script src="../js/hasheo.js"></script>
<script src="../../../Semantic-UI/dist/semantic.min.js"></script>
<script>
    // Inicialización del dropdown de Semantic UI
    $('.ui.dropdown').dropdown();
</script>
