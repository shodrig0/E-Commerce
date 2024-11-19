

<div class="ui container" style="max-width: 800px; margin-top: 20px;">
    <!-- Lista de Productos (vista inicial) -->
    <div id="listaProductos">
        <h2 class="ui teal header">
            <i class="list icon"></i>
            <div class="content">Lista de Productos</div>
        </h2>

        <div id="productos-editar" class="ui five column grid">
        </div>
    </div>

    <div id="formularioEdicion" class="ui container segment raised" style="max-width: 600px; margin-top: 20px; display: none;">
        <h2 class="ui yellow header">
            <i class="edit icon"></i>
            <div class="content">Modificar Producto</div>
        </h2>

        <form class="ui form" id="modificarProductoForm">
            <input type="hidden" name="productId" id="productId">

            <div class="field">
                <label><i class="tag icon"></i> Nombre del Producto</label>
                <input type="text" name="nombre" id="nombreProducto" required>
            </div>

            <div class="field">
                <label><i class="info circle icon"></i> Detalle</label>
                <textarea name="detalle" id="detalleProducto"></textarea>
            </div>

            <div class="field">
                <label><i class="dollar sign icon"></i> Precio</label>
                <div class="ui labeled input">
                    <div class="ui label">$</div>
                    <input type="number" name="precio" id="precioProducto" min="0" step="0.01" required>
                </div>
            </div>

            <div class="field">
                <label><i class="boxes icon"></i> Stock Disponible</label>
                <input type="number" name="stock" id="stockProducto" min="0" required>
            </div>

            <button type="submit" class="ui large yellow button fluid" onclick="manejarFormSubmit('#modificarProductoForm', './action/actionRespuestas.php', './', 'actualizar');">
                <i class="save icon"></i> Guardar Cambios
            </button>
        </form>
    </div>
</div>
<div class="ui modal" id="modalResponse">
    <div class="header">Resultado del Registro</div>
    <div class="content" id="contModal"></div>
</div>
<script src="../../js/enviarFormulario.js"></script>
<script>
$(document).ready(function() {
    cargarProductos();

    function cargarProductos() {
        $.ajax({
            url: './action/listarProductos.php',
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
                    mostrarFormularioEdicion(id);
                });

            infoProducto.append(titulo, detalle, precio);
            masContenido.append(stock, idProd);
            card.append(infoProducto, masContenido, botonEditar);
            divProducto.append(card);
            $('#productos-editar').append(divProducto);
        });
    }

    function mostrarFormularioEdicion(idProducto) {
        $('#formularioEdicion').show();

        $.ajax({
            url: './action/actionModificarProducto.php',
            method: 'POST',
            dataType: 'json',
            data: { idProducto: idProducto },
            success: function(response) {
                if (response) {
                    const producto = response;
                    $('#productId').val(producto.idproducto);
                    $('#nombreProducto').val(producto.pronombre);
                    $('#detalleProducto').val(producto.prodetalle);
                    $('#precioProducto').val(producto.precio);
                    $('#stockProducto').val(producto.procantstock);
                } else {
                    console.log("No se encontraron datos para el producto:", response.message);
                }
            },
            error: function(error) {
                console.log("Error al obtener los datos del producto", error);
            }
        });
    }
});

</script>
