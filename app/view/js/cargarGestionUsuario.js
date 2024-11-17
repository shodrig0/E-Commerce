let loginCargado = false;
let miembrosCargado = false;

$('[data-tab="login"]').on('click', function () {
    if (!loginCargado) {
        $('#tab-login').load('./login.php', function () {
            loginCargado = true;
        });
    }
});

$('[data-tab="miembros"]').on('click', function () {
    if (!miembrosCargado) {
        $('#tab-miembros').load('./miembros.php', function () {
            miembrosCargado = true;
        });
    }
});

// Cargar contenido por defecto para la pestaña activa solo una vez
$(document).ready(function () {
    if (!loginCargado) {
        $('#tab-login').load('./login.php', function () {
            loginCargado = true;
        });
    }
});