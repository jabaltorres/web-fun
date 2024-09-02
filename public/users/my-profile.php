<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/classes/KrateUserManager.php'); // Ensure this path is correct

use Fivetwofive\KrateCMS\KrateUserManager;

// Create database connection
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Instantiate the KrateUserManager class
$userManager = new KrateUserManager($conn);

// Ensure the user is logged in
$userManager->checkLoggedIn();

// Fetch the logged-in user's details
$user_id = $_SESSION['user_id'];
$userDetails = $userManager->getUserDetails($user_id);

include('../../templates/layout/header.php');
?>

<div class="container">
    <h1>My Profile</h1>

    <?php if ($userDetails): ?>
        <section class="user-profile border">
            <p><strong>First Name:</strong> <?= htmlspecialchars($userDetails['first_name']); ?></p>
            <p><strong>Last Name:</strong> <?= htmlspecialchars($userDetails['last_name']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($userDetails['email']); ?></p>
            <p><strong>Username:</strong> <?= htmlspecialchars($userDetails['username']); ?></p>

            <a href="edit-profile.php" class="btn btn-primary">Edit Profile</a>
        </section>
    <?php else: ?>
        <p>User details could not be retrieved. Please try again later.</p>
    <?php endif; ?>
</div>

<?php include('../../templates/layout/footer.php'); ?>
