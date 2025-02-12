<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

$errors = [];
$username = '';
$password = '';

if (is_post_request()) {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $_SESSION['username'] = $username;

    redirect_to(url_for('/staff/index.php'));
}

?>

<?php $page_title = 'Log in'; ?>
<?php include('../../templates/layouts/header.php'); ?>

<div id="content" class="container">
    <div class="row">
        <div class="col-12">
            <h1>Log in</h1>

            <?php echo display_errors($errors); ?>

            <form action="login.php" method="post">
                Username:<br/>
                <input type="text" name="username" value="<?php echo h($username); ?>"/><br/>
                Password:<br/>
                <input type="password" name="password" value=""/><br/>
                <input type="submit" name="submit" value="Submit"/>
            </form>
        </div>
    </div>
</div>

<?php include('../../templates/layouts/footer.php'); ?>
