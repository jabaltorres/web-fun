<?php include 'includes/head.php';?>
<div class="container">
  <?php include 'includes/masthead.php';?>
  <?php include 'includes/navigation.php';?>
  <?php include 'includes/email-db-nav.php';?>
  
  <section>
    <ul class="email-db-list">
      <?php
        $dbc = mysqli_connect('localhost', 'root', 'root', 'email_db')
          or die('Error connecting to MySQL server.');
        $query = "SELECT * FROM email_list";
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