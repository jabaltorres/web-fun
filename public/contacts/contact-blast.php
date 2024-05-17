<?php
require_once('../../private/initialize.php');

require_login();

$title = "DB Test Page";
// this is for <title>

$page_heading = "This is the DB Test page";
// This is for breadcrumbs if I want a custom title other than the default

$page_subheading = "Welcome to the DB test page";
// This is the subheading

$custom_class = "db-test-page";
//custom CSS for this page only
include_once(SHARED_PATH . '/site-header.php');
include_once(INCLUDES_PATH . '/navigation.php');
?>
    <div class="container <?php echo $custom_class; ?>">

  <section>
    <h2 class="h3"><span class="font-weight-bold">Private:</span> For Test use ONLY</h2>
    <p>Write and send an email to contact list members.</p>

      <a class="btn btn-outline-info mb-4 font-weight-bold" href="<?php echo url_for('/contacts/index.php'); ?>">&laquo; Back to List</a>

    <?php

      if (isset($_POST['submit'])) {
        $from = 'jabaltorre@gmail.com';
        $subject = $_POST['subject'];
        $text = $_POST['emailtext'];
        $output_form = false;

        if (empty($subject) && empty($text)) {
          // We know both $subject AND $text are blank
          echo '<div class="border border-warning p-4 mb-4">You forgot the email subject and body text.</div>';
          $output_form = true;
        }

        if (empty($subject) && (!empty($text))) {
            echo '<div class="border border-warning p-4 mb-4">You forgot the email subject.</div>';
          $output_form = true;
        }

        if ( (!empty($subject)) && empty($text) ) {
            echo '<div class="border border-warning p-4 mb-4">You forgot the email body text.</div>';
          $output_form = true;
        }

      } else {
        $output_form = true;
        $subject = '';
        $text = '';
      }

      if ( (!empty($subject)) && (!empty($text)) ) {
        $dbc = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME)
          or die('Error connecting to MySQL server.');

        $query = "SELECT * FROM contact_list";
        $result = mysqli_query($dbc, $query)
          or die('Error querying database.');

        while ($row = mysqli_fetch_array($result)){
          $to = $row['email'];
          $first_name = $row['first_name'];
          $last_name = $row['last_name'];
          $msg = "Dear $first_name $last_name,\n$text";
          mail($to, $subject, $msg, 'From:' . $from);
          echo 'Email sent to: ' . $to . '<br />';
        }

        mysqli_close($dbc);
      }
    ?>

    <?php if ($output_form): ?>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="subject">Subject of email:</label>
            <input id="subject" name="subject" type="text" value="<?php echo $subject; ?>" size="30" />
            <label for="emailtext">Body of email:</label>
            <textarea id="email-text" name="emailtext" rows="8" cols="40"><?php echo $text; ?></textarea>
            <input class="btn btn-primary" type="submit" name="submit" value="Submit" />
        </form>
    <?php endif; ?>

  </section>
</div>

<?php include_once(SHARED_PATH . '/site-footer.php'); ?>