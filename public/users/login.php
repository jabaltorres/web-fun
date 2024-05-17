<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../private/initialize.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../private/classes/KrateUserManager.php');

$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

use FiveTwoFive\KrateCMS\UserManagement\KrateUserManager;
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

include(SHARED_PATH . '/users_header.php');
include(SHARED_PATH . '/navigation.php');

?>

<div class="container">
    <h1>User Login</h1>
    <p><?= $loggedInMessage ?></p>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form method="post">
            <input type="submit" name="logout" value="Log Out" class="btn btn-primary">
        </form>
        <a href="index.php">Go to main page</a>
    <?php else: ?>
        <form method="post">
            Username: <input type="text" name="username"><br>
            Password: <input type="password" name="password"><br>
            <input type="submit" value="Login" class="btn btn-primary">
        </form>
    <?php endif; ?>

    <?php if (!empty($error)) echo "<p>$error</p>"; ?>
</div>

<?php include(SHARED_PATH . '/site_footer.php'); ?>