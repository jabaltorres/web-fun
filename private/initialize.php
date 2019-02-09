<?php
    ob_start(); // output buffering is turned on

    session_start(); // turn on sessions

    // Assign file path to PHP constants
    // __FILE__ returns the current path to this file
    // dirname() returns the path to the current directory
    define("PRIVATE_PATH", dirname(__FILE__));
    define("PROJECT_PATH", dirname(PRIVATE_PATH));
    define("PUBLIC_PATH", PROJECT_PATH . '/public');
    define("SHARED_PATH", PRIVATE_PATH . '/shared');

    // * JT Custom
    defined("INCLUDES_PATH") or define("INCLUDES_PATH", realpath(dirname(__FILE__) . '/../../includes'));


    // Assign the root URL to a PHP constant
    // * Do not need to include the domain
    // * Use same document root as the web server
    // define("WWW_ROOT", '/~jabaltorres/web-fun/db-test/public');
    // define("WWW_ROOT", '');
    // * Can dynamically find everything in the URL up to "public"
    $public_end = strpos($_SERVER['SCRIPT_NAME'], '/db-test') + 8;
    $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
    define("WWW_ROOT", $doc_root);


    require_once('functions.php');
    require_once('database.php');
    require_once('query_functions.php');
    require_once('validation_functions.php');
    require_once('auth_functions.php');

    $db = db_connect();
    $errors = [];



    // * JT Custom
    $site_owner = "Jabal Torres";
    $site_name = "LOREM";
    $site_tagline = "A place for all of your web ideas";
    $site_description = "Time for some web fun";
    $site_author = "Jabal Torres";
    $site_keywords = "HTML5, CSS3, SASS, jQuery";
?>