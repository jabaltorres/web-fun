<?
  $title = "Demo Index file"; // this is for <title>
  $page_title = "This is the demo index file"; //this is for breadcrumbs if I want a custom title other than the default
  $custom_class = "demo-page"; //custom CSS for this page only
  require_once '../config.php';
  include_once('../includes/head.php');
?>

  <div class="container <?php echo $custom_class; ?>">
  
  <?php 
    include '../includes/masthead.php';
    include '../includes/navigation.php';
  ?>

  <section>
    <hgroup>
      <h1><?php echo $page_title; ?></h1>
      <h2>Sub headline</h2>
    </hgroup>
    <p>Insert web fun here</p>
  </section>

  <section>
    <ul class="menu">
      <li><a href="flipper.php">Flipper</a></li>
      <li><a href="host-info.php">Host Info</a></li>
      <li><a href="lorem-ipsum.php">Lorem Ipsum</a></li>
      <li><a href="../mustache.php">Mustache.js</a></li>
    </ul>
  </section>

<?php include '../includes/feet.php';?>