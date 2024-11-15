

<div class="ui container" style="max-width: 800px; margin-top: 20px;">
    <!-- Lista de Productos (vista inicial) -->
    <div id="listaProductos">
        <h2 class="ui teal header">
            <i class="list icon"></i>
            <div class="content">Lista de Productos</div>
        </h2>

        <!-- Contenedor de productos con grilla de 5 columnas -->
        <div id="productos-editar" class="ui five column grid">
        </div>
    </div>

    <!-- Formulario de Modificación (oculto inicialmente) -->
    <div id="formularioEdicion" class="ui container segment raised" style="max-width: 600px; margin-top: 20px; display: none;">
        <h2 class="ui yellow header">
            <i class="edit icon"></i>
            <div class="content">Modificar Producto</div>
        </h2>

        <form class="ui form" id="modificarProductoForm" method="POST" action="/update-product">
            <!-- Campo oculto para almacenar el ID del producto -->
            <input type="hidden" name="productId" id="productId">

            <!-- Nombre del producto -->
            <div class="field">
                <label><i class="tag icon"></i> Nombre del Producto</label>
                <input type="text" name="nombre" id="nombreProducto" required>
            </div>

            <!-- Detalle del producto -->
            <div class="field">
                <label><i class="info circle icon"></i> Detalle</label>
                <textarea name="detalle" id="detalleProducto"></textarea>
            </div>

            <!-- Precio del producto -->
            <div class="field">
                <label><i class="dollar sign icon"></i> Precio</label>
                <div class="ui labeled input">
                    <div class="ui label">$</div>
                    <input type="number" name="precio" id="precioProducto" min="0" step="0.01" required>
                </div>
            </div>

            <!-- Stock del producto -->
            <div class="field">
                <label><i class="boxes icon"></i> Stock Disponible</label>
                <input type="number" name="stock" id="stockProducto" min="0" required>
            </div>

            <!-- Botón de Envío -->
            <button type="submit" class="ui large yellow button fluid">
                <i class="save icon"></i> Guardar Cambios
            </button>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    cargarProductos();

    function cargarProductos() {
        $.ajax({
            url: '../home/listar.php',
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.producto && response.producto.length > 0) {
                    mostrarProductos(response.producto);
                } else {
                    console.log("No se encontraron productos.");
                }
            },
            error: function(error) {
                console.log("Error en la solicitud AJAX", error);
            }
        });
    }

    function mostrarProductos(productos) {
        $('#productos-editar').empty();

        // Recorre los productos y los agrega
        productos.forEach(function(producto) {
            let divProducto = $('<div>').addClass('column');
            let card = $('<div>').addClass('ui card');
            let id = producto.idproducto;

            // Contenido de información del producto
            let infoProducto = $('<div>')
                .addClass('content')
                .css({
                    'min-height': '140px', // Ajusta la altura según tus necesidades
                    'overflow-y': 'auto'
                });

            let titulo = $('<a>').addClass('header').text(producto.pronombre);
            let detalle = $('<p>').text(producto.prodetalle);
            let precio = $('<h3>').addClass('ui green text').text(`$${producto.precio}`);

            // Contenedor extra de información (por ejemplo, stock)
            let masContenido = $('<div>').addClass('extra content');
            let stock = $('<span>').html(`<i class="box icon"></i> Stock: ${producto.procantstock}`);
            let idProd = $('<p>').html('<i class="tag icon"></i> ID: ' + id);

            // Botón de editar
            let botonEditar = $('<button>')
                .addClass('ui yellow button')
                .text('Editar')
                .click(function() {
                    mostrarFormularioEdicion(id); // Pasar el ID del producto
                });

            infoProducto.append(titulo, detalle, precio);
            masContenido.append(stock, idProd);
            card.append(infoProducto, masContenido, botonEditar);
            divProducto.append(card);
            $('#productos-editar').append(divProducto);
        });
    }

    // Función para mostrar el formulario de edición con datos de producto
    function mostrarFormularioEdicion(idProducto) {
        
        $('#listaProductos').hide();
        $('#formularioEdicion').show();

        $.ajax({
            url: '../../controller/obtenerProducto.php',
            method: 'POST',
            data: { id: idProducto }, 
            dataType: 'json',
            success: function(producto) {
                if (producto) {
                    $('#productId').val(producto.idproducto);
                    $('#nombreProducto').val(producto.pronombre);
                    $('#detalleProducto').val(producto.prodetalle);
                    $('#precioProducto').val(producto.precio);
                    $('#stockProducto').val(producto.procantstock);
                } else {
                    console.log("No se encontraron datos para el producto.");
                }
            },
            error: function(error) {
                console.log("Error al obtener los datos del producto", error);
            }
        });
    }
});

</script>
