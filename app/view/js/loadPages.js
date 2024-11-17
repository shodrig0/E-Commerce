$(document).ready(function () {
    // Inicialización de tabs con Semantic UI
    $('.menu .item').tab({
        onVisible: function (tabName) {
            let contentId = tabName + "Content"; // Contenedor dinámico donde se cargará el contenido
            let url;

            // Definir las URLs según el tab
            if (tabName === 'login') {
                url = './login.php';
            } else if (tabName === 'miembros') {
                url = './miembros.php';
            } else if (tabName === 'agregar') {
                url = 'agregarProducto.php';
            } else if (tabName === 'quitar') {
                url = 'borrarProducto.php';
            } else if (tabName === 'modificar') {
                url = 'modificarProducto.php';
            }

            // Cargar contenido dinámico
            $("#" + contentId).html("Cargando contenido...");
            $.ajax({
                url: url,
                method: "GET",
                success: function (data) {
                    $("#" + contentId).html(data);
                },
                error: function () {
                    $("#" + contentId).html("Error al cargar el contenido.");
                }
            });
        }
    });

    // Cargar contenido por defecto para tabs iniciales si es necesario
    const defaultTab = 'login'; // Cambiar a 'agregar' si es la pestaña principal de productos
    const defaultContentId = defaultTab + "Content";
    const defaultUrl = defaultTab === 'login' ? './login.php' : 'agregarProducto.php';
    $("#" + defaultContentId).html("Cargando contenido...");

    $.ajax({
        url: defaultUrl,
        method: "GET",
        success: function (data) {
            $("#" + defaultContentId).html(data);
        },
        error: function () {
            $("#" + defaultContentId).html("Error al cargar el contenido.");
        }
    });

    // Manejar clic en el botón "Registrarse" dentro del tab de login
    $(document).on('click', '#btnRegistrarse', function () {
        const contentId = 'loginContent'; // Contenedor donde se carga el contenido de login
        const url = 'registrarUsuario.php';

        $("#" + contentId).html("Cargando contenido...");
        $.ajax({
            url: url,
            method: "GET",
            success: function (data) {
                $("#" + contentId).html(data);
            },
            error: function () {
                $("#" + contentId).html("Error al cargar el contenido.");
            }
        });
    });
});
