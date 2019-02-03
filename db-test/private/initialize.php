<?php
    ob_start(); // output buffering is turned on

    // Assign file path to PHP constants
    // __FILE__ returns the current path to this file
    // dirname() returns the path to the current directory
    define("PRIVATE_PATH", dirname(__FILE__));
    define("PROJECT_PATH", dirname(PRIVATE_PATH));
    define("PUBLIC_PATH", PROJECT_PATH . '/public');
    define("SHARED_PATH", PRIVATE_PATH . '/shared');


    // Assign the root URL to a PHP constant
    // * Do not need to include the domain
    // * Use same document root as the web server
    // define("WWW_ROOT", '/~jabaltorres/web-fun/db-test/public');
    // define("WWW_ROOT", '');
    // * Can dynamically find everything in the URL up to "public"
    $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
    $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
    define("WWW_ROOT", $doc_root);


    require_once('functions.php');
    require_once('database.php');
    require_once('query_functions.php');
    require_once('validation_functions.php');

    $db = db_connect();
?>