<?php
declare(strict_types=1);

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../../config/bootstrap.php');

try {
    // Extract required services
    $urlHelper = $app['urlHelper'];
    $htmlHelper = $app['htmlHelper'];
    $sessionHelper = $app['sessionHelper'];
    $requestHelper = $app['requestHelper'];
    $userManager = $app['userManager'];
    $config = $app['config'];
    
    // Check if user is already logged in
    $userIsLoggedIn = $sessionHelper->isLoggedIn();
    $loggedInMessage = $userIsLoggedIn ? "You are already logged in." : "Please log in.";
    $error = '';

    if ($requestHelper->isPost()) {
        if ($requestHelper->post('logout')) {
            $userManager->logout();
            $urlHelper->redirect('login.php');
        }

        // Handle login process
        $username = $requestHelper->post('username');
        $password = $requestHelper->post('password');

        if (!$username || !$password) {
            $error = "Username and password are required.";
        } else {
            $loginResult = $userManager->login(
                $htmlHelper->escape($username),
                $password
            );

            if ($loginResult) {
                // Store session data
                $sessionHelper->set('user_id', $loginResult['user_id']);
                $sessionHelper->set('username', $loginResult['username']);
                $sessionHelper->set('first_name', $loginResult['first_name']);
                $sessionHelper->set('role', $loginResult['role']);

                $sessionHelper->setMessage('Successfully logged in!');
                $urlHelper->redirect('/index.php');
            }
            
            $error = "Invalid username or password!";
        }
    }

    // Include the header with access to all services
    include(ROOT_PATH . '/templates/shared/header.php');
} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    $error = "An error occurred during login. Please try again.";
}
?>

<div class="container py-5">
    <h1>User Login</h1>

    <?php if ($loggedInMessage): ?>
        <div class="alert alert-info" role="alert">
            <?= $htmlHelper->escape($loggedInMessage) ?>
        </div>
    <?php endif; ?>

    <?php if ($userIsLoggedIn): ?>
        <form method="post">
            <button type="submit" name="logout" value="Log Out" class="btn btn-primary">Log Out</button>
        </form>
        <a href="<?= $urlHelper->urlFor('/index.php') ?>" class="btn btn-secondary">Go to main page</a>
    <?php else: ?>
        <div class="login-form border p-4">
            <form method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" 
                           class="form-control" 
                           id="username" 
                           name="username" 
                           value="<?= $htmlHelper->escape($requestHelper->post('username', '')) ?>"
                           required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" 
                           class="form-control" 
                           id="password" 
                           name="password" 
                           required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger mt-2">
            <?= $htmlHelper->escape($error) ?>
        </div>
    <?php endif; ?>
</div>

<?php include(ROOT_PATH . '/templates/shared/footer.php'); ?>