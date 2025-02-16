<?php
declare(strict_types=1);

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../../config/bootstrap.php');

use Fivetwofive\KrateCMS\Controllers\UserController;

try {
    // Initialize the UserController
    $userController = new UserController($app['userManager']);
    
    // Get the user ID from the URL
    $userId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    
    // Get view data from controller
    $viewData = $userController->edit($userId);
    
    // Extract variables for the view
    extract($viewData);

} catch (Exception $e) {
    error_log("Error in user edit: " . $e->getMessage());
    $error = $e->getMessage();
}

include('../../src/Views/templates/header.php');
include('../../src/Views/users/edit.php');
include('../../src/Views/templates/footer.php'); 