<?php
declare(strict_types=1);

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../config/bootstrap.php');

use Fivetwofive\KrateCMS\Controllers\RecordController;
use Fivetwofive\KrateCMS\Services\RecordService;

try {
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
} catch (Exception $e) {
    // Log the error message to the error log
    error_log("Error in index page: " . $e->getMessage());

    // Display the error message to the user
    echo "Error: " . $e->getMessage();

    // Terminate the script
    exit;
}
