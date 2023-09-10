<?php
    require_once '../../private/initialize.php';
    // this is for <title>
    $title = "JS Fun";

    // This is for breadcrumbs if I want a custom title other than the default
    $page_heading = "Javascript playground";

    // This is the subheading
    $page_subheading = "Make your own scripts";

    //custom CSS for this page only
	$custom_class = "js-fun-page mb-4";

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
            <div class="greeting-msg">
                <?php
                    // echo the time of day
                    $time = date("H");
                    if ($time < "12") {
                        echo "Good morning";
                    } elseif ($time >= "12" && $time < "17") {
                        echo "Good afternoon";
                    } elseif ($time >= "17" && $time < "19") {
                        echo "Good evening";
                    } elseif ($time >= "19") {
                        echo "Good night";
                    }
                ?>
            </div>
            <div class="entry-content">
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

		<?php //include(BLOCKS_PATH . '/github-gist.php'); ?>
    </div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');?>

<script>
	// this is an IIFE
    (function () {
	    // define variables
	    let name = "John Doe";
	    let age = 25;
		console.log( name + " is " + age + " years old." );
	    console.log('This is from the js-fun.php page');
    })();
</script>

