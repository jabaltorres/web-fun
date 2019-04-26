<?php
    require_once '../private/initialize.php';

    $title = "Demo Index";
    // this is for <title>

    $page_heading = 'Demo Page Heading';
    $page_subheading = "List of WIP demos";

    $custom_class = "demo-page";
    //custom CSS for this page only

	include_once(INCLUDES_PATH . '/site-header.php');
?>

<div class="container <?php echo $custom_class; ?>">
  
    <?php
	    include_once(INCLUDES_PATH . '/masthead.php');
	    include_once(INCLUDES_PATH . '/navigation.php');
    ?>

    <section>
        <?php include_once(INCLUDES_PATH . '/headline-page.php'); ?>
    </section>

    <section>
        <ul class="menu list-unstyled">
            <li><a href="heroes.php">Heroes</a></li>
            <li><a href="<?php echo $url; ?>/public/contacts/index.php">DB Test</a></li>
            <li><a href="js-objects.php">JS Objects</a></li>
            <li><a href="flipper.php">Flipper</a></li>
            <li><a href="host-info.php">Host Info</a></li>
            <li><a href="lorem-ipsum.php">Lorem Ipsum</a></li>
            <li><a href="mustache.php">Mustache.js</a></li>
            <li><a href="forms/forms.php">Forms</a></li>
            <li><a href="js-fun/js-fun.php">JS Fun</a></li>
        </ul>
    </section>

</div><!-- end .container -->

<?php include_once(INCLUDES_PATH . '/site-footer.php'); ?>