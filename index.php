<?php

  // TODO: Add clear documentation of how to set this up locally.
  require_once 'config.php';

  $title = "Home Page";
  // this is for <title>

  $page_heading = "This is the home page";
  // This is for breadcrumbs if I want a custom title other than the default

  $page_subheading = "Welcome to the homepage"; 
  // This is the subheading

  $custom_class = "home-page"; 
  //custom CSS for this page only

  include_once('includes/head.php');
?>
  
	<div class="container <?php echo $custom_class; ?>">
  
  <?php 
    include 'includes/masthead.php';
    include 'includes/navigation.php';
  ?>
		
	<section>
		<?php include_once(INCLUDES_PATH . '/headline-page.php');?>
	</section>

  <?php include 'blocks/hero.php'; ?>
	<!-- <?php include 'blocks/github-gist.php'; ?> -->
<?php include 'includes/feet.php';?>