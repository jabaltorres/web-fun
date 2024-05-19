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
    <link rel="stylesheet" href="<?php echo STYLES_PATH; ?>/style.css">
    <link rel="stylesheet" href="<?php echo STYLES_PATH; ?>/staff.css">
</head>

<body class="users-area">

<?php echo display_session_message(); ?>
