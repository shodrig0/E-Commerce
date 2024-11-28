<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';
?>

<div class="ui middle aligned center aligned grid" style="height: 100vh; margin: 0;">
    <div class="column" style="max-width: 450px;">
        <div class="ui raised very padded text segment">
            <h2 class="ui image header" style="color: rgba(64, 76, 18, 0.8);">
                <i class="user circle icon"></i>
                <div class="content">Iniciar Sesión</div>
            </h2>

            <div class="ui divider"></div>
            <form action="./action/verificacionLogin.php" method="POST" name="formulario" id="formulario" class="ui large form" onsubmit="return formSubmit()">
                <div class="field">
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input name="usnombre" id="usnombre" type="text" placeholder="Usuario" aria-label="Username">
                    </div>
                </div>
                <div class="field">
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input name="uspass" id="uspass" type="password" placeholder="Contraseña" aria-label="Password">
                    </div>
                </div>
                <div class="field">
                    <button type="submit" class="ui fluid button" style="background-color: rgba(116, 132, 37, 0.7); color: white;">Ingresar</button>
                </div>
                <div class="field">
                    <a href="../home/home.php" class="ui fluid button secondary-button">Volver</a>
                </div>
            </form>
            <div class="ui horizontal divider">¿No tienes una cuenta?</div>
            <a href="registrarUsuario.php">
                <button id="btnRegistrarse" class="ui fluid button" style="background-color: rgba(116, 132, 37, 0.4)">Registrarse</button>
            </a>
        </div>
    </div>
</div>

<script src="../js/api.js"></script>

<style>
    .ui.button {
        border-radius: 5px;
        font-weight: bold;
    }

    .primary-button:hover {
        background-color: rgba(116, 132, 45, 1);
        color: white;
    }

    .secondary-button:hover {
        background-color: rgba(116, 132, 37, 0.6);
        color: white;
    }
</style>

<?php footer(); ?>