<?php
	require_once 'private/initialize.php';

  $title = "Page Template"; 
  // this is for <title>

  $page_heading = "This is the master page template";
  // This is for breadcrumbs if I want a custom title other than the default

  $page_subheading = "This is the subheading"; 
  // This is the subheading

  $custom_class = "master-page-template"; 
  //custom CSS for this page only

  include_once('includes/site-header.php');
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
</div>

<div class="container <?php echo $custom_class; ?>">
    <div class="row">
    <div class="col-4">
    <div class="card p-4 mb-4">
        <h3>Heading 3</h3>
        <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone.</p>
    </div>
    </div>
    <div class="col-4">
      <div class="card p-4 mb-4">
          <h3>Heading 3</h3>
          <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone.</p>
      </div>
    </div>
    <div class="col-4">
      <div class="card p-4 mb-4">
          <h3>Heading 3</h3>
          <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone.</p>
      </div>
    </div>
    </div>

    <div class="row icon-example">
        <div class="col-4">
        <div class="card p-4 mb-4">
            <span class="icon analyst-report"></span>
            <h3>Heading 3</h3>
            <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone.</p>
        </div>
        </div>
        <div class="col-4">
          <div class="card p-4 mb-4">
              <span class="icon analyst-report"></span>
              <h3>Heading 3</h3>
              <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone.</p>
          </div>
        </div>
        <div class="col-4">
          <div class="card p-4 mb-4">
              <span class="icon analyst-report"></span>
              <h3>Heading 3</h3>
              <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone.</p>
          </div>
        </div>
    </div>
</div>

<!-- end .container-->

<?php include 'includes/site-footer.php';?>