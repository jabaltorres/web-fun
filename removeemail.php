<?php include 'includes/head.php';?>
<div class="container">
  <?php include 'includes/masthead.php';?>
  <?php include 'includes/navigation.php';?>
  <?php include 'includes/email-db-nav.php';?>
  
  <section>
    <h2>Remove Email</h2>
    <p>Please select the email addresses to delete from the email list and click Remove.</p>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

        <?php
          $dbc = mysqli_connect('localhost', 'root', 'root', 'email_db')
            or die('Error connecting to MySQL server.');

          // Delete the customer rows (only if the form has been submitted)
          if (isset($_POST['submit'])) {
            foreach ($_POST['todelete'] as $delete_id) {
              $query = "DELETE FROM email_list WHERE id = $delete_id";
              mysqli_query($dbc, $query)
                or die('Error querying database.');
            } 

            echo 'Customer(s) removed.<br />';
          }

          // Display the customer rows with checkboxes for deleting
          $query = "SELECT * FROM email_list";
          $result = mysqli_query($dbc, $query);
          while ($row = mysqli_fetch_array($result)) {
            echo '<input type="checkbox" value="' . $row['id'] . '" name="todelete[]" />';
            echo $row['first_name'];
            echo ' ' . $row['last_name'];
            echo ' ' . $row['email'];
            echo '<br />';
          }

          mysqli_close($dbc);
        ?>

        <input type="submit" name="submit" value="Remove" />
      </form>
  </section>

<?php include 'includes/feet.php';?>