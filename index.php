<?php

  // TODO: Add clear documentation of how to set this up locally.
  require_once 'private/initialize.php';

  $title = "Home Page";
  // this is for <title>

  $page_heading = "This is the home page";
  // This is for breadcrumbs if I want a custom title other than the default

  $page_subheading = "Welcome to the homepage"; 
  // This is the subheading

  $custom_class = "home-page"; 
  //custom CSS for this page only

  include_once('includes/site-header.php');
?>
  
<div class="container <?php echo $custom_class; ?>">
  
    <?php
        include_once(INCLUDES_PATH . '/masthead.php');
        include_once(INCLUDES_PATH . '/navigation.php');
    ?>
		
	<section>
		<?php include_once(INCLUDES_PATH . '/headline-page.php');?>
	</section>

    <?php include_once(BLOCKS_PATH . '/hero.php'); ?>

    <div class="row icon-example">
        <div class="col-12 col-md-4">
            <div class="card p-4 mb-4">
                <span class="icon analyst-report text-center"></span>
                <h3>Heading 3</h3>
                <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone.</p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-4 mb-4">
                <span class="icon analyst-report text-center"></span>
                <h3>Heading 3</h3>
                <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone.</p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-4 mb-4">
                <span class="icon analyst-report text-center"></span>
                <h3>Heading 3</h3>
                <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone.</p>
            </div>
        </div>
    </div>
</div>

<?php include_once('includes/site-footer.php');?>