$(document).ready(function () {
  const LS_KEY = "productos"; // Clave para `localStorage` de productos

  function cargarCarrito() {
    $.ajax({
      url: BASE_URL + "app/view/pages/client/carrito.php",
      method: "POST",
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

  cargarProductos();
  cargarCarrito();

  function cargarProductos() {
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
      url: "./store/action/listarProductos.php",
      method: "POST",
      dataType: "json",
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
      },
    });
  }

  function mostrarProductos(productos) {
    $("#galeriaProductos").empty();

    productos.forEach(function (producto) {
      const elementoProducto = crearElementoProducto(producto);
      $("#galeriaProductos").append(elementoProducto);
    });
  }

  function crearElementoProducto(producto) {
    let divProducto = $("<div>").addClass("column");

    let card = $("<div>").addClass("ui card");

    let imgContainer = $("<div>").addClass("imagen");
    let img = $("<img>")
      .attr(
        "src",
        producto.imgSource ||
          "https://static.vecteezy.com/system/resources/thumbnails/021/217/339/small_2x/red-wine-bottle-png.png"
      )
      .attr("alt", producto.pronombre)
      .addClass("producto-imagen");
    imgContainer.append(img);

    let infoProducto = $("<div>").addClass("content");
    let titulo = $("<a>").addClass("header").text(producto.pronombre);
    let precio = $("<h3>")
      .addClass("ui green text")
      .text(`$${producto.precio}`);

    let masContenido = $("<div>").addClass("extra content");
    let boton = $("<button>")
      .addClass("ui black button")
      .text(`Agregar al carrito`)
      .on("click", function () {
        agregarAlCarrito(producto);
      });

    infoProducto.append(titulo, precio);
    masContenido.append(boton);
    card.append(imgContainer, infoProducto, masContenido);
    divProducto.append(card);

    return divProducto;
  }



  function agregarAlCarrito(producto) {
    console.log(producto)
    $.ajax({
      url: BASE_URL + "app/view/pages/client/action/actionAgregarProductoCarrito.php",
      method: "POST",
      data: { producto: producto, tipo: "agregar" },
      dataType: "json",
      success: function (response) {
        
      },
      error: {},
    });
  }
});
