<?php
// Require initialization file
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/classes/KrateUserManager.php');

use Fivetwofive\KrateCMS\KrateUserManager;

// Initialize the KrateUserManager with the existing $db connection
$userManager = new KrateUserManager($db);

// Use isLoggedIn to check if the user is logged in for conditional content display
$loggedIn = $userManager->isLoggedIn();

?>

<?php include('../templates/layout/header.php'); ?>

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

<?php include('../templates/layout/footer.php'); ?>