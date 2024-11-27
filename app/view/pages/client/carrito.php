<?php
require_once '../../../../config.php';
require_once '../../layouts/header.php';

?>
<div class="ui horizontal divider"></div>
<div class="ui container">
  <h1 class="ui center aligned header">Carrito de Compras</h1>
  <div class="ui segment">
    <table class="ui striped celled table">
      <thead>
        <tr>
          <th>Producto</th>
          <th>Precio</th>
          <th>Cantidad</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($carrito as $producto): ?>
          <tr>
            <td>
              <div class="ui items">
                <div class="item">
                  <div class="ui small image">
                    <img src="<?= $imgArtic ?>" alt="Imagen del producto" style="max-width: 100px;">
                  </div>
                  <div class="content">
                    <div class="header"><?= $producto['nombre'] ?></div>
                    <div class="description">
                      <p><?= $producto['descripcion'] ?? 'Sin descripción disponible' ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </td>
            <td>
              <div class="ui label large">
                $<?= number_format($producto['precio'], 2) ?>
              </div>
            </td>
            <td>
              <div class="ui buttons">
                <button class="ui button reducir-cantidad" data-id="<?= $producto['idproducto'] ?>">-</button>
                <div class="ui label large cantidad"><?= $producto['cantidadproducto'] ?></div>
                <button class="ui button anadir-cantidad" data-id="<?= $producto['idproducto'] ?>">+</button>
              </div>
            </td>
            <td>
              <button class="ui red button" (<?= $producto['idproducto']; ?>)">
                <i class="trash alternate icon"></i> Eliminar
                </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="ui clearing segment">
      <h2 class="ui right floated header">Total: $<?= number_format($precioTotal, 2) ?></h2>
    </div>
    <div class="ui center aligned">
      <button class="ui green button">
        <i class="shopping cart icon"></i> Finalizar Compra
      </button>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
    $('.reducir-cantidad').on('click', function () {
      let idProducto = $(this).data('id');
      actualizarCantidad(idProducto, -1, $(this));
    });

    $('.anadir-cantidad').on('click', function () {
      let idProducto = $(this).data('id');
      actualizarCantidad(idProducto, 1, $(this));
    });

    function actualizarCantidad(idProducto, cambio, boton) {
      $.ajax({
        url: './action/actionActualizarCarrito.php',
        method: 'POST',
        dataType: 'json', 
        data: { idproducto: idProducto, cantidad: cambio },
        success: function (response) {
          console.log(response);
          if (response.success) {
            const cantidadOrig = boton.siblings('.cantidad');
            let nuevaCantidad = parseInt(cantidadOrig.text()) + cambio;
            if (nuevaCantidad <= 0) {
              boton.closest('tr').remove();
            } else {
              cantidadOrig.text(nuevaCantidad);
            }
          } else {
            alert(response.message);
          }
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText); // Agrega un log para depurar la respuesta del servidor
          alert('Hubo un error en el envío.');
        }
      });
    }
  })
</script>