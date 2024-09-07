<?php
if (!isset($page_title)) {
    $page_title = 'Users Area';
}
$url = $url ?? '';
$is_logged_in = isset($_SESSION['user_id']);

$adminLoggedIn = admin_is_logged_in();
if ($adminLoggedIn) {
    $adminMessage = "admin is logged in";
} else {
    $adminMessage = "admin is not logged in";
}

?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>KrateCMS
      <?php if (isset($page_title)) {
          echo '- ' . h($page_title);
      } ?><?php if (isset($preview) && $preview) {
          echo ' [PREVIEW]';
      } ?>
  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo STYLES_PATH; ?>/style.css">
  <link rel="stylesheet" href="<?php echo STYLES_PATH; ?>/public.css">
  <link rel="stylesheet" href="<?php echo STYLES_PATH; ?>/simple.css">

  <!-- TinyMCE -->
  <script src="https://cdn.tiny.cloud/1/9b6vdo6p51qb89toe164crjl7qyvmjbnp3qyv43i0d4wp3mw/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
</head>

<body>

<?php
if ($adminLoggedIn) {
    include($_SERVER['DOCUMENT_ROOT'] . '/../templates/components/nav_admins.php');
}
?>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="/">KrateCMS</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <?php include($_SERVER['DOCUMENT_ROOT'] . '/../templates/components/nav_main.php'); ?>

      <!-- Update navbar text to reflect user status -->
      <span class="navbar-text">
        <?php if ($is_logged_in): ?>
          Welcome back, <a href="/users/my-profile.php"><?= htmlspecialchars($_SESSION['first_name']); ?></a>! <a href="/users/logout.php">Log Out</a>
        <?php else: ?>
          Welcome Guest! Please <a href="/users/login.php">Log In</a> or <a href="/public/users/register.php">Register</a>.
        <?php endif; ?>
        </span>
    </div>
  </div>
</nav>

<?php echo display_session_message(); ?>
