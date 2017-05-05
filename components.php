<?
  require_once 'config.php';
  $title = "Components Page"; // this is for <title>
  $page_title = "This is the components page"; //this is for breadcrumbs if I want a custom title other than the default
  $addCSS = ""; //custom CSS for this page only
  include_once('includes/head.php');
?>

<div class="container">
  <?php include 'includes/masthead.php';?>
  <?php include 'includes/navigation.php';?>

  <?php include "blocks/buttons.php"; ?>
  <?php include "blocks/slick-carousel.php"; ?>
  <?php include "blocks/tooltip.php"; ?>


<?php include 'includes/feet.php';?>