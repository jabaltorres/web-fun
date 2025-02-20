<?php
declare(strict_types=1);


// Define constants for magic values
const TEST_ROUTE = '/test-route';
const REDIRECT_URL = '/test.php';

use Fivetwofive\KrateCMS\Controllers\AdminController;
use Fivetwofive\KrateCMS\Controllers\JabalController;

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

// Define routes for the admin dashboard
$router->addRoute('GET', '/admin/dashboard', function() use ($app) {
    try {
        $adminController = new AdminController($app);
        $adminController->handleRequest();
    } catch (Exception $e) {
        error_log("Error in admin dashboard: " . $e->getMessage());
    }
});

// Add POST route for handling form submissions
$router->addRoute('POST', '/admin/dashboard', function() use ($app) {
    try {
        $adminController = new AdminController($app);
        $adminController->handleRequest();
    } catch (Exception $e) {
        error_log("Error in admin dashboard: " . $e->getMessage());
    }
});

// Test route
$router->get('/admin/index', function() use ($app) {
    echo "Admin index route hit";
});

// Jabal route
$router->get('/jabal', function() use ($app) {
    $first_name = 'John';
    $last_name = 'Doe';
    $email = 'john.doe@example.com';
    $phone = '123-456-7890';
    $message = 'Hello, world!';
    $title = 'Jabal Page';
    $description = 'This is the Jabal page';
    $bodyClass = 'jabal-page';
    
    // Pass the individual parameters and Twig environment to the JabalController constructor
    $jabalController = new JabalController($first_name, $last_name, $email, $phone, $message, $app['twig'], $title, $description, $bodyClass);
    $jabalController->index();
});