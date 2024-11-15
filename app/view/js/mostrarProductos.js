$(document).ready(function() {
    
    cargarProductos();

    function cargarProductos() {
        $.ajax({
            url: 'listar.php',
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
        $('#galeriaProductos').empty();

        // Recorre los productos y los agrega
        productos.forEach(function(producto) {
            let divProducto = $('<div>').addClass('column');

            let card = $('<div>').addClass('ui card');

            // Contenedor de imagen
            let imgContainer = $('<div>').addClass('imagen');
            let img = $('<img>')
                .attr('src', producto.imgSource || 'https://www.espaciovino.com.ar/media/default/0001/68/thumb_67746_default_big.jpeg')
                .attr('alt', producto.pronombre)
                .addClass('producto-imagen');
            imgContainer.append(img);

            // let descripcion = $('<div>').addClass('description').text(producto.prodetalle);
            // Cont de información de producto
            let infoProducto = $('<div>').addClass('content');
            let titulo = $('<a>').addClass('header').text(producto.pronombre);
            let precio = $('<h3>').addClass('ui green text').text(`$${producto.precio}`)

            // Crea el contenedor extra de información (por ejemplo, stock)
            let masContenido = $('<div>').addClass('extra content');
            let stock = $('<span>').html(`<i class="box icon"></i> Stock: ${producto.procantstock}`);

            infoProducto.append(titulo, precio);
            masContenido.append(stock);
            card.append(imgContainer, infoProducto, masContenido);
            divProducto.append(card);

            $('#galeriaProductos').append(divProducto);
        });
    }
});