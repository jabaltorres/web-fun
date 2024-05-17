<?php
// Require initialization file
require_once($_SERVER['DOCUMENT_ROOT'] . '/../private/initialize.php');

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
                redirect_to(url_for('/contacts/index.php'));
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

include_once(SHARED_PATH . '/site_header.php');
include_once(SHARED_PATH . '/navigation.php');
?>

<div class="container <?php echo $custom_class; ?>">
    <section>
        <?php include_once(SHARED_PATH . '/headline-page.php'); ?>
    </section>

    <section id="content">

        <?php echo display_errors($errors); ?>

        <form action="login.php" method="post">
            <label for="userName">Username:</label>
            <input id="userName" class="form-control" type="text" name="username" value="<?php echo h($username); ?>"/>

            <label for="passWord">Password:</label>
            <input id="passWord" class="form-control" type="password" name="password" value=""/>

            <input type="submit" name="submit" value="Submit" class="btn btn-primary"/>
        </form>

    </section><!-- end #content -->
</div><!-- end .container -->
<?php include_once(SHARED_PATH . '/site-footer.php'); ?>
