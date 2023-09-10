<?php
    $title = "Demo Index file"; // this is for <title>
    $page_title = "This is the demo index file"; //this is for breadcrumbs if I want a custom title other than the default
    $custom_class = "demo-page"; //custom CSS for this page only

    require_once '../private/initialize.php';
    include_once(INCLUDES_PATH . '/site-header.php');
?>

<div class="container">

    <?php include_once(INCLUDES_PATH . '/masthead.php');?>
    <?php include_once(INCLUDES_PATH . '/navigation.php');?>

    <section class="js-fun">
        <hgroup>
            <h1>Big Flipper</h1>
        </hgroup>
        <article>
            <h3>Note:</h3>

            <p>Note: The "flipper" fails to reload if you refresh the browser quickly. Maybe I've got a problem with constantly refreshing the browser</p>

            <p>This button is needed for the flipper</p>
            <button id="action-button" class="btn btn-primary">CLICK ME</button>
        </article>
    </section>

    <div id="wrapper" class="example-container">
        <img class="slide" src="<?php echo $url; ?>/public/images/janky-carousel-img/placholder-1.png" alt="Image 1">
        <img class="slide" src="<?php echo $url; ?>/public/images/janky-carousel-img/placholder-2.png" alt="Image 2">
        <img class="slide" src="<?php echo $url; ?>/public/images/janky-carousel-img/placholder-3.png" alt="Image 3">
        <img class="slide" src="<?php echo $url; ?>/public/images/janky-carousel-img/placholder-4.png" alt="Image 4">
        <img class="slide" src="<?php echo $url; ?>/public/images/janky-carousel-img/placholder-5.png" alt="Image 5">
    </div>
</div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');?>