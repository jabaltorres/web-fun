<?php
ob_start(); // output buffering is turned on
session_start(); // turn on sessions

// Load Composer's autoloader and initialize phpdotenv
require __DIR__ . '/../vendor/autoload.php'; // Corrected path to the vendor autoload file

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..'); // Adjust the path to your .env location
$dotenv->load(); // Load environment variables from .env

$postmarkApiToken = $_ENV['POSTMARK_API_TOKEN'];

$site_owner = $_ENV['SITE_OWNER'];
$site_author = $_ENV['SITE_AUTHOR'];
$site_name = $_ENV['SITE_NAME'];
$site_tagline = $_ENV['SITE_TAGLINE'];
$site_description = $_ENV['SITE_DESCRIPTION'];


$db_server = $_ENV['DB_SERVER'];
$db_user = $_ENV['DB_USER'];
$db_pass = $_ENV['DB_PASS'];
$db_name = $_ENV['DB_NAME'];


$base_dir = __DIR__;

// server protocol
$protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
$server_name = $_SERVER['SERVER_NAME'];
$script_name = $_SERVER['SCRIPT_NAME'];
$http_host = $_SERVER['HTTP_HOST'];
$doc_root = $_SERVER['DOCUMENT_ROOT'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$base_url = preg_replace("!^${doc_root}!", '', $base_dir);
$port = $_SERVER['SERVER_PORT'];
$disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";

// put em all together to get the complete base URL
$url = "${protocol}://${server_name}";
$enviro_prod = "web-fun.fivetwofive.com";

// Assign file path to PHP constants
// __FILE__ returns the current path to this file
// dirname() returns the path to the current directory
const PRIVATE_PATH = __DIR__;
define("PROJECT_PATH", dirname(PRIVATE_PATH));
define("STYLES_PATH", $url . '/assets/css');
define("SCRIPTS_PATH", $url . '/assets/js');
define("IMAGES_PATH", $url . '/assets/images');

// * Can dynamically find everything in the URL up to "public"
$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public');
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);

require_once('functions.php');
require_once('database.php');
require_once('query_functions.php');
require_once('validation_functions.php');
require_once('auth_functions.php');

$db = db_connect($db_server, $db_user, $db_pass, $db_name);
$errors = [];

// Load class definitions manually
// -> All classes in directory
foreach (glob('classes/*.class.php') as $file) {
    require_once($file);
}

// Autoload class definitions
function lorem_autoload($class)
{
    if (preg_match('/\A\w+\Z/', $class)) {
        include('classes/' . $class . '.class.php');
    }
}

/**
 * Autoload function for loading PHP classes dynamically.
 * Tries to load classes based on namespace first,
 * then falls back to a simple naming convention if necessary.
 */
spl_autoload_register(function($class) {
    // Check if the class file exists based on namespace
    $file = $_SERVER['DOCUMENT_ROOT'] . '/src/classes/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        include $file;
    } elseif (preg_match('/\A\w+\Z/', $class)) {
        // If the class file doesn't exist based on namespace, try simple naming convention
        $file = __DIR__ . '/classes/' . $class . '.class.php';
        if (file_exists($file)) {
            include $file;
        }
    }
});