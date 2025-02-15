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
    $settingsManager = $app['settingsManager'];
    $config = $app['config'];
    
    // Enforce login and admin access
    if (!$sessionHelper->isLoggedIn()) {
        $sessionHelper->setMessage('Please login to access admin area');
        $urlHelper->redirect('/users/login.php');
    }
    
    // Get user status
    $loggedIn = $sessionHelper->isLoggedIn();
    $userId = $sessionHelper->getCurrentUserId();
    $isAdmin = $userId ? $userManager->isAdmin($userId) : false;
    
    // If not admin, redirect to regular dashboard
    if (!$isAdmin) {
        $sessionHelper->setMessage('Access denied. Admin privileges required.');
        $urlHelper->redirect('/dashboard');
    }

    // Fetch users only if admin (with error handling)
    $users = null;
    if ($isAdmin) {
        $result = $userManager->getAllUsers();
        $users = $result ?: null;
    }

    // Fetch all settings
    $settings = $settingsManager->getAllSettings($isAdmin);

    // Handle POST requests
    if ($requestHelper->isPost() && $requestHelper->post('action')) {
        $action = $requestHelper->post('action');
        
        try {
            switch ($action) {
                case 'edit_setting':
                    $success = $settingsManager->setSetting(
                        $requestHelper->post('setting_key'),
                        $requestHelper->post('setting_value'),
                        $requestHelper->post('setting_type'),
                        $requestHelper->post('category'),
                        $requestHelper->post('description'),
                        (bool)$requestHelper->post('is_private'),
                        $userId
                    );
                    
                    if (!$success) {
                        throw new Exception('Failed to update setting');
                    }
                    
                    $sessionHelper->setMessage('Setting updated successfully');
                    $urlHelper->redirect($_SERVER['PHP_SELF']);
                    break;
                    
                case 'delete_setting':
                    if ($settingsManager->deleteSetting($requestHelper->post('setting_key'))) {
                        $sessionHelper->setMessage('Setting deleted successfully');
                        $urlHelper->redirect($_SERVER['PHP_SELF']);
                    }
                    throw new Exception('Failed to delete setting');
                    break;

                case 'add_setting':
                    $success = $settingsManager->setSetting(
                        $requestHelper->post('setting_key'),
                        $requestHelper->post('setting_value'),
                        $requestHelper->post('setting_type'),
                        $requestHelper->post('category'),
                        $requestHelper->post('description'),
                        (bool)$requestHelper->post('is_private'),
                        $userId
                    );
                    
                    if (!$success) {
                        throw new Exception('Failed to add setting');
                    }
                    
                    $sessionHelper->setMessage('Setting added successfully');
                    $urlHelper->redirect($_SERVER['PHP_SELF']);
                    break;
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            $sessionHelper->setMessage("Error: {$error}");
        }
    }

    // Page metadata
    $pageTitle = 'Admin Dashboard | ' . $config['site']['name'];
    $pageDescription = 'Administrative dashboard for ' . $config['site']['name'];

    // Include templates
    include(ROOT_PATH . '/templates/layouts/header.php');
    include(ROOT_PATH . '/templates/admin/dashboard.php');
    include(ROOT_PATH . '/templates/layouts/footer.php');

} catch (Exception $e) {
    // Log the error
    error_log("Admin Dashboard Error: " . $e->getMessage());
    
    // Set error message and redirect
    $sessionHelper->setMessage("An error occurred: " . $e->getMessage());
    $urlHelper->redirect('/index.php');
}