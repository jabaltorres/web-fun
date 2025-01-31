<?php
declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

use Fivetwofive\KrateCMS\UserManager;

try {
    // Initialize the UserManager with the existing $db connection
    $userManager = new UserManager($db);

    // Enforce login and admin access
    $userManager->checkLoggedIn();
    
    // Get user status
    $loggedIn = $userManager->isLoggedIn();
    $isAdmin = isset($_SESSION['user_id']) ? $userManager->isAdmin($_SESSION['user_id']) : false;
    
    // If not admin, redirect to regular dashboard
    if (!$isAdmin) {
        header('Location: /dashboard');
        exit;
    }

    // Fetch users only if admin (with error handling)
    $users = null;
    if ($isAdmin) {
        $result = $userManager->getAllUsers();
        $users = $result ? $result : null;
    }

    // Page metadata
    $pageTitle = 'Admin Dashboard | ' . $config['site']['name'];
    $pageDescription = 'Administrative dashboard for ' . $config['site']['name'];

    // Include header with page metadata
    include_once('../../templates/layout/header.php');
    
    // Include admin dashboard template
    include_once('../../templates/admin/dashboard.php');
    
    // Include footer
    include_once('../../templates/layout/footer.php');

} catch (Exception $e) {
    // Log the error
    error_log($e->getMessage());
    
    // Show error page
    http_response_code(500);
    include_once('../../templates/errors/500.php');
}