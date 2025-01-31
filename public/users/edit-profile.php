<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

use Fivetwofive\KrateCMS\UserManager;

try {
    // Initialize the UserManager
    $userManager = new UserManager($db);

    // Ensure the user is logged in
    $userManager->checkLoggedIn();

    // Fetch the logged-in user's details
    $user_id = $_SESSION['user_id'];
    $userDetails = $userManager->getUserDetails($user_id);

    $error = '';
    $success = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle password change
        if (!empty($_POST['new_password'])) {
            if ($_POST['new_password'] !== $_POST['confirm_password']) {
                throw new InvalidArgumentException("New passwords do not match.");
            }
            
            if (!$userManager->changePassword($user_id, $_POST['current_password'], $_POST['new_password'])) {
                throw new InvalidArgumentException("Current password is incorrect.");
            }
            
            $success = "Password updated successfully!";
        }

        // Handle profile update
        if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email'])) {
            if ($userManager->updateUserProfile($user_id, [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email']
            ])) {
                $success = empty($success) ? "Profile updated successfully!" : "Profile and password updated successfully!";
                $userDetails = $userManager->getUserDetails($user_id);
            }
        } else {
            throw new InvalidArgumentException("All profile fields are required.");
        }
    }

} catch (Exception $e) {
    error_log("Error in profile management: " . $e->getMessage());
    $error = $e->getMessage();
}

include('../../templates/layout/header.php');
?>

<div class="container py-5">
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
