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
        </tr>
      </thead>
      <tbody>
        <?php
        $precioTotal = 0;
        foreach ($carrito as $producto):
          $precioTotal += $producto['precio'] * $producto['cantidadproducto'];
        ?>
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
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <div class="ui clearing segment">
      <h2 class="ui right floated header">Total:<span class="total">$<?= number_format($precioTotal, 2) ?></span></h2>
    </div>
    <div class="ui center aligned">
      <button type="button" class="ui green button finalizar-compra" data-id="<?= $producto['idproducto'] ?>">Finalizar Compra</button>
    </div>
  </div>
</div>
</div>
<div class="ui modal">
  <div class="header">Compra Realizada</div>
  <div class="content">
    <p>¡Tu compra ha sido completada con éxito!</p>
  </div>
  <div class="actions">
    <div class="ui green button">Cerrar</div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $('.reducir-cantidad').on('click', function() {
      let idProducto = $(this).data('id');
      actualizarCantidad(idProducto, -1, $(this));
    });

    $('.anadir-cantidad').on('click', function() {
      let idProducto = $(this).data('id');
      actualizarCantidad(idProducto, 1, $(this));
    });


    function actualizarCantidad(idProducto, cambio, boton) {
      $.ajax({
        url: './action/actionActualizarCarrito.php',
        method: 'POST',
        dataType: 'json',
        data: {
          idproducto: idProducto,
          cantidad: cambio
        },
        success: function(response) {
          console.log(response);
          if (response.success) {
            const cantidadOrig = boton.siblings('.cantidad');
            let nuevaCantidad = parseInt(cantidadOrig.text()) + cambio;
            if (nuevaCantidad <= 0) {
              boton.closest('tr').remove();
            } else {
              cantidadOrig.text(nuevaCantidad);
            }
            actualizarTotal(response.precioTotal);
          } else {
            alert(response.message);
          }
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
          alert('Hubo un error en el envío.');
        }
      });
    }
    $('.finalizar-compra').on('click', function() {
      let idProducto = $(this).data('id');
      enviarCarrito(idProducto);
    });

    function enviarCarrito(idProducto) {
      $.ajax({
        url: "./action/actionRealizarCompra.php",
        type: "POST",
        data: {
          idproducto: idProducto
        },
        success: function(result) {
        $('.ui.modal').html(`
          <div class="header">¡Compra Realizada!</div>
          <div class="content">
            <p>Tu compra se ha realizado con éxito. Gracias por elegirnos.</p>
          </div>
        `).modal('show');
        setTimeout(function() {
          location.reload()
        }, 2000);
},
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });
    }

    function actualizarTotal(total) {
      $('.total').text('$' + total);
    }
  });
</script>

<?php footer(); ?>