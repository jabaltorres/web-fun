<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/classes/KrateUserManager.php');

use Fivetwofive\KrateCMS\KrateUserManager;

// Initialize the KrateUserManager with the existing $db connection
$userManager = new KrateUserManager($db);

// Enforce the user is logged in (will redirect if not)
$userManager->checkLoggedIn();

// Use isLoggedIn to check if the user is logged in for conditional content display
$loggedIn = $userManager->isLoggedIn();

// Check if the user is an administrator
$isAdmin = $userManager->isAdmin($_SESSION['user_id']);

// Fetch all users from the database if the user is an admin
$result = $isAdmin ? $userManager->getAllUsers() : null;

include('../../templates/layout/header.php');
?>

    <div class="container py-5">

        <?php if ($loggedIn): ?>
            <h1>Krate Logged In</h1>
            <section class="user-content mb-4">
                <p class="mb-0">Welcome, <?= htmlspecialchars($_SESSION['first_name']); ?>! Here is the exclusive content for logged-in users.</p>
            </section>
        <?php endif; ?>


        <?php if ($isAdmin): ?>
            <?php if ($result && $result->num_rows > 0): ?>
                <section class="user-content">
                    <h3>Site Settings:</h3>
                    <?php
                        echo 'Site Owner: ' . $site_owner . '</br>';
                        echo 'Site Name: ' . $site_name . '</br>';
                        echo 'Site Tagline: ' . $site_tagline . '</br>';
                        echo 'Site Description: ' . $site_description . '</br>';
                        echo 'Site Author: ' . $site_author . '</br>';
                        echo 'Site Keywords: ' . $site_keywords . '</br>';
                    ?>
                </section>
            <?php endif; ?>
        <?php endif; ?>
    </div>

<?php include('../../templates/layout/footer.php'); ?>