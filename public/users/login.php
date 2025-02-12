<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

use Fivetwofive\KrateCMS\UserManager;

try {
    // Initialize the KrateUserManager
    $userManager = new UserManager($db);

    // Check if user is already logged in
    $userIsLoggedIn = $userManager->isLoggedIn();
    $loggedInMessage = $userIsLoggedIn ? "You are already logged in." : "Please log in.";
    $error = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['logout'])) {
            $userManager->logout();
            header("Location: login.php");
            exit();
        }

        // Handle login process
        $loginResult = $userManager->login(
            htmlspecialchars($_POST['username']),
            $_POST['password']
        );

        if ($loginResult) {
            // Store session data
            $_SESSION['user_id'] = $loginResult['user_id'];
            $_SESSION['username'] = $loginResult['username'];
            $_SESSION['first_name'] = $loginResult['first_name'];
            $_SESSION['role'] = $loginResult['role'];

            header("Location: /index.php");
            exit();
        }
        
        $error = "Invalid username or password!";
    }

} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    $error = "An error occurred during login. Please try again.";
}

include('../../templates/layouts/header.php');
?>

  <div class="container py-5">
    <h1>User Login</h1>

        <?php if ($loggedInMessage): ?>
            <div class="alert alert-info" role="alert">
                <?= $loggedInMessage ?>
            </div>
        <?php endif; ?>

      <?php if ($userIsLoggedIn): ?>
        <form method="post">
          <button type="submit" name="logout" value="Log Out" class="btn btn-primary">Log Out</button>
        </form>
        <a href="index.php" class="btn btn-secondary">Go to main page</a>
      <?php else: ?>
      <div class="login-form border p-4">
        <form method="post">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" required>
          </div>
          <button type="submit" value="Login" class="btn btn-primary">Submit</button>
        </form>
      </div>
      <?php endif; ?>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger mt-2"><?= $error ?></div>
      <?php endif; ?>
  </div>

<?php include('../../templates/layouts/footer.php'); ?>