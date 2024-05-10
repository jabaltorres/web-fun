<?php
if(!isset($page_title)) { $page_title = 'Users Area'; }
$url = $url ?? '';
$is_logged_in = isset($_SESSION['user_id']); // Check if user is logged in
?>

<!doctype html>
<html lang="en">
<head>
    <title>KrateCMS - <?php echo h($page_title); ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo $url; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo $url; ?>/css/staff.css">
</head>

<body class="users-area">

<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        <a class="navbar-brand" href="/public/">KrateCMS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/public/users/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/demos/">Demos</a>
                </li>
            </ul>
            <!-- Update navbar text to reflect user status -->
            <span class="navbar-text">
                <?php if ($is_logged_in): ?>
                    Welcome back, <?= htmlspecialchars($_SESSION['first_name']); ?>! <a href="/public/users/logout.php">Log Out</a>
                <?php else: ?>
                    Welcome Guest! Please <a href="/public/users/login.php">Log In</a> or <a href="/public/users/register.php">Register</a>.
                <?php endif; ?>
            </span>
        </div>
    </div>
</nav>

<?php echo display_session_message(); ?>