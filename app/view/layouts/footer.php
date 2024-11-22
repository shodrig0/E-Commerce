<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
?>

<footer class="ui segment footer">
    <div class="ui container">
        <div class="ui two column grid">
            <div class="column">
                <div class="ui small header">&copy; Grupo 17 - Programación Dinámica</div>
            </div>
            <div class="right aligned column">
                <div class="ui list">
                    <div class="item">Celayes, Brisa</div>
                    <div class="item">De La Iglesia, Martin</div>
                    <div class="item">Velo, Rodrigo</div>
                    <div class="item">Villablanca, Rodrigo</div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    html,
    body {
        height: 100;vh
        margin: 0;
        /* Elimina márgenes por defecto */
        display: flex;
        flex-direction: column;
        /* Flexbox en columna para todo el documento */
    }

    .content {
        flex: 1;
        /* Hace que el contenido principal ocupe el espacio disponible */
    }

    .footer {
        position: fixed;
        bottom: 0;
        padding: 1rem 0;
        background-color: #f9f9f9;
        /* Fondo claro */
        border-top: 1px solid #ddd;
        /* Línea superior */
    }
</style>
</body>

</html>