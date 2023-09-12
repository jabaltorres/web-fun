<?php
    require_once '../../private/initialize.php';
    // this is for <title>
    $title = "JS Fun";

    // This is for breadcrumbs if I want a custom title other than the default
    $page_heading = "Javascript playground";

    // This is the subheading
    $page_subheading = "Scripting Sandbox";

    //custom CSS for this page only
	$custom_class = "javascript-page mb-4";

    include_once(INCLUDES_PATH . '/site-header.php');
?>

    <div class="container <?php echo $custom_class; ?>">
		<?php include(INCLUDES_PATH . '/masthead.php'); ?>
		<?php include(INCLUDES_PATH . '/navigation.php'); ?>

        <?php include('incl/pop-up.php'); ?>

        <section class="js-fun">
            <p class="lead">This page includes pop up functionality</p>

			<?php include_once(INCLUDES_PATH . '/headline-page.php');?>
        </section>

        <section class="js-playground">

            <?php timeOfDayGreeting(); ?>

            <div class="entry-content">
                This is rendered content.
                <?php
                    /**
                     * This is just a comment to remind me that content gets rendered here
                     */
                ?>
                <ul></ul>
            </div>
        </section>

        <section class="js-append-something">
            <h3>This is from the getJSON function in apps.js</h3>
        </section>

        <section>
            <?php include(BLOCKS_PATH . '/github-gist.php'); ?>
        </section>

    </div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');?>
