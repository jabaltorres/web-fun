<?php
    require_once '../private/initialize.php';
    $title = "Components Page"; // this is for <title>
    $page_title = "This is the components page"; //this is for breadcrumbs if I want a custom title other than the default
    $addCSS = ""; //custom CSS for this page only
    include_once(INCLUDES_PATH . '/site-header.php');
?>

<div class="container">
    <?php include_once(INCLUDES_PATH . '/masthead.php'); ?>
    <?php include_once(INCLUDES_PATH . '/navigation.php'); ?>

    <?php include(BLOCKS_PATH . '/buttons.php'); ?>
    <?php include(BLOCKS_PATH . '/slick-carousel.php'); ?>
    <?php include(BLOCKS_PATH . '/tooltip.php'); ?>
</div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');