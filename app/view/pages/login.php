<div class="ui middle aligned center aligned grid" style="height: 100vh; margin: 0;">
    <div class="column" style="max-width: 450px;">
        <div class="ui raised very padded text segment">
            <h2 class="ui teal image header">
                <i class="user circle icon"></i>
                <div class="content">Iniciar Sesión</div>
            </h2>
            
            <div class="ui divider"></div>
            <form action="./Action/verificacionLogin.php" method="POST" name="formulario" id="formulario" class="ui large form" onsubmit="return formSubmit();">
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
                    <button type="submit" class="ui teal fluid fluid button">Ingresar</button>
                </div>
                <div class="field">
                    <a href="../home/home.php" class="ui secondary fluid button">Volver</a>
                </div>
            </form>
            <div class="ui horizontal divider">¿No tienes una cuenta?</div>
            <a href="registrarUsuario.php"><button id="btnRegistrarse" class="ui fluid blue button">Registrarse</button></a>
        </div>
    </div>
</div>
<script src="../js/api.js"></script>