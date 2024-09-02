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

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle profile information update
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';

    if (!empty($first_name) && !empty($last_name) && !empty($email)) {
        // Update user details in the database
        $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE user_id = ?");
        $stmt->bind_param("sssi", $first_name, $last_name, $email, $user_id);
        if ($stmt->execute()) {
            $success = "Profile updated successfully!";
            // Refresh user details after update
            $userDetails = $userManager->getUserDetails($user_id);
        } else {
            $error = "An error occurred while updating your profile. Please try again.";
        }
    } else {
        $error = "All fields are required.";
    }

    // Handle password change
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (!empty($current_password) && !empty($new_password) && $new_password === $confirm_password) {
        if ($userManager->changePassword($user_id, $current_password, $new_password)) {
            $success = "Password updated successfully!";
        } else {
            $error = "Current password is incorrect. Please try again.";
        }
    } elseif (!empty($new_password)) {
        $error = "New passwords do not match.";
    }
}

include('../../templates/layout/header.php');
?>

<div class="container">
    <h1>Edit Profile</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form action="edit-profile.php" method="POST">
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($userDetails['first_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($userDetails['last_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($userDetails['email']); ?>" required>
        </div>

        <h3>Change Password</h3>
        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" class="form-control" id="current_password" name="current_password">
        </div>
        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password">
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm New Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>

<?php include('../../templates/layout/footer.php'); ?>
