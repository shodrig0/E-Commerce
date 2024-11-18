$('.menu .item').tab()

let loginCargado = false
let miembrosCargado = false

function setActiveTab(tab) {

    $('.menu .item').removeClass('active')
    $('[data-tab="' + tab + '"]').addClass('active')
    $('.ui.bottom.attached.tab.segment').removeClass('active') // <- no se que es pero funciona
    $('#tab-' + tab).addClass('active')
    localStorage.setItem('activeTab', tab)
}

$(document).ready(function () {

    const activeTab = localStorage.getItem('activeTab') || 'login'

    setActiveTab(activeTab)

    if (activeTab === 'login' && !loginCargado) {
        $('#tab-login').load('./login.php', function () {
            loginCargado = true
            $('.menu .item').tab()
        })
    } else if (activeTab === 'miembros' && !miembrosCargado) {
        $('#tab-miembros').load('./miembros.php', function () {
            miembrosCargado = true
            $('.menu .item').tab()
        })
    }

    $('[data-tab="login"]').on('click', function () {
        if (!loginCargado) {
            $('#tab-login').load('./login.php', function () {
                loginCargado = true
                $('.menu .item').tab()
            })
        }
        setActiveTab('login')
    })

    $('[data-tab="miembros"]').on('click', function () {
        if (!miembrosCargado) {
            $('#tab-miembros').load('./miembros.php', function () {
                miembrosCargado = true
                $('.menu .item').tab()
            })
        }
        setActiveTab('miembros')
    })
})
