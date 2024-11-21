<form id="formEditarUsuario" class="ui form">
    <div class="field">
        <label><i class="user icon"></i> ID Usuario</label>
        <div class="ui disabled input">
            <input type="text" value="" readonly>
        </div>
    </div>
    <div class="field">
        <label><i class="id badge icon"></i> Nombre</label>
        <div>NOMBRE</div>
    </div>
    <div class="field">
        <label><i class="envelope icon"></i> Email</label>
        <div class="ui disabled input">
            <input type="text" value="{EMAIL_USUARIO}" readonly>
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
