<?php
/**
 * @var bool $loggedIn
 * @var bool $isAdmin
 * @var ?mysqli_result $users
 * @var string $search
 * @var string $roleFilter
 * @var string $sortField
 * @var string $sortOrder
 * @var array<string> $validRoles
 * @var UserController $userController
 */

declare(strict_types=1);

use Fivetwofive\KrateCMS\Controllers\UserController;
?>

<div class="container py-5">
    <?php if ($loggedIn): ?>
        <h1>Users Page</h1>
        <section class="user-content mb-4">
            <p class="mb-0">Welcome, <?= htmlspecialchars($_SESSION['first_name']); ?>! Here is the exclusive content for logged-in users.</p>
        </section>

        <section class="mb-4">
            User ID: <?php echo $_SESSION['user_id'] . '</br>'; ?>
            Username: <?php echo $_SESSION['username'] . '</br>'; ?>
            Role: <?php echo $_SESSION['role'] ?? 'No role'; ?><br>
        </section>
    <?php endif; ?>

    <?php if ($isAdmin): ?>
        <?php include(__DIR__ . '/partials/search-filter-form.php'); ?>

        <?php if ($users && $users->num_rows > 0): ?>
            <section class="user-content">
                <?php include(__DIR__ . '/partials/users-table.php'); ?>
            </section>
        <?php else: ?>
            <p>No users found.</p>
        <?php endif; ?>
    <?php endif; ?>
</div> 