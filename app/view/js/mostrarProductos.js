$(document).ready(function () {
    const LS_KEY = "productos"; // Clave para `localStorage`

    cargarProductos();

    function cargarProductos() {
        //carga los productos en localstorage
        const productosLS = JSON.parse(localStorage.getItem(LS_KEY));

        if (productosLS && productosLS.length > 0) {
            console.log("Cargando productos desde localStorage");
            mostrarProductos(productosLS);
        } else {
            console.log("Cargando productos desde servidor...");
            obtenerProductosDelServidor();
        }
    }

    function obtenerProductosDelServidor() {
        $.ajax({
            url: '../pages/store/action/listarProductos.php',
            method: 'POST',
            dataType: 'json',
            success: function (response) {
                console.log("Respuesta del servidor:", response); 
                if (response.producto && response.producto.length > 0) {
                    const productos = response.producto;
                    localStorage.setItem(LS_KEY, JSON.stringify(productos));
                    mostrarProductos(productos);
                } else {
                    console.log("No se encontraron productos.");
                }
            },
            error: function (error) {
                console.error("Error en la solicitud AJAX", error);
            }
        });
    }

    function mostrarProductos(productos) {
        $('#galeriaProductos').empty();

        productos.forEach(function (producto) {
            let divProducto = $('<div>').addClass('column');

            let card = $('<div>').addClass('ui card');

            // Creo contenedor de la imagen
            let imgContainer = $('<div>').addClass('imagen');
            let img = $('<img>')
                .attr('src', producto.imgSource || 'https://via.placeholder.com/150')
                .attr('alt', producto.pronombre)
                .addClass('producto-imagen');
            imgContainer.append(img);

            // Div de la información del producto
            let infoProducto = $('<div>').addClass('content');
            let titulo = $('<a>').addClass('header').text(producto.pronombre);
            let precio = $('<h3>').addClass('ui green text').text(`$${producto.precio}`);

            // Contenido adicional (boton)
            let masContenido = $('<div>').addClass('extra content');
            let boton = $('<button>').addClass('ui black button').text(`Agregar al carrito`);

            infoProducto.append(titulo, precio);
            masContenido.append(boton);
            card.append(imgContainer, infoProducto, masContenido);
            divProducto.append(card);

            $('#galeriaProductos').append(divProducto);
        });
    }

    $('#actualizarProductos').on('click', function () {
        localStorage.removeItem(LS_KEY);
    
        $('#galeriaProductos').empty().text('Actualizando productos...');
    
        obtenerProductosDelServidor();
    });
    
});
