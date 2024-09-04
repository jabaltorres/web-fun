<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/classes/KrateUserManager.php');

use Fivetwofive\KrateCMS\KrateUserManager;

// Initialize the KrateUserManager with the existing $db connection
$userManager = new KrateUserManager($db);

// Ensure the user is logged in
$userManager->checkLoggedIn();

// Check if user is logged in and is an administrator
$loggedIn = isset($_SESSION['user_id']);
$isAdmin = $loggedIn && $userManager->isAdmin($_SESSION['user_id']);

// Fetch all users from the database if the user is an admin
$result = $isAdmin ? $userManager->getAllUsers() : null;

include('../../templates/layout/header.php');
?>

  <div class="container">

      <?php if ($loggedIn): ?>
        <ul class="nav mb-4">
          <li class="nav-item"><a class="nav-link" href="user-add.php">User Add</a></li>
          <li class="nav-item"><a class="nav-link" href="edit-profile.php">Edit Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
      <?php endif; ?>

    <h1>User List</h1>

    <section class="user-content">
        <?php if ($loggedIn): ?>
          <p class="mb-0">Welcome, <?= htmlspecialchars($_SESSION['first_name']); ?>! Here is the exclusive content for logged-in users.</p>
        <?php endif; ?>
    </section>

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
      <?php elseif ($loggedIn): ?>
        <p>You must be an administrator to view this page.</p>
      <?php endif; ?>
  </div>

<?php include('../../templates/layout/footer.php'); ?>