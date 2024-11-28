<div class="ui container" style="max-width: 800px; margin-top: 20px;">
    <div id="listaRoles">
        <h2 class="ui teal header">
            <i class="list icon"></i>
            <div class="content">Lista de Roles</div>
        </h2>

        <div id="roles-editar" class="ui five column grid">
        </div>
    </div>

    <div id="formularioEdicion" class="ui container segment raised"
        style="max-width: 600px; margin-top: 20px; display: none;">
        <h2 class="ui yellow header">
            <i class="edit icon"></i>
            <div class="content">Modificar Rol</div>
        </h2>

        <form class="ui form" id="modificarRolForm">
            <input type="hidden" name="roleId" id="roleId">

            <div class="field">
                <label><i class="tag icon"></i> Nombre del Rol</label>
                <input type="text" name="nombre" id="nombreRol" required>
            </div>

            <div class="field">
                <label><i class="info circle icon"></i> Descripción</label>
                <textarea name="descripcion" id="descripcionRol"></textarea>
            </div>

            <button type="submit" class="ui large yellow button fluid">
                <i class="save icon"></i> Guardar Cambios
            </button>
        </form>
    </div>
</div>
<div class="ui modal" id="modalResponse">
    <div class="header">Resultado del Registro</div>
    <div class="content" id="contModal"></div>
</div>
<div class="ui modal" id="modalConfirmacionBorrar">
    <div class="header">Confirmación de Borrado</div>
    <div class="content">
        <p>¿Estás seguro de que deseas borrar este rol?</p>
    </div>
    <div class="actions">
        <div class="ui red deny button">Cancelar</div>
        <div class="ui green approve button">Sí, borrar</div>
    </div>
</div>

<script src="../../js/enviarFormulario.js"></script>
<script>
    $(document).ready(function () {
        cargarRoles();
        function cargarRoles() {
            $.ajax({
                url: './action/listarRoles.php',
                method: 'POST',
                dataType: 'json',
                success: function (response) {
                    if (response.roles && response.roles.length > 0) {
                        mostrarRoles(response.roles);
                    } else {
                        console.log("No se encontraron roles.");
                    }
                },
                error: function (error) {
                    console.log("Error en la solicitud AJAX", error);
                }
            });
        }

        function mostrarRoles(roles) {
            $('#roles-editar').empty();
            roles.forEach(function (role) {
                let divRole = $('<div>').addClass('column');
                let card = $('<div>').addClass('ui card');
                let id = role.idrole;

                let infoRole = $('<div>')
                    .addClass('content')
                    .css({
                        'min-height': '140px',
                        'overflow-y': 'auto'
                    });

                let titulo = $('<a>').addClass('header').text(role.rolnombre);
                let descripcion = $('<p>').text(role.roldescripcion);

                let masContenido = $('<div>').addClass('extra content');
                let idRole = $('<p>').html('<i class="tag icon"></i> ID: ' + id);

                let botonEditar = $('<button>').addClass('ui yellow button').text(`Editar`).click(function () {
                    mostrarFormularioEdicion(id);
                });

                let botonBorrar = $('<button>').addClass('ui red button').text(`Borrar`).click(function () {
                    $('#modalConfirmacionBorrar').modal('show'); 
                    $('#modalConfirmacionBorrar').data('roleId', id); 
                });

                infoRole.append(titulo, descripcion);
                masContenido.append(idRole);
                card.append(infoRole, masContenido, botonEditar, botonBorrar);
                divRole.append(card);
                $('#roles-editar').append(divRole);
            });
        }

        function mostrarFormularioEdicion(idRole) {
            $('#formularioEdicion').show();

            $.ajax({
                url: './action/actionModificarRol.php',
                type: 'POST',
                data: {roleId: idRole},
                success: function (data) {
                    let jsonResponse = JSON.parse(data);
                    if (jsonResponse.status == "success") {
                        $('#roleId').val(jsonResponse.data.id);
                        $('#descripcionRol').val(jsonResponse.data.descripcion);
                    }
                }
            });
        }
    });
</script>
