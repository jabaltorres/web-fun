<?
  require_once 'config.php';

  $title = "Page Template"; 
  // this is for <title>

  $page_title = "This is the master page template";
  // This is for breadcrumbs if I want a custom title other than the default

  $page_subheading = "This is the subheading"; 
  // This is the subheading

  $custom_class = "master-page-template"; 
  //custom CSS for this page only

  include_once('includes/head.php');
?>

<div class="container <?php echo $custom_class; ?>">
  
  <?php include 'includes/masthead.php';?>
  <?php include 'includes/navigation.php';?>

  <section>

    <hgroup>
      <h1><?php echo $title; ?></h1>
      <h2><?php echo $page_subheading; ?></h2>
    </hgroup>

    <p>Insert some components and cool stuff</p>
    
  </section>

<?php include 'includes/feet.php';?>