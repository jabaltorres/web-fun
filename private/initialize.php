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
// $url = "${protocol}://${domain}${disp_port}${base_url}";
$enviro_prod = "web-fun.fivetwofive.com";
$enviro_dev = "localhost";
$path = "web-fun";
if ($server_name == $enviro_prod){
    // Production Environment
    $url = "${protocol}://${server_name}${disp_port}/demos/${path}";
} else {
    // Local Environment
    // $url = "${protocol}://${domain}${disp_port}/${path}";
    $url = "${protocol}://${server_name}${disp_port}";
}

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


// Assign file path to PHP constants
// __FILE__ returns the current path to this file
// dirname() returns the path to the current directory
define("PRIVATE_PATH", dirname(__FILE__));
define("PROJECT_PATH", dirname(PRIVATE_PATH));
const PUBLIC_PATH = PROJECT_PATH . '/public';
const SHARED_PATH = PRIVATE_PATH . '/shared';
const INCLUDES_PATH = PROJECT_PATH . '/includes';
const IMAGES_PATH = PUBLIC_PATH . '/images';
const BRAND_PATH = PROJECT_PATH . '/brand';
const BLOCKS_PATH = PROJECT_PATH . '/blocks';
const ELEMENTS_PATH = PUBLIC_PATH . '/elements';
const COMPONENTS_PATH = PROJECT_PATH . '/components';
const INCL_PATH = PROJECT_PATH . '/incl';

// * Can dynamically find everything in the URL up to "public"
$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
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
foreach(glob('classes/*.class.php') as $file) {
    require_once($file);
}

// Autoload class definitions
function lorem_autoload($class) {
    if(preg_match('/\A\w+\Z/', $class)) {
        include('classes/' . $class . '.class.php');
    }
}
spl_autoload_register('lorem_autoload');