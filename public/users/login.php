<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/classes/KrateUserManager.php');

$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

use Fivetwofive\KrateCMS\KrateUserManager;
$user = new KrateUserManager($conn);

// Check if user is already logged in
if (isset($_SESSION['user_id'])) {
    $loggedInMessage = "You are already logged in.";
    // Optionally uncomment the lines below to redirect logged-in users
    // header("Location: index.php");
    // exit();
} else {
    $loggedInMessage = "Please log in.";
}

$error = ''; // Initialize error message
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['logout'])) {
        $user->logout(); // Call logout method from KrateUserManager
        header("Location: login.php"); // Redirect to login page
        exit();
    }

    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    $loginResult = $user->login($username, $password);
    if ($loginResult) {
        $_SESSION['user_id'] = $loginResult['user_id'];
        $_SESSION['username'] = $loginResult['username'];
        $_SESSION['first_name'] = $loginResult['first_name'];  // Store first name in session
        header("Location: index.php"); // Redirect to the main page
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}

$conn->close();

include('../../templates/layout/header.php');

?>

<div class="container">
    <h1>User Login</h1>

    <div class="alert alert-info" role="alert">
        <?= $loggedInMessage ?>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form method="post">
            <button type="submit" name="logout" value="Log Out" class="btn btn-primary">Log Out</button>
        </form>
        <a href="index.php" class="btn btn-secondary">Go to main page</a>
    <?php else: ?>
        <form method="post">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password">
          </div>
          <button type="submit" value="Login" class="btn btn-primary">Submit</button>
        </form>
    <?php endif; ?>

    <?php if (!empty($error)) {
        echo "<p>$error</p>";
    } ?>
</div>

<?php include('../../templates/layout/footer.php'); ?>