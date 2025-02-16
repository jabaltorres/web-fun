<?php
// Access services from the bootstrap
global $settingsManager, $sessionHelper, $userManager, $htmlHelper, $urlHelper;

$siteName = $settingsManager->getSetting('site_name') ?? 'KrateCMS';
$isLoggedIn = $sessionHelper->isLoggedIn();
$isAdmin = $userManager->isAdmin($sessionHelper->getCurrentUserId() ?? 0);
$isDarkMode = $settingsManager->getSetting('dark_mode', false);

// Get logo and site info from config
$logoUrl = $config['site']['logo_url'] ?? '';
$siteDisplayName = $config['site']['name'] ?? $siteName;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9KJN3YRHDT"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-9KJN3YRHDT');
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $htmlHelper->escape($siteName) ?></title>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= $urlHelper->urlFor('/assets/css/style.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= STYLES_PATH ?>/public.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/9b6vdo6p51qb89toe164crjl7qyvmjbnp3qyv43i0d4wp3mw/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body class="<?= $isDarkMode ? 'dark-mode' : '' ?>">
    <header class="">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="<?= $urlHelper->urlFor('/index.php') ?>">
                    <?php if (!empty($logoUrl)): ?>
                        <img class="logo" 
                             src="<?= $htmlHelper->escape($logoUrl) ?>" 
                             alt="<?= $htmlHelper->escape($siteDisplayName) ?>" 
                             height="30">
                    <?php else: ?>
                        <?= $htmlHelper->escape($siteDisplayName) ?>
                    <?php endif; ?>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <?php include(ROOT_PATH . '/templates/components/nav_main.php'); ?>
                        <?php if ($isAdmin): ?>
                            <li class="nav-item">
                                <a href="<?= $urlHelper->urlFor('/admin/index.php') ?>" class="btn btn-secondary">
                                    Admin Dashboard
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($isLoggedIn): ?>
                            <li class="nav-item">
                                <a class="btn btn-danger ml-2" href="/users/logout.php">Log Out</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="btn btn-primary ml-2" href="/users/login.php">Log In</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <?php if ($isAdmin): ?>
        <?php include(ROOT_PATH . '/templates/components/nav_admins.php'); ?>
    <?php endif; ?>

    <?php 
    $sessionMessage = $sessionHelper->getAndClearMessage();
    if ($sessionMessage): ?>
        <div id="message" class="alert alert-success" role="alert">
            <?= $htmlHelper->escape($sessionMessage) ?>
        </div>
    <?php endif; ?>
</body>
</html> 