<?php
  require_once '../private/initialize.php';

  $title = "Demo Index"; 
  // this is for <title>

  $page_title = "Welcome to the Demos page";
  // This is for breadcrumbs if I want a custom title other than the default

  $page_subheading = "This is the Demo page subheading"; 
  // This is the subheading

  $custom_class = "demo-page"; 
  //custom CSS for this page only

  include_once('../includes/site-header.php');
?>

<div class="container <?php echo $custom_class; ?>">
  
  <?php 
    include '../includes/masthead.php';
    include '../includes/navigation.php';
  ?>

  <section>
    <hgroup>
      <h1><?php echo $page_title; ?></h1>
      <h2><?php echo $page_subheading; ?></h2>
    </hgroup>
  </section>

    <section>
        <ul class="menu">
            <li><a href="/public/contacts/index.php">DB Test</a></li>
            <li><a href="js-objects.php">JS Objects</a></li>
            <li><a href="flipper.php">Flipper</a></li>
            <li><a href="host-info.php">Host Info</a></li>
            <li><a href="lorem-ipsum.php">Lorem Ipsum</a></li>
            <li><a href="mustache.php">Mustache.js</a></li>
            <li><a href="icons.php">Icons</a></li>
        </ul>
    </section>

</div><!-- end .container -->

<?php include '../includes/site-footer.php';?>