<?php
declare(strict_types=1);

// Define root path and start output buffering
define('ROOT_PATH', realpath(__DIR__ . '/..'));
ob_start();

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Require Composer's autoloader
require_once ROOT_PATH . '/vendor/autoload.php';

// Load environment variables
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

// Load required function files
require_once ROOT_PATH . '/src/functions.php';
require_once ROOT_PATH . '/src/database.php';
require_once ROOT_PATH . '/src/query_functions.php';
require_once ROOT_PATH . '/src/validation_functions.php';
require_once ROOT_PATH . '/src/auth_functions.php';

// Add these use statements at the top
use Fivetwofive\KrateCMS\Core\Helpers\UrlHelper;
use Fivetwofive\KrateCMS\Core\Helpers\HtmlHelper;
use Fivetwofive\KrateCMS\Core\Helpers\SessionHelper;
use Fivetwofive\KrateCMS\Core\Helpers\RequestHelper;

// Database configuration
$dbConfig = [
    'server' => $_ENV['DB_SERVER'],
    'user' => $_ENV['DB_USER'],
    'pass' => $_ENV['DB_PASS'],
    'name' => $_ENV['DB_NAME']
];

// Initialize database connection
$dbConnection = new \Fivetwofive\KrateCMS\Core\Database\DatabaseConnection($dbConfig);

// Initialize settings manager with DatabaseConnection
$settingsManager = \Fivetwofive\KrateCMS\Models\KrateSettings::getInstance($dbConnection);

// Site configuration with database settings integration
$config = [
    'site' => [
        'owner' => $_ENV['SITE_OWNER'],
        'author' => $_ENV['SITE_AUTHOR'],
        'name' => $_ENV['SITE_NAME'],
        'tagline' => $_ENV['SITE_TAGLINE'],
        'description' => $_ENV['SITE_DESCRIPTION'],
        'logo_url' => $settingsManager->getSetting('logo_url', ''),
        'audio_source_url' => $settingsManager->getSetting('audio_source', ''),
    ],
    'db' => $dbConfig,
    'api' => [
        'postmark' => $_ENV['POSTMARK_API_TOKEN']
    ]
];

// Server configuration
$serverConfig = [
    'protocol' => empty($_SERVER['HTTPS']) ? 'http' : 'https',
    'name' => $_SERVER['SERVER_NAME'],
    'script' => $_SERVER['SCRIPT_NAME'],
    'host' => $_SERVER['HTTP_HOST'],
    'docRoot' => $_SERVER['DOCUMENT_ROOT'],
    'userAgent' => $_SERVER['HTTP_USER_AGENT'],
    'port' => $_SERVER['SERVER_PORT']
];

// Calculate base URL
$displayPort = ($serverConfig['protocol'] === 'http' && $serverConfig['port'] == 80 || 
                $serverConfig['protocol'] === 'https' && $serverConfig['port'] == 443) 
                ? '' : ":{$serverConfig['port']}";
$baseUrl = "{$serverConfig['protocol']}://{$serverConfig['name']}";

// Define path constants
define('PRIVATE_PATH', ROOT_PATH . '/src');
define('STYLES_PATH', $baseUrl . '/assets/css');
define('SCRIPTS_PATH', $baseUrl . '/assets/js');
define('IMAGES_PATH', $baseUrl . '/assets/images');

// Define WWW_ROOT
$publicEnd = strpos($_SERVER['SCRIPT_NAME'], '/public');
$docRoot = ($publicEnd !== false) ? substr($_SERVER['SCRIPT_NAME'], 0, $publicEnd) : '';
define('WWW_ROOT', $docRoot);

// Initialize Twig
$loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH . '/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => ROOT_PATH . '/cache/twig',
    'debug' => $_ENV['APP_ENV'] ?? 'development' !== 'production',
    'auto_reload' => $_ENV['APP_ENV'] ?? 'development' !== 'production',
]);

// Add global variables to Twig
$twig->addGlobal('site_name', $config['site']['name'] ?? 'KrateCMS');

// Add CSRF protection function
$twig->addFunction(new \Twig\TwigFunction('csrf_token', function() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}));

// Add helper functions to Twig
$twig->addFunction(new \Twig\TwigFunction('url_for', [UrlHelper::class, 'generate']));
$twig->addFunction(new \Twig\TwigFunction('h', [HtmlHelper::class, 'escape']));

// Initialize error array
$errors = [];

// Initialize services
$recordService = new \Fivetwofive\KrateCMS\Services\RecordService($dbConnection);
$userManager = new \Fivetwofive\KrateCMS\Services\UserManager($dbConnection, $_ENV['POSTMARK_API_TOKEN'] ?? null);

// Return important variables
return [
    'twig' => $twig,
    'db' => $dbConnection,
    'config' => $config,
    'settingsManager' => $settingsManager,
    'serverConfig' => $serverConfig,
    'baseUrl' => $baseUrl,
    'recordService' => $recordService,
    'userManager' => $userManager
]; 