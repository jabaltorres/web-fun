<?php
    if(!isset($page_title)) {$page_title = 'Staff Area';}
?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <title>Web Fun - <?php echo h($page_title); ?></title>
        <meta charset="utf-8">
        <link href='http://fonts.googleapis.com/css?family=Gudea|Old+Standard+TT' rel='stylesheet' type='text/css'>

        <!-- Bootstrap 4 - Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/staff.css'); ?>">
    </head>

    <body>
        <div class="container">
            <header>
                <h1>Web Fun Staff Area</h1>
            </header>
            <nav>
                <ul>
                    <li><a href="<?php echo url_for('/staff/index-old.php'); ?>">Menu</a></li>
                </ul>
            </nav>