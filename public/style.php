<?php
    require_once '../private/initialize.php';
    $title = "Elements Page"; // this is for <title>
    $page_title = "This is the elements page"; //this is for breadcrumbs if I want a custom title other than the default
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
                    <span class="d-block font-weight-bold py-2">Style</span>
                </div>
            </div>
            <div class="col-12 col-md-10">
			    <?php include(STYLE_PATH . '/colors.php'); ?>
			    <?php include(STYLE_PATH . '/bg-test.php'); ?>
			    <?php include(STYLE_PATH . '/typography.php'); ?>
			    <?php include(STYLE_PATH . '/icons.php'); ?>
            </div>
        </div>
    </div>
</div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');