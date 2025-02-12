<?php
// Require initialization file
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

use Fivetwofive\KrateCMS\UserManager;

try {
    // Initialize the UserManager with the existing $db connection
    $userManager = new UserManager($db);

    // Use isLoggedIn to check if the user is logged in for conditional content display
    $loggedIn = $userManager->isLoggedIn();

} catch (Exception $e) {
    error_log("Contact page error: " . $e->getMessage());
    $error = "An error occurred while loading the page.";
}

include('../templates/layouts/header.php');
?>

    <div id="main" class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <?php include('../templates/components/nav_public.php'); ?>
                </div>
                <div class="col-md-9 ">
                    <div class="page-content">
                        <?php include('../templates/pages/static_contactus.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('../templates/layouts/footer.php'); ?>