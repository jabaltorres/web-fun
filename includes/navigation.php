<?php
$pages = [
    ['id' => '1', 'position' => '1', 'visible' => '1', 'menu_name' => 'Brand', 'page_url' => 'public/brand/index.php'],
    ['id' => '2', 'position' => '2', 'visible' => '1', 'menu_name' => 'Elements', 'page_url' => 'public/elements/index.php'],
    ['id' => '3', 'position' => '3', 'visible' => '1', 'menu_name' => 'Components', 'page_url' => 'public/components/index.php'],
    ['id' => '4', 'position' => '4', 'visible' => '1', 'menu_name' => 'Demos', 'page_url' => 'demos/index.php'],
    ['id' => '5', 'position' => '5', 'visible' => '1', 'menu_name' => 'Blog', 'page_url' => 'public/blog/index.php'],
];
?>

<nav class="main-navigation navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
        <?php

        // get the current page url
        $current_url = $_SERVER['REQUEST_URI'];

        // remove forward slash from $current_url
        $current_url = ltrim($current_url, '/');

        foreach ($pages as $page): ?>
            <?php

            // TODO: Make this ternaly operator
            if ($current_url == $page['page_url']) {
                $activeStyleClass = 'active';
            } else {
                $activeStyleClass = '';
            }
            // check if page is visible
            if ($page['visible'] == '1') { ?>
                <li><a class="nav-link <?php echo $activeStyleClass; ?>" href="<?php echo $url . '/' . h($page['page_url']); ?>"><?php echo h($page['menu_name']); ?></a></li>
            <?php }
            ?>

        <?php endforeach; ?>
        </div>
    </div>
</nav>