<?php
ob_start(); // output buffering is turned on
session_start(); // turn on sessions


$site_owner = "Jabal Torres";
$site_name = "LOREM";
$site_tagline = "A place for all of your web ideas";
$site_description = "Time for some web fun";
$site_author = "Jabal Torres";
$site_keywords = "HTML5, CSS3, SASS, jQuery";

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

$db = db_connect();
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
