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
    <script src="<?php echo $baseURL ?>Semantic-UI/dist/semantic.min.js"></script>
    <link rel="stylesheet" href="<?php echo $baseURL ?>app/view/css/style.css">
</head>
<body>
    <header>
        <div class="ui grid" style="align-items: center; padding: 1em;">
            <!-- Columna izquierda con el botón de menú -->
            <div class="two wide column" style="text-align: left;">
                <button class="ui icon button" id="menuButton">
                    <i class="bars icon"></i>
                </button>
            </div>

            <!-- Columna central con la imagen -->
            <div class="twelve wide column" style="text-align: center;">
                <img src="<?php echo $baseURL ?>app/view/assets/img/LogoFrenteFINALL.png" alt="Elixir Patagónico" style="height: 42px;">
            </div>

            <!-- Columna derecha con los botones de Login y Shop -->
            <div class="two wide column" style="text-align: right;">
                <div class="ui buttons">
                    <a href="<?php echo $baseURL ?>app/view/usuario/gestionUsuario.php" class="ui vertical animated button">
                        <div class="hidden content">Login</div>
                        <div class="visible content">
                            <i class="user circle outline icon"></i>
                        </div>
                    </a>
                    <div class="ui vertical animated button">
                        <div class="hidden content">Shop</div>
                        <div class="visible content">
                            <i class="shop icon"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>