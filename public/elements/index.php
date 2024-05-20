<?php
    require_once '../../src/initialize.php';
    $title = "Elements Page"; // this is for <title>
    $page_title = "This is the elements page"; //this is for breadcrumbs if I want a custom title other than the default
    $addCSS = ""; //custom CSS for this page only
    include('../../templates/layout/header.php');
?>

<div class="container">
    <div class="site-inner">
        <div class="row">
            <div class="col-12 col-md-2 lorem-sidebar">
                <div class="article-list-wrapper sticky-top">
                    <span class="d-block font-weight-bold py-2">Elements</span>
                </div>
            </div>
            <div class="col-12 col-md-10">
                <?php include('images.php'); ?>
                <?php include('buttons.php'); ?>
                <?php include('lists.php'); ?>
                <?php include('labels.php'); ?>
                <?php include('inputs.php'); ?>
            </div>
        </div>
    </div>
</div>

<?php include('../../templates/layout/footer.php'); ?>