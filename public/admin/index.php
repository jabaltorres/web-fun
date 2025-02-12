<?php
declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

use Fivetwofive\KrateCMS\UserManager;
use Fivetwofive\KrateCMS\KrateSettings;

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

    // Fetch all settings
    $settings = KrateSettings::getInstance($db)->getAllSettings($isAdmin);

    // Add this after the user check and before fetching settings
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
        $settings = KrateSettings::getInstance($db);
        
        switch ($_POST['action']) {
            case 'edit_setting':
                try {
                    $success = $settings->setSetting(
                        $_POST['setting_key'],
                        $_POST['setting_value'],
                        $_POST['setting_type'],
                        $_POST['category'],
                        $_POST['description'],
                        isset($_POST['is_private']),
                        $_SESSION['user_id']
                    );
                    
                    if (!$success) {
                        throw new Exception('Failed to update setting');
                    }
                    
                    $_SESSION['message'] = "Setting updated successfully";
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                    
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
                break;
                
            case 'delete_setting':
                try {
                    if ($settings->deleteSetting($_POST['setting_key'])) {
                        $_SESSION['message'] = "Setting deleted successfully";
                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit;
                    }
                    throw new Exception('Failed to delete setting');
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
                break;

            case 'add_setting':
                try {
                    $success = $settings->setSetting(
                        $_POST['setting_key'],
                        $_POST['setting_value'],
                        $_POST['setting_type'],
                        $_POST['category'],
                        $_POST['description'],
                        isset($_POST['is_private']),
                        $_SESSION['user_id']
                    );
                    
                    if (!$success) {
                        throw new Exception('Failed to add setting');
                    }
                    
                    $_SESSION['message'] = "Setting added successfully";
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;
                    
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
                break;
        }
    }

    // Page metadata
    $pageTitle = 'Admin Dashboard | ' . $config['site']['name'];
    $pageDescription = 'Administrative dashboard for ' . $config['site']['name'];

    // Include header with page metadata
    include_once('../../templates/layouts/header.php');
    
    // Include admin dashboard template
    include_once('../../templates/admin/dashboard.php');
    
    // Include footer
    include_once('../../templates/layouts/footer.php');

} catch (Exception $e) {
    // Log the error
    error_log($e->getMessage());
    
    // Show error page
    http_response_code(500);
    include_once('../../templates/errors/500.php');
}