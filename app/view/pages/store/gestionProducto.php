<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
?>
<style>
.ui.top.attached.tabular.menu {
    border: 1px solid #ccc;
    border-radius: 5px 5px 0 0;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); 
}

.ui.bottom.attached.tab.segment {
    border: 1px solid #ccc; 
    border-top: none; 
    border-radius: 0 0 5px 5px; 
    padding: 20px;
    background-color: #f9f9f9;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
}

.ui.menu .item.active {
    background-color: #2185d0;
    color: white;
    border-bottom: 3px solid #1678c2; 
}

.ui.menu .item {
    border-radius: 0;
    transition: all 0.3s ease; 
}

.ui.menu .item:hover {
    background-color: #f0f0f0;
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
            let contentId = tabName + "Content";
            
            let url;
            if (tabName === 'agregar') {
                url = 'agregarProducto.php';
            } else if (tabName === 'quitar') {
                url = 'borrarProducto.php';
            } else if (tabName === 'modificar') {
                url = 'modificarProducto.php';
            }

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

    $('.menu .item[data-tab="agregar"]').addClass('active');
    $('.ui.bottom.attached.tab.segment[data-tab="agregar"]').addClass('active');
    
    $.ajax({
        url: 'agregarProducto.php',
        method: "POST",
        success: function(data) {
            $("#agregarContent").html(data);
        },
        error: function() {
            $("#agregarContent").html("Error al cargar el contenido.");
        }
    });
});

</script>
<?php footer(); ?>