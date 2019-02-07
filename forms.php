<?php
  require_once 'config.php';
  $title = "Form Page"; // this is for <title>
  $page_title = "This is the form page"; //this is for breadcrumbs if I want a custom title other than the default
  $addCSS = ""; //custom CSS for this page only
  include_once('includes/site-header.php');
?>

<div class="container">
    <?php include 'includes/masthead.php';?>
    <?php include 'includes/navigation.php';?>

    <section class="forms">

        <div class="hgroup">
            <h1>Forms</h1>
            <h2>Sub headline</h2>
        </div>

        <form method="post" action="acknowledge.php">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name">

            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email">

            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="subject">

            <label for="message">Message:</label>
            <textarea name="message" id="message"></textarea>

            <input type="submit" name="send" value="Send Message" class="btn btn-primary">
        </form>
    </section>
</div>

<?php include 'includes/site-footer.php';?>