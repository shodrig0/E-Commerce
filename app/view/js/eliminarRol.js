function eliminarRol(idRol, idUsuario) {
    if (confirm("¿Estás seguro de eliminar este rol?")) {
        $.ajax({
            url: '../usuario/Action/eliminarRol.php',
            method: 'POST',
            data: { idRol: idRol, idUsuario: idUsuario },
            success: function (response) {
                alert(response);
                location.reload();
            },
            error: function () {
                alert('Error al eliminar el rol.');
            }
        });
    }
}

function guardarCambios() {
    $.ajax({
        url: '../usuario/Action/actionActualizarUsuario.php',
        method: 'POST',
        data: $('#formEditarUsuario').serialize(),
        success: function (response) {
            // Mostrar y llenar el div con la respuesta
            $('#cargarCont').html(response).fadeIn();
        },
        error: function () {
            $('#cargarCont').html('<div class="ui negative message">Error al guardar los cambios.</div>').fadeIn();
        }
    });
}



function borradoLogico(userId) {
    if (confirm('¿Borrar?')) {
        $.ajax({
            url: '../usuario/Action/actionEliminarUsuario.php',
            type: 'POST',
            data: { idUsuario: userId },
            success: function (response) {
                console.log('Respuesta del servidor:', response)
                try {
                    const res = JSON.parse(response)
                    if (res.success) {
                        $('#cargarCont').html('<div class="ui success message">' + res.message + '</div>')
                    } else {
                        $('#cargarCont').html('<div class="ui error message">' + res.message + '</div>')
                    }
                    setTimeout(function (){
                        location.reload()
                    }, 2000)
                } catch (e) {
                    console.error('Error al procesar la respuesta:', e);
                    $('#cargarCont').html('<div class="ui error message">Error.</div>')
                }
            },
            error: function () {
                alert('Hubo un error al intentar deshabilitar al usuario.')
            }
        })
    }
}

// function 