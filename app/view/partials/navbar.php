<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/config.php';

$objMenu = new AbmMenu();
$mostrarMenu = $objMenu->obtenerMenu();
$hasAccess = '';
?>
<link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
<nav class="ui menu custom-menu">
    <?php foreach ($mostrarMenu as $item): ?>
        <?php
        $menuRoles = isset($item['roles']) && !empty($item['roles'])
            ? array_map('trim', explode(',', $item['roles']))
            : [];
        $hasAccess = empty($menuRoles) || array_intersect($userRoles, $menuRoles);
        $isLogin = strtolower($item['menombre']) === 'login';
        if ($isLogin && $usuario) {
            continue;
        }
        if ($hasAccess): ?>
            <?php if (!empty($item['subitems'])): ?>
                <div class="ui simple dropdown item">
                    <?= htmlspecialchars($item['menombre']) ?>
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <?php foreach ($item['subitems'] as $subitem): ?>
                            <?php

                            $subitemRoles = isset($subitem['roles']) && !empty($subitem['roles'])
                                ? array_map('trim', explode(',', $subitem['roles']))
                                : [];
                            $hasSubitemAccess = empty($subitemRoles) || array_intersect($userRoles, $subitemRoles);
                            ?>
                            <?php if ($hasSubitemAccess): ?>
                                <a href="<?= htmlspecialchars(BASE_URL . $subitem['link']) ?>" class="item <?= ($_SERVER['REQUEST_URI'] === BASE_URL . $subitem['link']) ? 'active' : '' ?>">
                                    <?= htmlspecialchars($subitem['menombre']) ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?= htmlspecialchars(BASE_URL . $item['link']) ?>" class="item <?= ($_SERVER['REQUEST_URI'] === BASE_URL . $item['link']) ? 'active' : '' ?>">
                    <?= htmlspecialchars($item['menombre']) ?>
                </a>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>

<style>
    .custom-menu {
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .ui.menu {
        background-color: rgba(89, 62, 50, 0.85);
    }

    .ui.menu.custom-menu .item {
        border-radius: 10px;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
        color: white;
        text-transform: uppercase;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .ui.menu.custom-menu .item:hover {
        background-color: #fff;
        color: rgba(64, 76, 18);
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .ui.menu.custom-menu .item:not(:hover) {
        transition: all 0.3s ease;
    }

    .ui.menu .item::before {
        content: none;
    }

    .ui.menu::after {
        content: none;
    }

    .ui.simple.dropdown .menu .item:hover {
        background-color: #444 !important;
    }
</style>