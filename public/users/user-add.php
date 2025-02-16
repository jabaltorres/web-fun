<?php
declare(strict_types=1);

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../../config/bootstrap.php');

use Fivetwofive\KrateCMS\UserManager;

try {
    // Initialize the UserManager
    $userManager = $app['userManager'] = $userManager;

    // Generate CSRF token
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    // Check authorization
    $userManager->checkLoggedIn();
    if (!$userManager->isAdmin($_SESSION['user_id'])) {
        throw new Exception("You do not have permission to add new users.");
    }

    $success_message = '';
    $error_message = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new Exception("Invalid CSRF token.");
        }

        if ($userManager->registerUser([
            'first_name' => htmlspecialchars($_POST['first_name']),
            'last_name' => htmlspecialchars($_POST['last_name']),
            'email' => $_POST['email'],
            'username' => htmlspecialchars($_POST['username']),
            'password' => $_POST['password'],
            'confirm_password' => $_POST['confirm_password'],
            'role' => htmlspecialchars($_POST['role'])
        ])) {
            $success_message = "New user added successfully";
            $_POST = [];
        }
    }

} catch (Exception $e) {
    error_log("User add error: " . $e->getMessage());
    $error_message = $e->getMessage();
}

include('../../src/Views/templates/header.php');
?>

  <div class="container py-5">
    <h2>Add New User</h2>

      <?php if (!empty($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
      <?php endif; ?>

      <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
      <?php endif; ?>

      <?php if (empty($error_message) && empty($success_message)): ?>
        <section>
          <form action="user-add.php" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <fieldset class="mb-4">
              <legend>Personal Information</legend>
              <label for="first_name">First Name:</label>
              <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($_POST['first_name'] ?? '', ENT_QUOTES); ?>" required>
              <label for="last_name">Last Name:</label>
              <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($_POST['last_name'] ?? '', ENT_QUOTES); ?>" required>
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES); ?>" required>
            </fieldset>
            <fieldset class="mb-4">
              <legend>Account Details</legend>
              <label for="username">Username:</label>
              <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES); ?>" required>
              <label for="password">Password:</label>
              <input type="password" id="password" name="password" required>
              <label for="confirm_password">Confirm Password:</label>
              <input type="password" id="confirm_password" name="confirm_password" required>
            </fieldset>
            <fieldset class="mb-4">
              <legend>User Role</legend>
              <label for="role">Role:</label>
              <select id="role" name="role" class="form-control" required>
                <option value="Guest" <?php echo ($_POST['role'] ?? '') === 'Guest' ? 'selected' : ''; ?>>Guest</option>
                <option value="User" <?php echo ($_POST['role'] ?? '') === 'User' ? 'selected' : ''; ?>>User</option>
                <option value="Manager" <?php echo ($_POST['role'] ?? '') === 'Manager' ? 'selected' : ''; ?>>Manager</option>
                <option value="Administrator" <?php echo ($_POST['role'] ?? '') === 'Administrator' ? 'selected' : ''; ?>>Administrator</option>
              </select>
            </fieldset>
            <input type="submit" class="btn btn-primary" value="Add User">
          </form>
        </section>
      <?php endif; ?>
  </div>

<?php include('../../src/Views/templates/footer.php'); ?>