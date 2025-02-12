<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

use Fivetwofive\KrateCMS\UserManager;

try {
    // Initialize the UserManager with the existing $db connection
    $userManager = new UserManager($db);

    // Ensure the user is logged in
    $userManager->checkLoggedIn();

    $page_title = 'Staff Menu';
    include('../../templates/layouts/header.php');
} catch (Exception $e) {
    error_log("Staff page error: " . $e->getMessage());
    header("Location: /users/login.php");
    exit;
}
?>

<div id="content" class="container py-5">
    <div class="row">
        <div class="col-12">
            <div id="main-menu">
                <h2>Main Menu</h2>
                <ul>
                  <li><a href="<?php echo url_for('/staff/pages/index.php'); ?>">Pages</a></li>
                  <li><a href="<?php echo url_for('/staff/subjects/index.php'); ?>">Subjects</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include('../../templates/layouts/footer.php'); ?>
