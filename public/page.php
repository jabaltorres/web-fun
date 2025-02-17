<?php
declare(strict_types=1); // Enable strict typing

// Require initialization file
$app = require_once(__DIR__ . '/../config/bootstrap.php');

// Constants
const DEFAULT_PAGE_ID = 1; // Ensure this is an integer

// Initialize controller
$controller = new \Fivetwofive\KrateCMS\Controllers\PageController(
    $app['pageService'],
    $app['subjectService']
);

// Get view data from controller
$viewData = $controller->show();

// Render view
require_once(__DIR__ . '/../src/Views/page/show.php');
