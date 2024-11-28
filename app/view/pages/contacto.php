<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';
?>

<div class="ui container">
    <h1 class="ui header">Contactos</h1>
    <div class="ui grid">
        <!-- Contacto 1 -->
        <div class="four wide column">
            <div class="card" style="height: 350px; display: flex; flex-direction: column; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <div class="image" style="flex-grow: 1; display: flex; justify-content: center; align-items: center; height: 150px;">
                    <i class="user circle icon massive" style="color: #9C27B0;"></i>
                </div>
                <div class="content" style="text-align: center; padding: 15px;">
                    <h2 class="header">Brisa Celayes</h2>
                    <div class="meta" style="color: #888; font-size: 0.9em;">
                        <span>Legajo: 1234</span>
                    </div>
                    <div class="description" style="font-size: 1em;">
                        <p style="display: flex; align-items: center; justify-content: center;">
                            <strong>Gmail: </strong> <a href="mailto:brisa@gmail.com">brisa@gmail.com</a>
                        </p>
                        <p style="display: flex; align-items: center; justify-content: center;">
                            <strong>Git: </strong> <a href="mailto:brisa@domain.com">brisa@domain.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contacto 2 -->
        <div class="four wide column">
            <div class="card" style="height: 350px; display: flex; flex-direction: column; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <div class="image" style="flex-grow: 1; display: flex; justify-content: center; align-items: center; height: 150px;">
                    <i class="user circle icon massive" style="color: #FF5722;"></i>
                </div>
                <div class="content" style="text-align: center; padding: 15px;">
                    <h2 class="header">Martin De La Iglesia</h2>
                    <div class="meta" style="color: #888; font-size: 0.9em;">
                        <span>Legajo: 5678</span>
                    </div>
                    <div class="description" style="font-size: 1em;">
                        <p style="display: flex; align-items: center; justify-content: center;">
                            <strong>Gmail: </strong> <a href="mailto:martin@gmail.com">martin@gmail.com</a>
                        </p>
                        <p style="display: flex; align-items: center; justify-content: center;">
                            <strong>Git: </strong> <a href="mailto:martint@domain.com">martint@domain.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contacto 3 -->
        <div class="four wide column">
            <div class="card" style="height: 350px; display: flex; flex-direction: column; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <div class="image" style="flex-grow: 1; display: flex; justify-content: center; align-items: center; height: 150px;">
                    <i class="user circle icon massive" style="color: #2196F3;"></i>
                </div>
                <div class="content" style="text-align: center; padding: 15px;">
                    <h2 class="header">Rodrigo Velo</h2>
                    <div class="meta" style="color: #888; font-size: 0.9em;">
                        <span>Legajo: 9101</span>
                    </div>
                    <div class="description" style="font-size: 1em;">
                        <p style="display: flex; align-items: center; justify-content: center;">
                            <strong>Gmail: </strong> <a href="mailto:rodri@gmail.com">rodri@gmail.com</a>
                        </p>
                        <p style="display: flex; align-items: center; justify-content: center;">
                            <strong>Git: </strong> <a href="mailto:rodri@domain.com">rodri@domain.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contacto 4 -->
        <div class="four wide column">
            <div class="card" style="height: 350px; display: flex; flex-direction: column; border: 1px solid #ddd; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                <div class="image" style="flex-grow: 1; display: flex; justify-content: center; align-items: center; height: 150px;">
                    <i class="user circle icon massive" style="color: #4CAF50;"></i>
                </div>
                <div class="content" style="text-align: center; padding: 15px;">
                    <h2 class="header">Rodrigo Villablanca</h2>
                    <div class="meta" style="color: #888; font-size: 0.9em;">
                        <span>Legajo: 1213</span>
                    </div>
                    <div class="description" style="font-size: 1em;">
                        <p style="display: flex; align-items: center; justify-content: center;">
                            <strong>Gmail: </strong> <a href="mailto:rodriz@gmail.com">rodriz@gmail.com</a>
                        </p>
                        <p style="display: flex; align-items: center; justify-content: center;">
                            <strong>Git: </strong> <a href="mailto:rodri@domain.com">rodri@domain.com</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div style="border-top: 2px solid #ddd; margin-top: 20px;"></div>

<?php footer(); ?>
