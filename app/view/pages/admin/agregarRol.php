<div class="ui container segment raised" style="max-width: 600px; margin-top: 20px;">
    <h2 class="ui teal header">
        <i class="user plus icon"></i>
        <div class="content">Agregar Rol</div>
    </h2>
    <form class="ui form" id="agregarRolForm">
        <div class="field">
            <label><i class="tag icon"></i> Nombre del Rol</label>
            <input type="text" name="nombre" placeholder="Ejemplo: Administrador" required>
        </div>
        <button type="submit" class="ui large teal button fluid">
            <i class="plus icon"></i> Agregar Rol
        </button>
    </form>
    <div id="mensajeResultado" style="margin-top: 20px;"></div>
</div>
<script src="../js/enviarFormulario.js"></script>
<script>
$(document).ready(function () {
    manejarFormSubmit(
        "#agregarRolForm",                
        "./action/actionAgregarNuevoRol.php", 
        "./"          
    );
});
</script>
