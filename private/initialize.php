<?php
ob_start(); // output buffering is turned on

session_start(); // turn on sessions


$site_owner = "Jabal Torres";
$site_name = "LOREM";
$site_tagline = "A place for all of your web ideas";
$site_description = "Time for some web fun";
$site_author = "Jabal Torres";
$site_keywords = "HTML5, CSS3, SASS, jQuery";

// Some server stuff
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
$enviro_prod = "jabaltorres.com";
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
define("PUBLIC_PATH", PROJECT_PATH . '/public');
define("SHARED_PATH", PRIVATE_PATH . '/shared');
define("INCLUDES_PATH", PROJECT_PATH . '/includes');
define("IMAGES_PATH", PROJECT_PATH . '/images');
define("BLOCKS_PATH", PROJECT_PATH . '/blocks');
define("ELEMENTS_PATH", PROJECT_PATH . '/elements');
define("INCL_PATH", PROJECT_PATH . '/incl');


// Assign the root URL to a PHP constant
// * Do not need to include the domain
// * Use same document root as the web server
// define("WWW_ROOT", '/~jabaltorres/web-fun/db-test/public');
// define("WWW_ROOT", '');
// * Can dynamically find everything in the URL up to "public"
$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);
//echo '<div class="">WWW root: ' . WWW_ROOT . '</div>';


//echo "<p>Paths: </p>";
//echo '<div class="">Private Path: ' . PRIVATE_PATH . '</div>';
//echo '<div class="">Project Path: ' . PROJECT_PATH . '</div>';
//echo '<div class="">Public Path: ' . PUBLIC_PATH . '</div>';
//echo '<div class="">Shared Path: ' . SHARED_PATH . '</div>';
//echo '<div class="">Includes Path: ' . INCLUDES_PATH . '</div>';
//echo '<div class="">Images Path: ' . IMAGES_PATH . '</div>';
//echo '<div class="">Blocks Path: ' . BLOCKS_PATH . '</div>';
//echo '<div class="">Incl Path: ' . INLC_PATH . '</div>';
//echo '<div class="">Enviro Prod: ' . $enviro_prod . '</div>';
//
//echo "<p>Other Vars: </p>";
//echo "Base dir: " . $base_dir . "<br>";
//echo "Protocol: " . $protocol . "<br>";
//echo "Server Name: " . $server_name . "<br>";
//echo "Script Name: " . $script_name . "<br>";
//echo "Doc Root: " . $doc_root . "<br>";
//echo "Base URL: " . $base_url . "<br>";
//echo "Port: " . $port . "<br>";
//echo "Created URL: " . $url . "<br>";
//
//
//echo "<p>&nbsp;</p>";
//echo "Actual Link: " . $actual_link . "<br>";
//echo "HTTP Host: " . $http_host . "<br>";
//echo "HTTP USER AGENT: " . $user_agent . "<br>";
//echo "PHP_SELF: " . $_SERVER['PHP_SELF'];
//
//echo "<p>&nbsp;</p>";
//echo "Server name + Server port: " . $_SERVER['SERVER_NAME'] . ":  ". $_SERVER['SERVER_PORT']. "<br>";


require_once('functions.php');
require_once('database.php');
require_once('query_functions.php');
require_once('validation_functions.php');
require_once('auth_functions.php');

$db = db_connect();
$errors = [];

?>
