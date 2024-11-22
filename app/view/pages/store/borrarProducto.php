<div class="ui container segment raised" style="max-width: 600px; margin-top: 20px;">
    <h2 class="ui red header">
        <i class="trash alternate icon"></i>
        <div class="content">Borrar Producto</div>
    </h2>

    <form class="ui form" id="borrarProductoForm" method="POST" action="/delete-product">
        <!-- ID del producto -->
        <div class="field">
            <label><i class="hashtag icon"></i> ID del Producto</label>
            <input type="number" name="productId" placeholder="Ejemplo: 123" required>
        </div>
        <button type="submit" class="ui large red button fluid">
            <i class="trash icon"></i> Borrar Producto
        </button>
    </form>

    <div id="mensajeResultado" style="margin-top: 20px;"></div>
</div>
