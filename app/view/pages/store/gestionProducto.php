<?php 
include_once '../../layouts/header.php';
?>
<style>
.ui.top.attached.tabular.menu {
    border: 1px solid #ccc; /* Cambia el color del borde */
    border-radius: 5px 5px 0 0; /* Redondea las esquinas superiores */
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Añade un efecto de sombra */
}

.ui.bottom.attached.tab.segment {
    border: 1px solid #ccc; /* Asegura que los bordes coincidan */
    border-top: none; /* Elimina el borde superior para integrarlo con los tabs */
    border-radius: 0 0 5px 5px; /* Redondea las esquinas inferiores */
    padding: 20px; /* Añade espacio interno */
    background-color: #f9f9f9; /* Fondo más claro */
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); /* Coincide con la sombra */
}

.ui.menu .item.active {
    background-color: #2185d0; /* Color de fondo activo */
    color: white; /* Color del texto activo */
    border-bottom: 3px solid #1678c2; /* Indicador visual de tab activo */
}

.ui.menu .item {
    border-radius: 0; /* Elimina bordes redondeados de los tabs */
    transition: all 0.3s ease; /* Transición suave al pasar el cursor */
}

.ui.menu .item:hover {
    background-color: #f0f0f0; /* Color al pasar el cursor */
}
</style>

<div class="ui top attached tabular menu">
    <a class="item active" data-tab="agregar"><i class="plus icon"></i> Agregar Producto</a>
    <a class="item" data-tab="quitar"><i class="trash icon"></i> Quitar Producto</a>
    <a class="item" data-tab="modificar"><i class="edit icon"></i> Modificar Producto</a>
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
