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

  <div class="container">

    <?php if ($isAdmin): ?>
        <?php include('../../templates/components/nav_admins.php'); ?>
    <?php endif; ?>

    <?php if ($loggedIn): ?>
      <?php include('../../templates/components/nav_users.php'); ?>
      <h1>Users Page</h1>
      <section class="user-content mb-4">
        <p class="mb-0">Welcome, <?= htmlspecialchars($_SESSION['first_name']); ?>! Here is the exclusive content for logged-in users.</p>
      </section>
    <?php endif; ?>

    <?php if ($isAdmin): ?>
        <?php if ($result && $result->num_rows > 0): ?>
        <section class="user-content">
          <h3>All Users</h3>
          <table class="table table-striped">
            <thead class="thead-dark">
            <tr>
              <th>ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Username</th>
              <th>Role</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['user_id']) ?></td>
                <td><?= htmlspecialchars($row['first_name']) ?></td>
                <td><?= htmlspecialchars($row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['role']) ?></td>
              </tr>
            <?php endwhile; ?>
            </tbody>
          </table>
        </section>
        <?php else: ?>
        <p>No users found.</p>
        <?php endif; ?>
    <?php endif; ?>
  </div>

<?php include('../../templates/layout/footer.php'); ?>