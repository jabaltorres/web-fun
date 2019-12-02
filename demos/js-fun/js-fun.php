<?php
    require_once '../../private/initialize.php';
    // this is for <title>
    $title = "JS Fun";

    // This is for breadcrumbs if I want a custom title other than the default
    $page_title = "Javascript playground";

    // This is the subheading
    $page_subheading = "Make your own scripts";

    //custom CSS for this page only
	$custom_class = "js-fun-page mb-4";

    include_once(INCLUDES_PATH . '/site-header.php');
?>

    <div class="container <?php echo $custom_class; ?>">
		<?php include(INCLUDES_PATH . '/masthead.php'); ?>
		<?php include(INCLUDES_PATH . '/navigation.php'); ?>
		<?php include('pop-up.php'); ?>

        <section class="js-fun">
            <p class="lead">This page includes pop up functionality</p>

			<?php include_once(INCLUDES_PATH . '/headline-page.php');?>
        </section>

        <section class="js-append-something">

        </section>

		<?php //include(BLOCKS_PATH . '/github-gist.php'); ?>
    </div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');?>