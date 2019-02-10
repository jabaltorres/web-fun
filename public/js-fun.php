<?php
require_once '../private/initialize.php';

  $title = "JS Fun"; 
  // this is for <title>

  $page_heading = "This is the js fun page";
  // This is for breadcrumbs if I want a custom title other than the default

  $page_subheading = "Welcome to the JS FUN page!"; 
  // This is the subheading

  $custom_class = "js-fun-page mb-4";
  //custom CSS for this page only

include_once(INCLUDES_PATH . '/site-header.php');
?>
  
<div class="container <?php echo $custom_class; ?>">
  

    <?php include(INCLUDES_PATH . '/masthead.php'); ?>
    <?php include(INCLUDES_PATH . '/navigation.php'); ?>
    <?php include(INCLUDES_PATH . '/aivl-pop-up.php'); ?>

    
  <section class="js-fun">
    <span class="icon analyst-report"></span>

    <p>This page is different because it `have the aivl` pop up, which I want to remove</p>

    <?php include_once(INCLUDES_PATH . '/headline-page.php');?>
  </section>

    <?php include(BLOCKS_PATH . '/hero.php'); ?>

    <?php include(BLOCKS_PATH . '/github-gist.php'); ?>
</div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');?>