<?php
declare(strict_types=1);

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../config/bootstrap.php');

use Fivetwofive\KrateCMS\Controllers\RecordController;
use Fivetwofive\KrateCMS\Core\Router;

// Define constants for magic values
const TEST_ROUTE = '/test-route';
const REDIRECT_URL = '/test.php';

// Initialize the router
$router = new Router();

// Define the test route with a redirect
$router->addRoute('GET', TEST_ROUTE, fn() => redirect(REDIRECT_URL));

// Function to handle redirection
function redirect(string $url): void {
    header("Location: $url");
    exit();
}

// Move the routing resolution before the RecordController logic
try {
    // Attempt to resolve the route first
    $routeResolved = $router->resolve($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
    
    // Only proceed with RecordController if no route was matched
    if ($routeResolved) {
        return; // Early return if route is resolved
    }

    // Initialize the RecordController with required services from the app container
    $recordController = new RecordController(
        $app['recordService'],
        $app['requestHelper'],
        $app['sessionHelper'],
        $app['htmlHelper'],
        $app['settingsManager'],
        $app['socialLinksService'],
        $app['urlHelper'],
        $app['userManager'],
        $app['config']
    );

    // Call the index method of the RecordController
    $recordController->index();
} catch (Exception $e) { // Use a general Exception type
    // Log the error message to the error log
    error_log("Error in index page: " . $e->getMessage());

    // Display the error message to the user
    echo "Error: " . $e->getMessage();

    // Terminate the script
    exit;
} catch (Throwable $e) {
    // Handle any other types of errors
    error_log("Unexpected error: " . $e->getMessage());
    echo "An unexpected error occurred.";
    exit;
}
