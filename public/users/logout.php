<?php
declare(strict_types=1);

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../../config/bootstrap.php');

try {
    // Extract required services
    $urlHelper = $app['urlHelper'];
    $sessionHelper = $app['sessionHelper'];
    $userManager = $app['userManager'];
    
    // Perform logout
    $userManager->logout();
    $sessionHelper->setMessage('You have been successfully logged out.');
    
    // Redirect to login page
    $urlHelper->redirect('login.php');
} catch (Exception $e) {
    error_log("Logout error: " . $e->getMessage());
    $sessionHelper->setMessage("Error during logout: " . $e->getMessage());
    $urlHelper->redirect('login.php');
}