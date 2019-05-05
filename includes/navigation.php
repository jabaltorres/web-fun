<?php
    $pages = [
        ['id' => '1', 'position' => '1', 'visible' => '1', 'menu_name' => 'Brand', 'page_url' => 'public/brand.php'],
        ['id' => '2', 'position' => '2', 'visible' => '1', 'menu_name' => 'Elements', 'page_url' => 'public/elements.php'],
        ['id' => '3', 'position' => '3', 'visible' => '1', 'menu_name' => 'Components', 'page_url' => 'public/components.php'],
        ['id' => '4', 'position' => '4', 'visible' => '1', 'menu_name' => 'Demos', 'page_url' => 'demos/index.php'],
    ];
?>

<nav class="main-navigation">
    <?php
        foreach ($pages as $page){ ?>
            <li>
                <a class="d-inline-block" href="<?php echo $url . '/' . h($page['page_url']); ?>" alt="" title="" target=""><?php echo h($page['menu_name']); ?></a>
            </li>
        <?php }
    ?>
</nav>

<!--<nav class="main-navigation">-->
<!--	--><?php
//		foreach ($pages as $page){ ?>
<!--            <li>-->
<!--                <div class="d-inline-block"> --><?php //echo h($page['id']); ?><!-- </div>-->
<!--                <div class="d-inline-block"> --><?php //echo h($page['position']); ?><!-- </div>-->
<!--                <div class="d-inline-block"> --><?php //echo h($page['visible']); ?><!-- </div>-->
<!--                <div class="d-inline-block"> --><?php //echo h($page['menu_name']); ?><!-- </div>-->
<!--                <div class="d-inline-block"> --><?php //echo h($page['page_url']); ?><!-- </div>-->
<!--            </li>-->
<!--		--><?php //}
//	?>
<!--</nav>-->