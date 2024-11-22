function accionesBtns() {
    $(document).off('click', '.accion-btns').on('click', '.accion-btns', function () {
        let action = $(this).data('action')
        let userId = $(this).data('id') || null

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
                                console.log('Respuesta del servidor:', response)
                                $('#modalCerrarSesion').modal('hide')
                                setTimeout(function () {
                                    window.location.href = BASE_URL + 'app/view/home/home.php'
                                }, 1000)
                            },
                            error: function () {
                                alert('Error al intentar cerrar sesión.')
                            },
                        })
                    })
                break
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


function crearFormularioEdicion(usuario, roles) {
    const form = $('<form>', {
        id: 'formEditarUsuario',
        class: 'ui form',
    });

    form.append(crearCampoSoloLectura('ID Usuario', usuario.idUsuario, 'user'));
    form.append(crearCampoSoloLectura('Nombre', usuario.usnombre, 'id badge'));
    form.append(crearCampoSoloLectura('Email', usuario.usmail, 'envelope'));

    const rolesAsignadosContainer = $('<div>', { class: 'field' });
    rolesAsignadosContainer.append($('<label>').html('<i class="tag icon"></i> Roles Asignados'));
    const listaRolesAsignados = crearListaRolesAsignados(usuario);
    rolesAsignadosContainer.append(listaRolesAsignados);
    form.append(rolesAsignadosContainer);

    const rolesDisponiblesContainer = $('<div>', { class: 'field' });
    rolesDisponiblesContainer.append($('<label>').html('<i class="plus icon"></i> Roles Disponibles'));
    const listaRolesDisponibles = crearListaRolesDisponibles(roles, usuario.usrol, usuario.idUsuario);
    rolesDisponiblesContainer.append(listaRolesDisponibles);
    form.append(rolesDisponiblesContainer);

    $('#cargarCont').html(form);

    $('.ui.dropdown').dropdown();
    $('.ui.checkbox').checkbox();
}

function crearCampoSoloLectura(label, value, icon) {
    const field = $('<div>', { class: 'field' });
    field.append($('<label>').html(`<i class="${icon} icon"></i> ${label}`));
    const inputContainer = $('<div>', { class: 'ui disabled input' });
    inputContainer.append($('<input>', { type: 'text', value: value, readonly: true }));
    field.append(inputContainer);
    return field;
}

function crearListaRolesAsignados(usuario) {
    const lista = $('<div>', { class: 'ui list' });

    usuario.usrol.forEach((rol) => {
        const item = $('<div>', { class: 'item', style: 'display: flex;' });

        const content = $('<div>', { style: 'display: flex;' });
        content.append($('<i>', { class: 'tag icon', style: 'margin-right: 8px;' }));
        content.append($('<div>', { class: 'content', text: rol.nombreRol }));

        const botonEliminar = $('<button>', {
            type: 'button',
            class: 'ui red button mini',
            text: 'Eliminar',
            click: function (event) {
                event.preventDefault(); // Evita recargar la página
                eliminarRolAsignado(rol.idRol, usuario.idUsuario);
            },
        });


        item.append(content);
        item.append(botonEliminar);
        lista.append(item);
    });

    return lista;
}


function crearListaRolesDisponibles(roles, usrol, idUsuario) {
    const idsAsignados = usrol.map((rol) => rol.idRol);
    const lista = $('<div>', { class: 'ui list' });

    roles.forEach((rol) => {
        if (!idsAsignados.includes(rol.idRol)) {
            const item = $('<div>', { class: 'item', style: 'display: flex;' });

            const content = $('<div>', { style: 'display: flex;' });
            content.append($('<i>', { class: 'plus circle green icon', style: 'margin-right: 8px;' }));
            content.append($('<div>', { class: 'content', text: rol.nombreRol }));

            const botonAgregar = $('<button>', {
                type: 'button',
                class: 'ui green button mini',
                text: 'Agregar',
                click: function (event) {
                    event.preventDefault();
                    agregarRolAsignado(rol.idRol, idUsuario);
                },
            });

            item.append(content);
            item.append(botonAgregar);
            lista.append(item);
        }
    });

    return lista;
}

function confirmarOperacion(mensaje, callback) {
    $('#mensajeConfirmacion').text(mensaje);

    $('#cancelarOperacion').off('click').on('click', function (event) {
        event.preventDefault();
        $('#modalConfirmacion').modal('hide');
    });

    $('#confirmarOperacion').off('click').on('click', function (event) {
        event.preventDefault();
        $('#modalConfirmacion').modal('hide');
        callback();
    });

    // Mostrar el modal
    $('#modalConfirmacion').modal({
        closable: false,
    }).modal('show');
}

function eliminarRolAsignado(idRol, idUsuario) {
    confirmarOperacion('¿Estás segurx de que quieres eliminar este rol?', function () {
        $.ajax({
            url: './Action/actionEliminarRolUsuario.php',
            type: 'POST',
            data: { idRol: idRol, idUsuario: idUsuario },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#modalResultadoIcon').attr('class', 'check circle green icon');
                    $('#modalResultadoMensaje').text('El rol ha sido eliminado correctamente.');

                    $('#modalResultado')
                        .modal('show');

                    setTimeout(function () {
                        location.reload()
                    }, 2000)
                } else {
                    $('#modalResultadoIcon').attr('class', 'exclamation triangle red icon');
                    $('#modalResultadoMensaje').text(response.message || 'Hubo un error al eliminar el rol.');

                    $('#modalResultado').modal('show');
                }
            },
            error: function () {
                alert('Error en la comunicación con el servidor.');
            },
        });
    });
}

function agregarRolAsignado(idRol, idUsuario) {
    confirmarOperacion('¿Estás segurx de que quieres agregar este rol?', function () {
        $.ajax({
            url: './Action/actionAgregarRolUsuario.php',
            type: 'POST',
            data: { idRol: idRol, idUsuario: idUsuario },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#modalResultadoIcon').attr('class', 'check circle green icon');
                    $('#modalResultadoMensaje').text('El rol ha sido agregado correctamente.');

                    $('#modalResultado')
                        .modal('show');

                    setTimeout(function () {
                        location.reload()
                    }, 2000)
                } else {
                    $('#modalResultadoIcon').attr('class', 'exclamation triangle red icon');
                    $('#modalResultadoMensaje').text(response.message || 'Hubo un error al agregar el rol.');

                    $('#modalResultado').modal('show');
                }
            },
            error: function () {
                alert('Error en la comunicación con el servidor.');
            },
        });
    });
}

/**
 * function accionesBtns() {
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

 */