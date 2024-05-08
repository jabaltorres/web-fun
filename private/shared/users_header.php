<?php
    if(!isset($page_title)) { $page_title = 'Users Area'; }
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

  <body class="users-area">

    <div class="container">
        <header>
          <h1>Users Area</h1>
        </header>
    </div>

    <?php echo display_session_message(); ?>
