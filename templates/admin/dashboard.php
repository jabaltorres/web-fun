<?php
// Ensure this file isn't accessed directly
if (!defined('PRIVATE_PATH')) {
    exit('Direct access not permitted');
}

// Verify CSRF token if handling form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add CSRF verification here
}
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Admin Dashboard</h1>
            
            <?php if ($loggedIn): ?>
                <section class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title h4">Welcome</h2>
                        <p class="card-text">
                            Hello, <?= htmlspecialchars($_SESSION['first_name'] ?? 'Administrator') ?>!
                        </p>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ($isAdmin && $users && $users->num_rows > 0): ?>
                <section class="card mb-4">
                    <ul class="nav justify-content-center">
                        <li class="nav-item"><a class="nav-link" href="/staff/admins/">Admins</a></li>
                        <li class="nav-item"><a class="nav-link" href="/staff/admins/new.php">Create New Admin</a></li>
                        <li class="nav-item"><a class="nav-link" href="/users/">Users</a></li>
                        <li class="nav-item"><a class="nav-link" href="/users/user-add.php">User Add</a></li>
                        <li class="nav-item"><a class="nav-link" href="/staff/index.php">Staff</a></li>
                        <li class="nav-item"><a class="nav-link" href="/staff/pages/index.php">Pages</a></li>
                        <li class="nav-item"><a class="nav-link" href="/staff/subjects/index.php">Subjects</a></li>
                        <li class="nav-item"><a class="nav-link" href="/contacts/index.php">Contacts</a></li>
                        <li class="nav-item"><a class="nav-link" href="/demos/index.php">Demos</a></li>
                    </ul>
                </section>
                
                <section class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title h4">Site Settings</h2>
                        <dl class="row">
                            <dt class="col-sm-3">Site Owner</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($config['site']['owner']) ?></dd>
                            
                            <dt class="col-sm-3">Site Name</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($config['site']['name']) ?></dd>
                            
                            <dt class="col-sm-3">Site Tagline</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($config['site']['tagline']) ?></dd>
                            
                            <dt class="col-sm-3">Site Description</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($config['site']['description']) ?></dd>
                            
                            <dt class="col-sm-3">Site Author</dt>
                            <dd class="col-sm-9"><?= htmlspecialchars($config['site']['author']) ?></dd>
                        </dl>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </div>
</div> 