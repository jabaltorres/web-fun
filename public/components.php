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

    <div class="site-inner">
        <div class="row">
            <div class="col-12 col-md-2 lorem-sidebar">
                <div class="article-list-wrapper sticky-top">
                    <span class="d-block font-weight-bold py-2">Components</span>
                </div>
            </div>
            <div class="col-12 col-md-10">
			    <?php include(COMPONENTS_PATH . '/slick-carousel.php'); ?>
			    <?php include(COMPONENTS_PATH . '/alerts.php'); ?>
			    <?php include(COMPONENTS_PATH . '/cards.php'); ?>
			    <?php include(COMPONENTS_PATH . '/jumbotron.php'); ?>
			    <?php include(COMPONENTS_PATH . '/nav-bar.php'); ?>
            </div>
        </div>
    </div>



</div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');