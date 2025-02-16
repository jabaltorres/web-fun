<?php
declare(strict_types=1);

// Define constants for magic values
const TEST_ROUTE = '/test-route';
const REDIRECT_URL = '/test.php';

use Fivetwofive\KrateCMS\Controllers\AdminController;

if (!isset($router)) {
    throw new RuntimeException('Router is not initialized');
}

// Define the test route with a redirect
$router->addRoute('GET', TEST_ROUTE, fn() => redirect(REDIRECT_URL));

// Function to handle redirection
function redirect(string $url): void {
    header("Location: $url");
    exit();
}

// Define a route for the admin area
$router->get('/admin', function() use ($app) {
    try {
        // Instantiate the AdminController
        $adminController = new AdminController($app);
        $adminController->handleRequest();
    } catch (Exception $e) {
        error_log("Error in admin index: " . $e->getMessage());
        // Optionally, handle the error response
    }
});
