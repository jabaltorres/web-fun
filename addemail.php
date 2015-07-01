<?php include 'includes/head.php';?>
<div class="container">
  <?php include 'includes/masthead.php';?>
  <?php include 'includes/navigation.php';?>
  <?php include 'includes/email-db-nav.php';?>
  <section>
    <?php
      if (isset($_POST['submit'])) {
        $first_name = $_POST['firstname'];
        $last_name = $_POST['lastname'];
        $email = $_POST['email'];
        $output_form = 'no';

        if (empty($first_name) || empty($last_name) || empty($email)) {
          // We know at least one of the input fields is blank 
          echo 'Please fill out all of the email information.<br />';
          $output_form = 'yes';
        }
      }
      else {
        $output_form = 'yes';
      }

      if (!empty($first_name) && !empty($last_name) && !empty($email)) {
        $dbc = mysqli_connect('localhost', 'root', 'root', 'email_db')
          or die('Error connecting to MySQL server.');

        $query = "INSERT INTO email_list (first_name, last_name, email)  VALUES ('$first_name', '$last_name', '$email')";
        mysqli_query($dbc, $query)
          or die ('Data not inserted.');

        echo 'Customer added. </br>';
        echo '<a href="db-test.php">Home</a>';

        mysqli_close($dbc);
      }

      if ($output_form == 'yes') {
    ?>

      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="firstname">First name:</label>
        <input type="text" id="firstname" name="firstname" /><br />
        <label for="lastname">Last name:</label>
        <input type="text" id="lastname" name="lastname" /><br />
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" /><br />
        <input type="submit" name="submit" value="Submit" />
      </form>

    <?php
      }
    ?>    
  </section>

<?php include 'includes/feet.php';?>