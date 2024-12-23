<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';
?>

<div class="ui middle aligned center aligned grid" style="height: 100vh; margin: 0;">
    <div class="column" style="max-width: 450px;">
        <h2 class="ui header" style="color: rgba(64, 76, 18, 0.8);">
            <i class="user plus icon"></i>
            <div class="content">
                Registrar Usuario
            </div>
        </h2>
        <form class="ui large form" id="formulario">
            <input id="accion" name="accion" value="login" type="hidden">
            <div class="field">
                <label for="usnombre">Nombre:</label>
                <div class="ui left icon input">
                    <i class="user icon"></i>
                    <input id="usnombre" name="usnombre" type="text" placeholder="Ingresa tu nombre" required>
                </div>
            </div>

            <div class="field">
                <label for="usemail">Email:</label>
                <div class="ui left icon input">
                    <i class="mail icon"></i>
                    <input name="usemail" id="usemail" type="email" placeholder="example@example.com" required>
                </div>
            </div>
            <div class="field">
                <label for="uspass">Contraseña:</label>
                <div class="ui left icon input">
                    <i class="lock icon"></i>
                    <input id="uspass" name="uspass" type="password" placeholder="Ingresa tu contraseña" required>
                </div>
            </div>
            <button class="ui fluid large button" type="submit" style="background-color: rgba(116, 132, 37, 0.7); color: white;">Registrar</button>
        </form>
        <div class="ui modal" id="modalResponse">
            <div class="header">Resultado del Registro</div>
            <div class="content" id="contModal"></div>
        </div>
    </div>
</div>
<script src="../js/enviarFormulario.js"></script>
<script>
    $('.ui.dropdown').dropdown();

    manejarFormSubmit(
        '#formulario',
        './action/actionRegistrarUsuario.php',
        '../home/home.php'
    );
</script>

<?php footer(); ?>