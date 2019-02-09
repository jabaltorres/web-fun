<?php
require_once('private/initialize.php');

$errors = [];
$username = '';
$password = '';


$title = "DB Test | Login";
// this is for <title>

$page_heading = "Log In";
// This is for breadcrumbs if I want a custom title other than the default

$page_subheading = "User authentication required";
// This is the subheading

$custom_class = "db-test-login";


if(is_post_request()) {

  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // Validations
  if(is_blank($username)) {
    $errors[] = "Username cannot be blank.";
  }
  if(is_blank($password)) {
    $errors[] = "Password cannot be blank.";
  }

  // if there were no errors, try to login
  if(empty($errors)) {
    // Using one variable ensures that msg is the same
    $login_failure_msg = "Log in was unsuccessful.";

    $admin = find_admin_by_username($username);
    if($admin) {

      if(password_verify($password, $admin['hashed_password'])) {
        // password matches
        log_in_admin($admin);
        redirect_to(url_for('/index.php'));
      } else {
        // username found, but password does not match
        $errors[] = $login_failure_msg;
      }

    } else {
      // no username found
      $errors[] = $login_failure_msg;
    }

  }

}

include_once(INCLUDES_PATH . '/site-header.php');

?>

<div class="container <?php echo $custom_class; ?>">
    <?php
    include_once(INCLUDES_PATH . '/masthead.php');
    include_once(INCLUDES_PATH . '/navigation.php');
    ?>

    <section>
        <?php include_once(INCLUDES_PATH . '/headline-page.php');?>
    </section>

    <div id="content">

      <?php echo display_errors($errors); ?>

      <form action="login.php" method="post">
        Username:<br />
        <input type="text" name="username" value="<?php echo h($username); ?>" /><br />
        Password:<br />
        <input type="password" name="password" value="" /><br />
        <input type="submit" name="submit" value="Submit" class="btn btn-primary" />
      </form>

    </div><!-- end .container -->
</div><!-- end .container -->
<?php include_once(INCLUDES_PATH . '/site-footer.php'); ?>
