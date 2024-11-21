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
                .attr('src', producto.imgSource || 'https://static.vecteezy.com/system/resources/thumbnails/021/217/339/small_2x/red-wine-bottle-png.png')
                .attr('alt', producto.pronombre)
                .addClass('producto-imagen');
            imgContainer.append(img);
    
            // Div de la información del producto
            let infoProducto = $('<div>').addClass('content');
            let titulo = $('<a>').addClass('header').text(producto.pronombre);
            let precio = $('<h3>').addClass('ui green text').text(`$${producto.precio}`);
    
            // Contenido adicional (botones)
            let masContenido = $('<div>').addClass('extra content');
    
            // Botón de agregar al carrito
            let botonAgregar = $('<button>').addClass('ui black button').text(`Agregar al carrito`);
    
            // Botón de editar con desplazamiento
            let botonEditar = $('<button>').addClass('ui grey button').text(`Editar`).click(function () {
                // Aquí realizamos el desplazamiento a la sección de edición
                $('html, body').animate({
                    scrollTop: $('#divEdicionProducto').offset().top
                }, 800);
    
                // Lógica adicional para cargar los datos del producto en el formulario de edición
                cargarDatosProductoEdicion(producto);
            });
    
            infoProducto.append(titulo, precio);
            masContenido.append(botonAgregar, botonEditar);
            card.append(imgContainer, infoProducto, masContenido);
            divProducto.append(card);
    
            $('#galeriaProductos').append(divProducto);
        });
    }
    
    function cargarDatosProductoEdicion(producto) {
        $('#idProducto').val(producto.id);
        $('#nombreProducto').val(producto.pronombre);
        $('#precioProducto').val(producto.precio);
    }
    

    $('#actualizarProductos').on('click', function () {
        localStorage.removeItem(LS_KEY);

        $('#galeriaProductos').empty().text('Actualizando productos...');

        obtenerProductosDelServidor();
    });

});
