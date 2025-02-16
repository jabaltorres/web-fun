<?php
/**
 * @var array<string, mixed> $userDetails
 * @var array<string> $validRoles
 * @var string $error
 * @var string $success
 * @var int $userId
 */

declare(strict_types=1);
?>

<div class="container py-5">
    <h1>Edit User</h1>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form action="edit.php?id=<?= $userId ?>" method="POST">
        <?php include(__DIR__ . '/partials/user-form-fields.php'); ?>

        <button type="button" class="btn btn-secondary mb-3" onclick="togglePasswordSection()">
            Change Password
        </button>

        <?php include(__DIR__ . '/partials/password-change-fields.php'); ?>

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