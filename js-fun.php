<?php
  require_once 'config.php';

  $title = "JS Fun"; 
  // this is for <title>

  $page_heading = "This is the js fun page";
  // This is for breadcrumbs if I want a custom title other than the default

  $page_subheading = "Welcome to the JS FUN page!"; 
  // This is the subheading

  $custom_class = "js-fun-page"; 
  //custom CSS for this page only

  include_once('includes/site-header.php');
?>
  
<div class="container <?php echo $custom_class; ?>">
  
  <?php 
    include 'includes/masthead.php';
    include 'includes/navigation.php';
    include 'includes/aivl-pop-up.php'; 
  ?>
    
  <section class="js-fun">
    <span class="icon analyst-report"></span>

    <p>This page is different because it `have the aivl` pop up, which I want to remove</p>

    <?php include_once(INCLUDES_PATH . '/headline-page.php');?>
  </section>

  <?php include 'blocks/hero.php'; ?>

  <?php include 'blocks/github-gist.php'; ?> 
</div>

<?php include 'includes/site-footer.php';?>