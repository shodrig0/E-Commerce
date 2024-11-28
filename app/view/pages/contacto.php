<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';
?>

<div class="ui container">
    <h1 class="ui header">Contactos</h1>
    <div class="ui four stackable doubling cards" style="gap: 2rem;">
        <!-- Contacto 1 -->
        <div class="card" style="height: 350px;">
            <div class="image" style="display: flex; justify-content: center; align-items: center; height: 150px;">
                <i class="user circle icon massive"></i>
            </div>
            <div class="content" style="text-align: center;">
                <h2 class="header">Brisa Celayes</h2>
                <div class="meta">
                    <span>Legajo: 1234</span>
                </div>
                <div class="description">
                    <p><strong>Gmail:</strong> <a href="mailto:juan.perez@gmail.com">juan.perez@gmail.com</a></p>
                    <p><strong>Correo Git:</strong> <a href="mailto:juan.git@domain.com">juan.git@domain.com</a></p>
                </div>
            </div>
        </div>

        <!-- Contacto 2 -->
        <div class="card" style="height: 350px;">
            <div class="image" style="display: flex; justify-content: center; align-items: center; height: 150px;">
                <i class="user circle icon massive"></i>
            </div>
            <div class="content" style="text-align: center;">
                <h2 class="header">Martin De La Iglesia</h2>
                <div class="meta">
                    <span>Legajo: 5678</span>
                </div>
                <div class="description">
                    <p><strong>Gmail:</strong> <a href="mailto:maria.gomez@gmail.com">maria.gomez@gmail.com</a></p>
                    <p><strong>Correo Git:</strong> <a href="mailto:maria.git@domain.com">maria.git@domain.com</a></p>
                </div>
            </div>
        </div>

        <!-- Contacto 3 -->
        <div class="card" style="height: 350px;">
            <div class="image" style="display: flex; justify-content: center; align-items: center; height: 150px;">
                <i class="user circle icon massive"></i>
            </div>
            <div class="content" style="text-align: center;">
                <h2 class="header">Rodrigo Velo</h2>
                <div class="meta">
                    <span>Legajo: 9101</span>
                </div>
                <div class="description">
                    <p><strong>Gmail:</strong> <a href="mailto:pedro.rodriguez@gmail.com">pedro.rodriguez@gmail.com</a></p>
                    <p><strong>Correo Git:</strong> <a href="mailto:pedro.git@domain.com">pedro.git@domain.com</a></p>
                </div>
            </div>
        </div>

        <!-- Contacto 4 -->
        <div class="card" style="height: 350px;">
            <div class="image" style="display: flex; justify-content: center; align-items: center; height: 150px;">
                <i class="user circle icon massive"></i>
            </div>
            <div class="content" style="text-align: center;">
                <h2 class="header">Rodrigo Villablanca</h2>
                <div class="meta">
                    <span>Legajo: 1213</span>
                </div>
                <div class="description">
                    <p><strong>Gmail:</strong> <a href="mailto:lucia.martinez@gmail.com">lucia.martinez@gmail.com</a></p>
                    <p><strong>Correo Git:</strong> <a href="mailto:lucia.git@domain.com">lucia.git@domain.com</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php footer(); ?>
