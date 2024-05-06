<?php
    $url = $url ?? '';
?>
<!doctype html>

<html lang="en">
<head>
    <title>Globe Bank <?php if (isset($page_title)) {
            echo '- ' . h($page_title);
        } ?><?php if (isset($preview) && $preview) {
            echo ' [PREVIEW]';
        } ?></title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo $url; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo $url; ?>/css/public.css">
</head>

<body>

    <header>
        <h1>
            <a href="<?php echo url_for('/index.php'); ?>">
                <img class="logo" src="<?php echo url_for('/images/gbi_logo.png'); ?>" alt="logo"/>
            </a>
        </h1>
    </header>
    <div class="webfun-link">
        <nav>
            <ul>
                <li>
                    <a href="/">Back to WebFun</a>
                </li>
                <li>
                    <a href="staff/">Staff Area</a>
                </li>
                <li>
                    <a href="staff/admins/">Admin Area</a>
                </li>
            </ul>
        </nav>
    </div>
