<?php
declare(strict_types=1);

// Define root path
define('ROOT_PATH', realpath(__DIR__ . '/..'));

// Require Composer's autoloader
require_once ROOT_PATH . '/vendor/autoload.php';

// Initialize Twig
$loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH . '/templates');
$twig = new \Twig\Environment($loader, [
    'debug' => true,
    'auto_reload' => true,
    'cache' => false  // Set to a path in production
]);

return $twig; 