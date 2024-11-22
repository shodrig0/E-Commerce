$(document).ready(function () {
    const carritoBoton = $("#carritoBoton");
    const carritoDesplegable = $("#carritoDesplegable");
    const cerrarCarrito = $(".cerrarCarrito");

    // Muestra el carrito al hacer clic en el botón
    carritoBoton.on("click", function () {
        carritoDesplegable.addClass("mostrado");
        cargarCarrito();
    });

    // Oculta el carrito al hacer clic en el botón "Cerrar"
    cerrarCarrito.on("click", function () {
        carritoDesplegable.removeClass("mostrado");
    });

    // Carga el contenido del carrito mediante AJAX
    function cargarCarrito() {
        $.ajax({
            url: `${BASE_URL}app/view/pages/client/carrito.php`,
            method: "GET",
            success: function (data) {
                $("#carritoItems").html(data);
            },
            error: function () {
                $("#carritoItems").html(
                    '<div class="ui message error">Error al cargar el carrito.</div>'
                );
            },
        });
    }

    // Agrega un producto al carrito mediante AJAX
    $(document).on("click", ".agregarCarrito", function (e) {
        e.preventDefault();

        const productoId = $(this).data("id");
        const cantidad = $(this).data("cantidad") || 1;

        $.ajax({
            url: `${BASE_URL}app/view/pages/client/action/agregarProducto.php`,
            method: "POST",
            data: { idproducto: productoId, cantidad },
            success: function () {
                cargarCarrito(); // Recarga el carrito después de agregar el producto
            },
            error: function () {
                alert("No se pudo agregar el producto al carrito.");
            },
        });
    });
});
