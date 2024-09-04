<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/classes/KrateUserManager.php');

use Fivetwofive\KrateCMS\KrateUserManager;

// Initialize the KrateUserManager with the existing $db connection
$userManager = new KrateUserManager($db);

// Ensure the user is logged in
$userManager->checkLoggedIn();

$page_title = 'Staff Menu';
include('../../templates/layout/header.php');
?>

<div id="content" class="container">
    <div class="row">
        <div class="col-12">
            <div id="main-menu">
                <h2>Main Menu</h2>
                <ul>
                    <li><a href="<?php echo url_for('/staff/subjects/index.php'); ?>">Subjects</a></li>
                    <li><a href="<?php echo url_for('/staff/pages/index.php'); ?>">Pages</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include('../../templates/layout/footer.php'); ?>
