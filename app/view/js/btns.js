function accionesBtns() {
    $(document).off('click', '.accion-btns').on('click', '.accion-btns', function () {
        let action = $(this).data('action')
        let userId = $(this).data('id')

        console.log('Botón presionado:', action, 'ID:', userId)

        switch (action) {
            case 'editar':
                console.log('Editando usuario con ID:', userId)
                $.ajax({
                    url: './Action/actionActualizarUsuario.php',
                    type: 'POST',
                    data: $.param({ idUsuario: userId, accion: "pedir_datos" }),
                    dataType: 'json',
                    success: function (response) {
                        if (response && response.success && response.usuario) {
                            crearFormularioEdicion(response.usuario, response.roles);
                        } else {
                            alert(response.message || 'Error: No se pudo obtener el usuario.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error en la solicitud:', status, error);
                        alert('Hubo un error al cargar los datos del usuario.');
                    },
                });                 
                break;
            case 'eliminar':
                console.log('Eliminando usuario con ID:', userId)
                $.ajax({
                    url: './Action/eliminarUsuario.php',
                    type: 'POST',
                    data: { idUsuario: userId },
                    success: function (response) {
                        $('#cargarCont').html(response)
                    },
                    error: function () {
                        alert('Hubo un error al cargar los datos del usuario.')
                    }
                })
                break;
            case 'cerrarSesion':
                console.log('Cerrando sesión');
                $('#modalCerrarSesion').modal('show');

                $('#confirmCerrarSesion').off('click').on('click', function () {
                    $.ajax({
                        url: BASE_URL + 'app/view/pages/action/actionLogout.php',
                        type: 'POST',
                        success: function (response) {
                            let iconClass, message, modalClass;

                            if (response.success) {
                                iconClass = 'check circle green icon';
                                message = response.message;
                                modalClass = 'ui basic modal';
                            } else {
                                iconClass = 'exclamation triangle red icon';
                                message = response.message;
                                modalClass = 'ui basic modal';
                            }

                            $('#modalResultadoIcon').attr('class', iconClass);
                            $('#modalResultadoMensaje').text(message);

                            $('#modalResultado')
                                .modal({
                                    closable: false,
                                    onHidden: function () {
                                        window.location.href = BASE_URL + 'app/view/home/home.php';
                                    }
                                })
                                .modal('show');
                            setTimeout(function () {
                                $('#modalResultado').modal('hide');
                            }, 3000);
                        },
                        error: function () {
                            $('#modalResultadoIcon').attr('class', 'exclamation triangle red icon');
                            $('#modalResultadoMensaje').text('Error en la comunicación con el servidor.');
                            $('#modalResultado')
                                .modal({
                                    closable: false,
                                    onHidden: function () {
                                        window.location.href = BASE_URL + 'app/view/home/home.php';
                                    }
                                })
                                .modal('show');

                            setTimeout(function () {
                                $('#modalResultado').modal('hide');
                            }, 2000);
                        }
                    });
                });
                break;
        }
    })
}

function confirmarCerrarSesion(event) {
    event.preventDefault();
    $('#modalCerrarSesion').modal('show');
}

$(document).ready(function () {
    accionesBtns()
})
