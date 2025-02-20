<?php
declare(strict_types=1);

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../config/bootstrap.php');

use Fivetwofive\KrateCMS\UserManager;

try {
    // Initialize the UserManager with the existing $db connection
    $userManager = $app['userManager'];

    // Use isLoggedIn to check if the user is logged in for conditional content display
    $loggedIn = $userManager->isLoggedIn();

} catch (Exception $e) {
    error_log("Contact page error: " . $e->getMessage());
    $error = "An error occurred while loading the page.";
}

include(ROOT_PATH . '/src/Views/templates/header.php');
?>

    <div id="main" class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <?php include(ROOT_PATH . '/src/Views/templates/nav_public.php'); ?>
                </div>
                <div class="col-md-9 ">
                    <div class="page-content">
                        <?php include('../templates/pages/static_contactus.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include(ROOT_PATH . '/src/Views/templates/footer.php'); ?>