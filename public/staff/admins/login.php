<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

$errors = [];
$username = '';
$password = '';

if (is_post_request()) {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validations
    if (is_blank($username)) {
        $errors[] = "Username cannot be blank.";
    }
    if (is_blank($password)) {
        $errors[] = "Password cannot be blank.";
    }

    // if there were no errors, try to login
    if (empty($errors)) {
        // Using one variable ensures that msg is the same
        $login_failure_msg = "Log in was unsuccessful.";

        $admin = find_admin_by_username($username);
        if ($admin) {

            if (password_verify($password, $admin['hashed_password'])) {
                // password matches
                log_in_admin($admin);
                redirect_to(url_for('/staff/admins/index.php'));
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


// this is for <title>
$title = "DB Test | Login";

// This is for breadcrumbs if I want a custom title other than the default
$page_heading = "Log In";

// This is the subheading
$page_subheading = "User authentication required";

$custom_class = "db-test-login";

include('../../../templates/layouts/header.php');
?>

<div class="container py-5 <?php echo $custom_class; ?>">
    <section>
        <?php include('../../../templates/components/headline.php'); ?>
    </section>

    <section id="content">

        <?php echo display_errors($errors); ?>

        <form action="login.php" method="post">
          <div class="form-group">
            <label for="userName">Username:</label>
            <input id="userName" class="form-control" type="text" name="username" value="<?php echo h($username); ?>"/>
          </div>
          <div class="form-group">
            <label for="passWord">Password:</label>
            <input id="passWord" class="form-control" type="password" name="password" value=""/>
          </div>
          <button type="submit" name="submit" value="Submit" class="btn btn-primary"/>Submit</button>
        </form>

    </section><!-- end #content -->
</div><!-- end .container -->
<?php include('../../../templates/layouts/footer.php'); ?>
