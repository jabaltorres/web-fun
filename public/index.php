<?php
declare(strict_types=1);

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../config/bootstrap.php');

use Fivetwofive\KrateCMS\Http\Controllers\RecordController;
use Fivetwofive\KrateCMS\Services\RecordService;

try {
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

    // Call the index method
    $recordController->index();
} catch (Exception $e) {
    error_log("Error in index page: " . $e->getMessage());
    echo "Error: " . $e->getMessage();
    exit;
}
?>