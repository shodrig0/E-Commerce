<?php
$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$rutaProyecto = "/E-Commerce/";
$baseURL = $protocolo . $host . $rutaProyecto;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elixir Patagónico</title>
    <link rel="icon" href="<?php echo $baseURL ?>app/view/assets/img/LogoFrenteFINALL.png">
    <link rel="stylesheet" href="<?php echo $baseURL ?>Semantic-UI/dist/semantic.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<b>
    <!-- Sidebar -->
    <div class="ui left vertical inverted sidebar labeled icon menu">

        <button class="ui icon button" id="xButton">
            <i class="x icon"></i>
        </button>
        <a class="item">
            <i class="user icon"></i>
            Mi Cuenta
        </a>
        <a class="item">
            <i class="home icon"></i>
            Categorías <i class="arrow right icon"></i>
        </a>
        <a class="item">
            <i class="grid layout icon"></i>
            Contactos
        </a>
        <a class="item">
            <i class="newspaper outline icon"></i>
            Sobre nosotros
        </a>
    </div>

    <!-- Header -->
        <div class="ui grid" style="align-items: center; padding: 1em;">
            <!-- Botón para abrir el sidebar en la izquierda -->
            <div class="two wide column">
                <button class="ui icon button" id="menuButton">
                    <i class="bars icon"></i>
                </button>
            </div>

            <!-- Logo en el centro -->
            <div class="twelve wide column" style="text-align: center;">
                <img src="<?php echo $baseURL ?>app/view/assets/img/LogoFrenteFINALL.png" alt="Elixir Patagónico" style="height: 40px;">
            </div>

            <!-- Carrito de compras a la derecha -->
            <div class="two wide column" style="text-align: right;">
                <button class="ui icon button">
                    <i class="shopping cart icon"></i>
                </button>
            </div>
        </div>

</div>
    </header>

    <!-- Scripts de jQuery y Semantic UI -->
    
    <script src="<?php echo $baseURL ?>Semantic-UI/dist/semantic.min.js"></script>

    <!-- Script para controlar el sidebar -->
    <script>
        $('.ui.sidebar').sidebar({
            transition: 'overlay'
        });
        $('#menuButton').on('click', function() {
            $('.ui.sidebar').sidebar('toggle');
           
        });
        $('#xButton').on('click', function() {
            $('.ui.sidebar').sidebar('toggle');
            
        });
    </script>
</body>
</html>
