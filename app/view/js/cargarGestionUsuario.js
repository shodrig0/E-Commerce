$('.menu .item').tab();

let loginCargado = false;
let miembrosCargado = false;

$('[data-tab="login"]').on('click', function () {
    if (!loginCargado) {
        $('#tab-login').load('./login.php', function () {
            loginCargado = true;
            $('.menu .item').tab(); // Re-inicializar pestañas
        });
    }
});

$('[data-tab="miembros"]').on('click', function () {
    if (!miembrosCargado) {
        $('#tab-miembros').load('./miembros.php', function () {
            miembrosCargado = true;
            $('.menu .item').tab(); // Re-inicializar pestañas
        });
    }
});

$(document).ready(function () {
    if (!loginCargado) {
        $('#tab-login').load('./login.php', function () {
            loginCargado = true;
            $('.menu .item').tab(); // Inicializar pestañas por primera vez
        });
    }
});