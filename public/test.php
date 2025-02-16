<?php
declare(strict_types=1);

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../config/bootstrap.php');

// Add error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

try {
    // Simplified page data
    $pageData = [
        'title' => 'Test Page Title',
        'description' => 'Test page description',
        'bodyClass' => 'test-page',
        'user' => [
            'loggedIn' => false,
            'isAdmin' => false
        ]
    ];

    // Load Twig template
    echo $twig->render('pages/test.twig', $pageData);

} catch (Throwable $e) { // Catching Throwable for broader exception handling
    // Log the error
    error_log($e->getMessage());
    
    // Show error page with the actual error message for debugging
    echo $twig->render('errors/500.twig', [
        'error' => $e->getMessage(),
        'app' => ['debug' => true]
    ]);
} 