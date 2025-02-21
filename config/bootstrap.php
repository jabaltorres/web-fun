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

// Import required classes
use Fivetwofive\KrateCMS\Core\Helpers\UrlHelper;
use Fivetwofive\KrateCMS\Core\Helpers\HtmlHelper;
use Fivetwofive\KrateCMS\Core\Helpers\SessionHelper;
use Fivetwofive\KrateCMS\Core\Helpers\RequestHelper;
use Fivetwofive\KrateCMS\Core\Validation\ValidationService;
use Fivetwofive\KrateCMS\Core\Database\DatabaseConnection;
use Fivetwofive\KrateCMS\Core\Database\DatabaseService;
use Fivetwofive\KrateCMS\Models\KrateSettings;
use Fivetwofive\KrateCMS\Controllers\RecordController;
use Fivetwofive\KrateCMS\Models\Record;
use Fivetwofive\KrateCMS\Services\UserManager;
use Fivetwofive\KrateCMS\Services\ContactManager;
use Fivetwofive\KrateCMS\Services\RecordService;
use Fivetwofive\KrateCMS\Services\SocialLinksService;
use Fivetwofive\KrateCMS\Services\AdminAuthService;
use Fivetwofive\KrateCMS\Services\PageService;
use Fivetwofive\KrateCMS\Services\SubjectService;
use Fivetwofive\KrateCMS\Services\RankingService;

// Initialize the application container
$app = [];

// Database configuration
$dbConfig = [
    'server' => $_ENV['DB_SERVER'],
    'user' => $_ENV['DB_USER'],
    'pass' => $_ENV['DB_PASS'],
    'name' => $_ENV['DB_NAME']
];

error_log("Initializing core services in bootstrap.php");
error_log("Database config: " . print_r($dbConfig, true));

// Initialize database connection
$dbConnection = new DatabaseConnection($dbConfig);
$dbService = new DatabaseService($dbConnection);

// Add database connection to the app container
$app['databaseConnection'] = $dbConnection;

// Initialize settings manager with DatabaseConnection
$settingsManager = KrateSettings::getInstance($dbConnection);

// Calculate base URL and WWW_ROOT
$protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
$serverName = $_SERVER['SERVER_NAME'];
$port = $_SERVER['SERVER_PORT'];
$displayPort = ($protocol === 'http' && $port == 80 || 
                $protocol === 'https' && $port == 443) 
                ? '' : ":{$port}";
$baseUrl = "{$protocol}://{$serverName}{$displayPort}";
//$baseUrl = "{$protocol}://{$serverName}";

$publicEnd = strpos($_SERVER['SCRIPT_NAME'], '/public');
$docRoot = ($publicEnd !== false) ? substr($_SERVER['SCRIPT_NAME'], 0, $publicEnd) : '';
define('WWW_ROOT', $docRoot);

// Initialize core services
$urlHelper = new UrlHelper(WWW_ROOT);
$htmlHelper = new HtmlHelper();
$sessionHelper = new SessionHelper();
$requestHelper = new RequestHelper();
$validationService = new ValidationService();
$adminAuthService = new AdminAuthService();

// Add helpers to the app container
$app['requestHelper'] = $requestHelper;
$app['sessionHelper'] = $sessionHelper;
$app['htmlHelper'] = $htmlHelper;
$app['settingsManager'] = $settingsManager;

// Initialize business services
$socialLinksService = new SocialLinksService($settingsManager, $htmlHelper);
$recordService = new RecordService($dbConnection);
$userManager = new UserManager($dbConnection, $_ENV['POSTMARK_API_TOKEN'] ?? null);

// Initialize ContactManager
$contactManager = new ContactManager($dbConnection);

// Initialize RankingService
$rankingService = new RankingService($dbConnection);

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

// Add services to app container
$app['socialLinksService'] = $socialLinksService;
$app['recordService'] = $recordService;
$app['userManager'] = $userManager;
$app['contactManager'] = $contactManager;
$app['urlHelper'] = $urlHelper;
$app['config'] = $config;
$app['rankingService'] = $rankingService;

// Add to service container
$app['pageService'] = new PageService($app['databaseConnection']);
$app['subjectService'] = new SubjectService($app['databaseConnection']);

// Define path constants
define('PRIVATE_PATH', ROOT_PATH . '/src');
// define('STYLES_PATH', $baseUrl . '/assets/css');
// define('SCRIPTS_PATH', $baseUrl . '/assets/js');
define('IMAGES_PATH', $baseUrl . '/assets/images');

// Initialize Twig
$loader = new \Twig\Loader\FilesystemLoader(ROOT_PATH . '/src/Views');
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
$twig->addFunction(new \Twig\TwigFunction('url_for', [$urlHelper, 'urlFor']));
$twig->addFunction(new \Twig\TwigFunction('h', [$htmlHelper, 'escape']));
$twig->addFunction(new \Twig\TwigFunction('display_errors', [$htmlHelper, 'displayErrors']));
$twig->addFunction(new \Twig\TwigFunction('display_social_links', [$socialLinksService, 'displayLinks']));

// HTML helper function to escape output for safe rendering
// This prevents XSS attacks by converting special characters to HTML entities
function h(string $string = ""): string {
    global $htmlHelper;
    return $htmlHelper->escape($string);
}

// URL helper function to generate a URL for a given path
// This abstracts the URL generation logic, making it easier to manage routes
function url_for(string $path): string {
    global $urlHelper;
    return $urlHelper->urlFor($path);
}

// Redirect function to send the user to a specified location
// This function does not return; it terminates the current script and performs a redirect
function redirect_to(string $location): never {
    global $urlHelper;
    $urlHelper->redirect($location);
}

// After initializing Twig
$app['twig'] = $twig;

// Return the application container
return $app; 