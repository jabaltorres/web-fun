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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" media="all" href="<?php echo url_for('/stylesheets/staff.css'); ?>">
    </head>

    <body>
        <div class="container">
            <header>
                <h1>Web Fun Staff Area</h1>
            </header>
            <nav>
                <ul>
                    <li><a href="<?php echo url_for('/staff/index.php'); ?>">Menu</a></li>
                </ul>
            </nav>