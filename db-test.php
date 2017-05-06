<?
  require_once 'config.php';

  $title = "DB Page"; 
  // this is for <title>

  $page_title = "This is the home page";
  // This is for breadcrumbs if I want a custom title other than the default

  $page_subheading = "Welcome to the DB test page"; 
  // This is the subheading

  $custom_class = "db-test-page"; 
  //custom CSS for this page only

  include_once('includes/head.php');
?>

<div class="container <?php echo $custom_class; ?>">

  <?php 
    include 'includes/masthead.php';
    include 'includes/navigation.php';
    include 'includes/email-db-nav.php';
  ?>

  <section>
    <?php include_once(INCLUDES_PATH . '/headline-page.php');?>
    
    <ul>
      <li><a href="addemail.php">Add Email</a></li>
      <li><a href="removeemail.php">Remove Email</a></li>
      <li><a href="sendemail.php">Send Email</a></li>
    </ul>
  </section>

  <section>
    <h4>Database Entries</h4>
    <ul class="email-db-list">
      <?php
        require_once('config.php');

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
          or die('Error connecting to MySQL server.');
        $query = "SELECT * FROM users";
        $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($result)) {
          echo '<li>';
          echo $row['first_name'];
          echo ' ' . $row['last_name'];
          echo '</br>' . $row['email'];
          echo '</li>';
        }

        mysqli_close($dbc);
      ?>
    </ul>
  </section>

  <?php include 'includes/feet.php';?>