<?php 
include_once '../../layouts/header.php';
?>

<div class="ui top attached tabular menu">
    <a class="item active" data-tab="agregar">Agregar Producto</a>
    <a class="item" data-tab="quitar">Quitar Producto</a>
    <a class="item" data-tab="modificar">Modificar Producto</a>
</div>

<div class="ui bottom attached active tab segment" data-tab="agregar">
    <div id="agregarContent">
        Cargando contenido...
    </div>
</div>
<div class="ui bottom attached tab segment" data-tab="quitar">
    <div id="quitarContent">
        Cargando contenido...
    </div>
</div>
<div class="ui bottom attached tab segment" data-tab="modificar">
    <div id="modificarContent">
        Cargando contenido...
    </div>
</div>

<script>
$(document).ready(function() {
    $('.menu .item').tab({
        onVisible: function(tabName) {
            // Determinar el ID del contenedor donde se cargará el contenido
            let contentId = tabName + "Content";
            
            // Definir la URL para cada acción
            let url;
            if (tabName === 'agregar') {
                url = 'agregarProducto.php';
            } else if (tabName === 'quitar') {
                url = 'borrarProducto.php';
            } else if (tabName === 'modificar') {
                url = 'modificarProducto.php';
            }

            // Hacer la llamada AJAX y cargar el contenido en el tab correspondiente
            $("#" + contentId).html("Cargando contenido...");
            $.ajax({
                url: url,
                method: "GET",
                success: function(data) {
                    $("#" + contentId).html(data);
                },
                error: function() {
                    $("#" + contentId).html("Error al cargar el contenido.");
                }
            });
        }
    });

    // Forzar la carga del contenido del tab "Agregar" al cargar la página
    $('.menu .item[data-tab="agregar"]').addClass('active');
    $('.ui.bottom.attached.tab.segment[data-tab="agregar"]').addClass('active');
    
    // Llamada AJAX inicial para cargar 'agregarProducto.php'
    $.ajax({
        url: 'agregarProducto.php',
        method: "GET",
        success: function(data) {
            $("#agregarContent").html(data);
        },
        error: function() {
            $("#agregarContent").html("Error al cargar el contenido.");
        }
    });
});

</script>
