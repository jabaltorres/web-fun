<?php

require_once('../../private/initialize.php');

require_login();

if(is_post_request()) {
  $subject = [];
  $admin['first_name'] = $_POST['first_name'] ?? '';
  $admin['last_name'] = $_POST['last_name'] ?? '';
  $admin['email'] = $_POST['email'] ?? '';
  $admin['username'] = $_POST['username'] ?? '';
  $admin['password'] = $_POST['password'] ?? '';
  $admin['confirm_password'] = $_POST['confirm_password'] ?? '';

  $result = insert_admin($admin);
  if($result === true) {
    $new_id = mysqli_insert_id($db);
    $_SESSION['message'] = 'Admin created.';
    redirect_to(url_for('/staff/admins/show.php?id=' . $new_id));
  } else {
    $errors = $result;
  }

} else {
  // display the blank form
  $admin = [];
  $admin["first_name"] = '';
  $admin["last_name"] = '';
  $admin["email"] = '';
  $admin["username"] = '';
  $admin['password'] = '';
  $admin['confirm_password'] = '';
}

$title = "DB Test Page";
// this is for <title>

$page_heading = "This is the DB Test page";
// This is for breadcrumbs if I want a custom title other than the default

$page_subheading = "Welcome to the DB test page";
// This is the subheading

$custom_class = "db-test-page";
//custom CSS for this page only

$contact_set = find_all_contacts();
// From globe_bank tutorial

include_once(INCLUDES_PATH . '/site-header.php');

?>

<div class="container <?php echo $custom_class; ?>">
    <?php
    include_once(INCLUDES_PATH . '/masthead.php');
    include_once(INCLUDES_PATH . '/navigation.php');
    ?>

    <section>
        <?php include_once(INCLUDES_PATH . '/headline-page.php');?>
        <?php include_once(INCLUDES_PATH . '/db-menu.php');?>
    </section>


    <div id="content">

        <a class="btn btn-outline-info mb-4 font-weight-bold" href="<?php echo url_for('/contacts/index.php'); ?>">&laquo; Back to List</a>

      <div class="admin new">
        <h1>Create Admin</h1>

        <?php echo display_errors($errors); ?>

        <form action="<?php echo url_for('/new.php'); ?>" method="post">
          <dl>
            <dt>First name</dt>
            <dd><input type="text" name="first_name" value="<?php echo h($admin['first_name']); ?>" /></dd>
          </dl>

          <dl>
            <dt>Last name</dt>
            <dd><input type="text" name="last_name" value="<?php echo h($admin['last_name']); ?>" /></dd>
          </dl>

          <dl>
            <dt>Username</dt>
            <dd><input type="text" name="username" value="<?php echo h($admin['username']); ?>" /></dd>
          </dl>

          <dl>
            <dt>Email </dt>
            <dd><input type="text" name="email" value="<?php echo h($admin['email']); ?>" /><br /></dd>
          </dl>

          <dl>
            <dt>Password</dt>
            <dd><input type="password" name="password" value="" /></dd>
          </dl>

          <dl>
            <dt>Confirm Password</dt>
            <dd><input type="password" name="confirm_password" value="" /></dd>
          </dl>
          <p>
            Passwords should be at least 12 characters and include at least one uppercase letter, lowercase letter, number, and symbol.
          </p>
          <br />

          <div id="operations">
            <input type="submit" value="Create Admin" />
          </div>
        </form>

      </div>

    </div>

</div><!-- end .container -->
<?php include '../includes/site-footer.php';?>