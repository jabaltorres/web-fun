<?php
    if(!isset($page_title)) { $page_title = 'Staff Area'; }
    $url = $url ?? '';
?>

<!doctype html>

<html lang="en">
  <head>
    <title>KrateCMS - <?php echo h($page_title); ?></title>
    <meta charset="utf-8">
      <link rel="stylesheet" href="<?php echo $url; ?>/css/style.css">
      <link rel="stylesheet" href="<?php echo $url; ?>/css/staff.css">
  </head>

  <body class="staff-area">

    <div class="container">
        <header>
          <h1>GBI Staff Area</h1>
        </header>

        <navigation>
          <ul>
            <li>User: <?php echo $_SESSION['username'] ?? ''; ?></li>
            <li><a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>
            <li><a href="/">WebFun</a></li>
            <li><a href="<?php echo url_for('/staff/logout.php'); ?>">Logout</a></li>
          </ul>
        </navigation>
    </div>

    <?php echo display_session_message(); ?>
