<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $htmlHelper->escape($settingsManager->getSetting('site_name')) ?></title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= url_for('/assets/css/style.css') ?>">
</head>
<body>
    <header class="mb-4">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="<?= url_for('/index.php') ?>">
                    <?= $htmlHelper->escape($settingsManager->getSetting('site_name')) ?>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url_for('/index.php') ?>">Home</a>
                        </li>
                        <?php if ($loggedIn): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= url_for('/admin/index.php') ?>">Admin</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= url_for('/logout.php') ?>">Logout</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= url_for('/login.php') ?>">Login</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
</body>
</html> 