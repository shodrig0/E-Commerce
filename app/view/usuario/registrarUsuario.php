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
        <div class="ui segment">
            <form method="post" action="./Action/actionRegistrarUsuario.php" name="formulario" id="formulario">
                <input id="accion" name="accion" value="login" type="hidden">
                <div>
                    <div>
                        <div>
                            <label for="nombre">Nombre:</label>
                            <div>
                                <input id="usnombre" name="usnombre" type="text">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input name="usemail" id="usemail" type="text" placeholder="example@example.com" aria-label="example">
                    </div>
                </div>

                <div>
                    <div>
                        <div>
                            <label for="uspass">Pass:</label>
                            <div>
                                <input id="uspass" name="uspass" type="password">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div>
                        <label for="rol">Rol:</label>
                    </div>
                    <select name="rol" id="rol">
                        <option value="">Selecciona Rol</option>
                        <?php foreach ($roles as $rol): ?>
                            <option value="<?php echo htmlspecialchars($rol->getIdRol()); ?>">
                                <?php echo htmlspecialchars($rol->getRoDescripcion()); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                </div>
                <input type="button" value="Registrar" onclick="formSubmit()">
            </form>
        </div>
    </div>
</div>

<script src="../js/api.js">

</script>