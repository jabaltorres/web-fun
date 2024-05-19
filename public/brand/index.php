<?php
    require_once '../../src/initialize.php';
    $title = "Elements Page"; // this is for <title>
    $page_title = "This is the elements page"; //this is for breadcrumbs if I want a custom title other than the default
    $addCSS = ""; //custom CSS for this page only
    include_once(SHARED_PATH . '/site_header.php');
?>

<?php include_once(SHARED_PATH . '/navigation.php'); ?>

<div class="container">
    <div class="site-inner">
        <div class="row">
            <div class="col-12 col-md-2 lorem-sidebar">
                <div class="article-list-wrapper sticky-top">
                    <span class="d-block font-weight-bold py-2">Brand</span>
                </div>
            </div>
            <div class="col-12 col-md-10">
			    <?php include('colors.php'); ?>
			    <?php include('bg-test.php'); ?>
			    <?php include('typography.php'); ?>
			    <?php include('icons.php'); ?>
            </div>
        </div>
    </div>
</div>

<?php include_once(SHARED_PATH . '/site_footer.php');