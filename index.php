<?php

  // TODO: Add clear documentation of how to set this up locally.
  require_once 'private/initialize.php';

  $title = "Home Page";
  // this is for <title>

  $page_heading = "Hello World!";
  // This is for breadcrumbs if I want a custom title other than the default

  $page_subheading = "Welcome to my web sandbox. More work to come soon. Stay tuned.";
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

    <div class="jumbotron">
        <h1 class="display-4"><?php echo $page_heading; ?></h1>
        <p class="lead"><?php echo $page_subheading; ?></p>
        <a class="btn btn-primary btn-lg" href="https://github.com/capitalJT/web-fun" role="button">Visit the repo</a>
    </div>

    <div class="row icon-example">
        <div class="col-12 col-md-4">
            <div class="card p-4 mb-4">
                <span class="icon analyst-report text-center"></span>
                <h3>KrateCMS</h3>
                <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone.</p>
                <a href="public/index.php" class="btn btn-primary">KrateCMS</a>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-4 mb-4">
                <span class="icon analyst-report text-center"></span>
                <h3>Contacts</h3>
                <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone.</p>
                <a href="public/contacts/index.php" class="btn btn-primary">Contacts</a>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card p-4 mb-4">
                <span class="icon analyst-report text-center"></span>
                <h3>Users</h3>
                <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone.</p>
                <a href="public/users/index.php" class="btn btn-primary">Users</a>
            </div>
        </div>
    </div>
</div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');?>