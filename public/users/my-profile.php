<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

use Fivetwofive\KrateCMS\KrateUserManager;

try {
    // Initialize the KrateUserManager
    $userManager = new KrateUserManager($db);

    // Ensure the user is logged in
    $userManager->checkLoggedIn();

    // Fetch user details
    $userDetails = $userManager->getUserDetails($_SESSION['user_id']);
    
    if (!$userDetails) {
        throw new Exception("Unable to retrieve user details");
    }

} catch (Exception $e) {
    error_log("Profile error: " . $e->getMessage());
    $error = "An error occurred while loading your profile.";
}

include('../../templates/layouts/header.php');
?>

<div class="container py-5">
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
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>
</div>

<?php include('../../templates/layouts/footer.php'); ?>
