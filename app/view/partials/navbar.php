<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/E-Commerce/app/view/layouts/header.php';


$objMenu = new AbmMenu();
$mostrarMenu = $objMenu->obtenerMenu();

?>
<link rel="stylesheet" href="../../css/style.css">
<nav class="ui menu">
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
        ?>

        <?php if ($hasAccess): ?>
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
                                <a href="<?= htmlspecialchars(BASE_URL . $item['link']) ?>"
                                    class="item <?= ($_SERVER['REQUEST_URI'] === BASE_URL . $item['link']) ? 'active' : '' ?>">
                                    <?= htmlspecialchars($subitem['menombre']) ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <a href="<?= htmlspecialchars($item['link']) ?>"
                    class="item <?= ($_SERVER['REQUEST_URI'] === $item['link']) ? 'active' : '' ?>">
                    <?= htmlspecialchars($item['menombre']) ?>
                </a>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</nav>
<script>
    $('.ui.dropdown').dropdown()
</script>