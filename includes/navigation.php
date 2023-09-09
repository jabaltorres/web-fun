<?php
    $pages = [
        ['id' => '1', 'position' => '1', 'visible' => '1', 'menu_name' => 'Brand', 'page_url' => 'public/brand/index.php'],
        ['id' => '2', 'position' => '2', 'visible' => '1', 'menu_name' => 'Elements', 'page_url' => 'public/elements/index.php'],
        ['id' => '3', 'position' => '3', 'visible' => '1', 'menu_name' => 'Components', 'page_url' => 'public/components/index.php'],
        ['id' => '4', 'position' => '4', 'visible' => '1', 'menu_name' => 'Demos', 'page_url' => 'demos/index.php'],
        ['id' => '5', 'position' => '5', 'visible' => '1', 'menu_name' => 'Blog', 'page_url' => 'public/blog/index.php'],
    ];
?>

<nav class="main-navigation">
    <?php foreach ($pages as $page): ?>
        <li><a class="d-inline-block" href="<?php echo $url . '/' . h($page['page_url']); ?>" alt="" title="" target=""><?php echo h($page['menu_name']); ?></a></li>
    <?php endforeach; ?>
</nav>