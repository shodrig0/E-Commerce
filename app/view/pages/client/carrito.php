<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';

$carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : (isset($_COOKIE['carrito']) ? json_decode($_COOKIE['carrito'], true) : []);
?>
<div class="ui segment carrito-container">
    <h2 class="ui header">Carrito de Compras</h2>
    <div class="ui divided items">
        <?php if (!empty($carrito)): ?>
            <?php
            $total = 0;
            foreach ($carrito as $producto):
                $subtotal = $producto['precio'] * $producto['cantidad'];
                $total += $subtotal;
            ?>
                <div class="item">
                    <div class="content">
                        <div class="header"><?php echo htmlspecialchars($producto['pronombre']); ?></div>
                        <div class="description">
                            <p><?php echo htmlspecialchars($producto['prodetalle']); ?></p>
                        </div>
                        <div class="extra">
                            <div><strong>Precio:</strong> <?php echo number_format($producto['precio'], 2); ?> ARS</div>
                            <div><strong>Cantidad:</strong> <?php echo $producto['cantidad']; ?></div>
                            <div><strong>Subtotal:</strong> <?php echo number_format($subtotal, 2); ?> ARS</div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="ui clearing divider"></div>
            <div class="ui segment">
                <h3>Total: <?php echo number_format($total, 2); ?> ARS</h3>
                <button class="ui blue button">Finalizar Compra</button>
            </div>
        <?php else: ?>
            <div class="ui message">
                <p>Tu carrito está vacío. ¡Explora nuestra <a href="/E-Commerce/galeria.php">galería de productos</a> para agregar artículos!</p>
            </div>
        <?php endif; ?>
    </div>
</div>
