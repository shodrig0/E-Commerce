<?php 
include_once '../../layouts/header.php';
?>

<div class="ui container">
    <table class="ui celled table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Es submenú de</th>
                <th>Roles Permitidos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menus[null] as $menu): ?>
            <tr>
                <td><?= htmlspecialchars($menu['menombre']); ?></td>
                <td><?= htmlspecialchars($menu['medescripcion']); ?></td>
                <td><?= $menu['idpadre'] ? $menus[null][$menu['idpadre']]['menombre'] : 'N/A'; ?></td>
                <td>
                    <button class="ui button">Editar</button>
                    <button class="ui button red">Eliminar</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="ui container">
    <?php
    $obj = new Menu();
    print_r($obj);

    ?>
    
    
    
    
    
    
</div>