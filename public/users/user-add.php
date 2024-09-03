<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/classes/KrateUserManager.php');

use Fivetwofive\KrateCMS\KrateUserManager;

// Initialize the KrateUserManager
$userManager = new KrateUserManager($db);

// Generate CSRF token and store it in session if not already set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check if the user is logged in and has the correct role
$userManager->checkLoggedIn();

if (!$userManager->isAdmin($_SESSION['user_id'])) {
    $error_message = "You do not have permission to add new users.";
} else {
    $error_message = ""; // No error, user has permission
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($error_message)) {
    // Check CSRF token
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error_message = "Invalid CSRF token.";
    } else {
        $userData = [
            'first_name' => htmlspecialchars($_POST['first_name']),
            'last_name' => htmlspecialchars($_POST['last_name']),
            'email' => $_POST['email'],  // validation is handled in KrateUserManager
            'username' => htmlspecialchars($_POST['username']),
            'password' => $_POST['password'],
            'confirm_password' => $_POST['confirm_password'],
            'role' => htmlspecialchars($_POST['role']), // Ensure role is passed from form
        ];

        try {
            if ($userManager->registerUser($userData)) {
                $success_message = "New user added successfully";
                // Clear form data after successful submission
                $_POST = [];
            }
        } catch (Exception $e) {
            $error_message = $e->getMessage();
        }
    }
}

include('../../templates/layout/header.php');
?>

  <div class="container">
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
                <option value="Administrator" <?php echo ($_POST['role'] ?? '') === 'Administrator' ? 'selected' : ''; ?>>Administrator</option>
                <option value="Manager" <?php echo ($_POST['role'] ?? '') === 'Manager' ? 'selected' : ''; ?>>Manager</option>
                <option value="Standard User" <?php echo ($_POST['role'] ?? '') === 'Standard User' ? 'selected' : ''; ?>>Standard User</option>
                <option value="Guest" <?php echo ($_POST['role'] ?? '') === 'Guest' ? 'selected' : ''; ?>>Guest</option>
              </select>
            </fieldset>
            <input type="submit" class="btn btn-primary" value="Add User">
          </form>
        </section>
      <?php endif; ?>
  </div>

<?php include('../../templates/layout/footer.php'); ?>