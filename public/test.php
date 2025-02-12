<?php
declare(strict_types=1);

require_once(__DIR__ . '/../src/initialize.php');

try {
    // For now, let's simplify the page without UserManager
    $pageData = [
        'title' => 'Test Page Title',
        'description' => 'Test page description',
        'bodyClass' => 'test-page',
        'user' => [
            'loggedIn' => false,
            'isAdmin' => false
        ]
    ];

    // Add error reporting for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    // Load Twig template
    echo $twig->render('pages/test.twig', $pageData);

} catch (Exception $e) {
    // Log the error and show the actual error message during development
    error_log($e->getMessage());
    
    // Show error page with the actual error message for debugging
    echo $twig->render('errors/500.twig', [
        'error' => $e->getMessage(),
        'app' => ['debug' => true]
    ]);
} 