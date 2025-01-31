<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

use Fivetwofive\KrateCMS\UserManager;

try {
    // Initialize the UserManager
    $userManager = new UserManager($db);

    // Ensure the user is logged in and is an admin
    $userManager->checkLoggedIn();
    if (!$userManager->isAdmin($_SESSION['user_id'])) {
        throw new Exception("You do not have permission to edit users.");
    }

    // Get the user ID from the URL
    $edit_user_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$edit_user_id) {
        throw new Exception("Invalid user ID.");
    }

    // Get the user details
    $userDetails = $userManager->getUserDetails($edit_user_id);
    if (!$userDetails) {
        throw new Exception("User not found.");
    }

    $error = '';
    $success = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Handle profile update
        if (!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['email'])) {
            if ($userManager->updateUserProfile($edit_user_id, [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'role' => $_POST['role']  // Add role update
            ])) {
                $success = "User profile updated successfully!";
                $userDetails = $userManager->getUserDetails($edit_user_id);
            }
        } else {
            throw new InvalidArgumentException("All fields are required.");
        }

        // Handle password change if requested
        if (!empty($_POST['new_password'])) {
            if ($_POST['new_password'] !== $_POST['confirm_password']) {
                throw new InvalidArgumentException("New passwords do not match.");
            }
            
            // Add method to change password without requiring current password
            if ($userManager->adminChangeUserPassword($edit_user_id, $_POST['new_password'])) {
                $success = empty($success) ? 
                    "Password updated successfully!" : 
                    "Profile and password updated successfully!";
            }
        }
    }

} catch (Exception $e) {
    error_log("Error in user edit: " . $e->getMessage());
    $error = $e->getMessage();
}

include('../../templates/layout/header.php');
?>

<div class="container py-5">
    <h1>Edit User</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form action="edit-user.php?id=<?= $edit_user_id ?>" method="POST">
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" 
                   value="<?= htmlspecialchars($userDetails['first_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" 
                   value="<?= htmlspecialchars($userDetails['last_name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="<?= htmlspecialchars($userDetails['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <select class="form-control" id="role" name="role" required>
                <?php foreach ($userManager::VALID_ROLES as $role): ?>
                    <?php 
                        $isSelected = trim($userDetails['role']) === trim($role);
                    ?>
                    <option value="<?= htmlspecialchars($role) ?>" 
                            <?= $isSelected ? 'selected' : '' ?>>
                        <?= htmlspecialchars($role) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="button" class="btn btn-secondary mb-3" onclick="togglePasswordSection()">
            Change Password
        </button>

        <div id="passwordSection" style="display: none;">
            <h3>Change Password</h3>
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="index.php" class="btn btn-secondary">Back to Users</a>
        </div>
    </form>
</div>

<script>
function togglePasswordSection() {
    const passwordSection = document.getElementById('passwordSection');
    if (passwordSection.style.display === 'none') {
        passwordSection.style.display = 'block';
    } else {
        passwordSection.style.display = 'none';
    }
}
</script>

<?php include('../../templates/layout/footer.php'); ?> 