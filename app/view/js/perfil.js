$(document).ready(function () {
    $('#editarBtn').on('click', function () {
        $('#datosUsuario').hide();
        $('#formularioEdicion').show();
    });
    $('#cancelarBtn').on('click', function () {
        $('#formularioEdicion').hide();
        $('#datosUsuario').show();
    });
});


$(document).ready(function () {
    $("#editarBtn").on("click", function () {
        $("#datosUsuario").hide();
        $("#formularioEdicion").fadeIn();
    });
    $("#cancelarBtn").on("click", function () {
        $("#formularioEdicion").fadeOut(function () {
            $("#datosUsuario").fadeIn();
        });
    });

    $("#formEditarUsuario").on("submit", async function (e) {
        e.preventDefault();
        let pass = $('#uspass').val()
        let hash = await hashPassword(pass, $("#usnombre").val());
        const formData = {
            idUsuario: $("#idUsuario").val(),
            usNombre: $("#usnombre").val(),
            usmail: $("#usmail").val(),
            uspass: hash
        };
        console.log(formData)
        $.ajax({
            url: "./action/actionEditarPerfil.php",
            type: "POST",
            data: formData,
            dataType: 'json',
            success: function (response) {
                console.log(response)
                if (response.success) {
                    $("#datosUsuario .header").html(`<i class="user circle icon"></i> ${formData.usNombre}`);
                    $("#datosUsuario .meta").html(`<i class="mail icon"></i> ${formData.usmail.replace(/(.{3}).+(.{3})/, "$1***$2")}`);

                    mostrarModal("Éxito", "¡Datos actualizados correctamente!");
                    
                    $("#formularioEdicion").fadeOut(function () {
                        $("#datosUsuario").fadeIn();
                    });
                } else {
                    mostrarModal("Error", "Hubo un error al actualizar los datos: " + response.message);
                }
            },
            error: function (xhr, status, error) {
                mostrarModal("Error", "Ocurrió un error inesperado: " + error);
            }
        });
    });
    $("#modalCerrar").on("click", function () {
        $("#modalMensaje").modal("hide");
    });
    function mostrarModal(titulo, mensaje) {
        $("#modalHeader").text(titulo);
        $("#modalContent").text(mensaje);
        $("#modalMensaje").modal("show");
    }
});
