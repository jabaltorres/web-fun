<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/classes/KrateUserManager.php'); // Ensure this path is correct

use Fivetwofive\KrateCMS\KrateUserManager;

// Instantiate the KrateUserManager class
$userManager = new KrateUserManager($db);

// Ensure the user is logged in
$userManager->checkLoggedIn();

// Use isLoggedIn to check if the user is logged in for conditional content display
$loggedIn = $userManager->isLoggedIn();

// Check if the user is an administrator
$isAdmin = $userManager->isAdmin($_SESSION['user_id']);

// Fetch the logged-in user's details
$user_id = $_SESSION['user_id'];
$userDetails = $userManager->getUserDetails($user_id);

include('../../templates/layout/header.php');
?>

<div class="container">
    <?php if ($loggedIn): ?>
      <?php include('../../templates/components/nav_users.php'); ?>
    <?php endif; ?>
  <h1>My Profile</h1>

  <?php if ($userDetails): ?>
    <section class="user-profile border p-4 mb-5">
      <p><strong>Role:</strong> <?= htmlspecialchars($userDetails['role']); ?></p>
      <p><strong>First Name:</strong> <?= htmlspecialchars($userDetails['first_name']); ?></p>
      <p><strong>Last Name:</strong> <?= htmlspecialchars($userDetails['last_name']); ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($userDetails['email']); ?></p>
      <p><strong>Username:</strong> <?= htmlspecialchars($userDetails['username']); ?></p>

      <a href="edit-profile.php" class="btn btn-primary">Edit Profile</a>
    </section>
  <?php else: ?>
    <div class="alert alert-danger">User details could not be retrieved. Please try again later.</div>
  <?php endif; ?>
</div>

<?php include('../../templates/layout/footer.php'); ?>
