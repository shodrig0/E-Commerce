<div class="ui container segment raised" style="max-width: 600px; margin-top: 20px;">
    <h2 class="ui teal header">
        <i class="cart plus icon"></i>
        <div class="content">Agregar Producto</div>
    </h2>
    <form class="ui form" id="agregarProductoForm">
        <div class="field">
            <label><i class="tag icon"></i> Nombre del Producto</label>
            <input type="text" name="nombre" placeholder="Ejemplo: Cerveza Artesanal" required>
        </div>
        <div class="field">
            <label><i class="info circle icon"></i> Detalle</label>
            <textarea name="detalle" placeholder="Descripción detallada del producto"></textarea>
        </div>
        <div class="field">
            <label><i class="dollar sign icon"></i> Precio</label>
            <div class="ui labeled input">
                <div class="ui label">$</div>
                <input type="number" name="precio" placeholder="100.00" min="0" step="0.01" required>
            </div>
        </div>
        <div class="field">
            <label><i class="boxes icon"></i> Stock Disponible</label>
            <input type="number" name="stock" placeholder="Cantidad en stock" min="0" required>
        </div>
        <button type="submit" class="ui large teal button fluid">
            <i class="plus icon"></i> Agregar Producto
        </button>
    </form>
    <div id="mensajeResultado" style="margin-top: 20px;"></div>
</div>
<script src="../js/enviarFormulario.js"></script>
<script>
$(document).ready(function () {
    manejarFormSubmit(
        "#agregarProductoForm",                
        "./action/actionAgregarProducto.php", 
        "./"          
    );
});

</script>