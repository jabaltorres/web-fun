<?php
	// Set default page title if not provided
	$page_title = $settingsManager->getSetting('site_name') ?? 'KrateCMS'; // Use null coalescing operator

	$url = $url ?? '';
	$is_logged_in = isset($_SESSION['user_id']);
    $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'Administrator';
	$adminMessage = $isAdmin ? "admin is logged in" : "admin is not logged in"; // Use ternary operator

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
    <title><?= $settingsManager->getSetting('site_name'); ?></title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo STYLES_PATH; ?>/public.css">
    <link rel="stylesheet" href="<?php echo STYLES_PATH; ?>/simple.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/9b6vdo6p51qb89toe164crjl7qyvmjbnp3qyv43i0d4wp3mw/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Add dark mode styles -->
    <style>
 
    </style>
</head>

<body class="<?php echo $settingsManager->getSetting('dark_mode', false) ? 'dark-mode' : ''; ?>">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <?php if (!empty($config['site']['logo_url'])): ?>
                        <img class="logo" src="<?= htmlspecialchars($config['site']['logo_url']) ?>" alt="<?= htmlspecialchars($config['site']['name']) ?>" height="30">
                    <?php else: ?>
                        <?= htmlspecialchars($config['site']['name']) ?>
                    <?php endif; ?>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <?php include($_SERVER['DOCUMENT_ROOT'] . '/../templates/components/nav_main.php'); ?>

                    <!-- Update navbar text to reflect user status -->
                    
                    <span>
                        <?php if ($isAdmin): ?>
                            <a href="<?= url_for('/admin/index.php'); ?>" class="btn btn-secondary">
                                Admin Dashboard
                            </a>
                        <?php endif; ?>

                        <?php if ($is_logged_in): ?>
                            <a class="btn btn-danger mr-2" href="/users/logout.php">Log Out</a>
                        <?php else: ?>
                            <a class="btn btn-primary mr-2" href="/users/login.php">Log In</a>
                        <?php endif; ?>
                    </span>
                </div>
            </div>
        </nav>
    </header>
    <main>
<?php
	if ($isAdmin) {
		include($_SERVER['DOCUMENT_ROOT'] . '/../templates/components/nav_admins.php');
	}
?>

<?php echo display_session_message(); ?>
