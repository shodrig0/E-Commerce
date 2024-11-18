function accionesBtns() {
    $(document).off('click', '.accion-btns').on('click', '.accion-btns', function () {
        let action = $(this).data('action')
        let userId = $(this).data('id')

        console.log('Botón presionado:', action, 'ID:', userId)

        switch (action) {
            case 'editar':
                console.log('Editando usuario con ID:', userId)
                $.ajax({
                    url: './Action/editarUsuario.php',
                    type: 'POST',
                    data: { idUsuario: userId },
                    success: function (response) {
                        $('#cargarCont').html(response)
                    },
                    error: function () {
                        alert('Hubo un error al cargar los datos del usuario.');
                    }
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
                break
            }
    })
}

$(document).ready(function () {
    accionesBtns()
})