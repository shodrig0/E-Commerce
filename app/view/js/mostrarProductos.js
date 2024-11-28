$(document).ready(function () {
  function cargarProductos() {
    console.log("Recargando productos desde el servidor...");
    $("#galeriaProductos").empty();
    obtenerProductosDelServidor();
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
    let descripcion = $("<p>")
      .addClass("ui text small")
      .text(producto.prodetalle || "Sin descripción disponible.");

    let masContenido = $("<div>").addClass("extra content");
    let selectCantidad = $("<select>")
      .attr("id", "cantidad")
      .addClass("ui dropdown");
    for (let i = 1; i <= producto.procantstock; i++) {
      selectCantidad.append($("<option>").attr("value", i).text(i));
    }

    let boton = $("<button>")
      .addClass("ui black button")
      .text(`Agregar al carrito`)
      .on("click", function () {
        agregarAlCarrito(producto.idproducto, selectCantidad.val());
      });

    infoProducto.append(titulo, precio, descripcion, selectCantidad);
    masContenido.append(boton);
    card.append(imgContainer, infoProducto, masContenido);
    divProducto.append(card);

    return divProducto;
  }

  function agregarAlCarrito(idproducto, cantidad) {
    $.ajax({
      url:
        BASE_URL +
        "app/view/pages/client/action/actionAgregarProductoCarrito.php",
      method: "POST",
      data: {
        idproducto: idproducto,
        cantidad: cantidad,
      },
      dataType: "json",
      success: function (response) {
        console.log("Respuesta completa del servidor:", response);
        console.log("Success:", response.success);
        if (response.success) {
          mostrarModalConfirmacion(response.producto, response.precioTotal);
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
        alert("Hubo un error en el envío.");
      },
    });
  }

  function mostrarModalConfirmacion(producto, precioTotal) {
    $("#productoNombre").text("Producto: " + producto.nombre);
    $("#productoCantidad").text("Cantidad: " + producto.cantidadproducto);
    $("#productoPrecio").text("Precio: $" + producto.precio);
    $("#precioTotal").text("Total: $" + precioTotal);

    $("#modalConfirmacion").modal("show");
  }
  $("#irAlCarrito").on("click", function () {
    window.location.href = BASE_URL + "app/view/pages/client/carrito.php";
  });

  $(".ui.red.button").on("click", function () {
    $("#modalConfirmacion").modal("hide");
  });
  cargarProductos();
});
