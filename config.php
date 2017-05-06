<?php 
  $site_owner = "Jabal Torres";
  $site_name = "LOREM";
  $site_tagline = "A place for all of your web ideas";
  $site_description = "Time for some web fun";
  $site_author = "Jabal Torres";
  $site_keywords = "HTML5, CSS3, SASS, jQuery";

  // # Environment

  $enviro_prod = "jabaltorres.com";
  $enviro_dev = "localhost";
  $path = "web-fun";


  // Some server stuff
  $base_dir = __DIR__;

  // server protocol
  $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
  $domain = $_SERVER['SERVER_NAME'];
  $doc_root = $_SERVER['DOCUMENT_ROOT'];
  $base_url = preg_replace("!^${doc_root}!", '', $base_dir);
  $port = $_SERVER['SERVER_PORT'];
  $disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";

  // put em all together to get the complete base URL
  // $url = "${protocol}://${domain}${disp_port}${base_url}";
  if ($domain == $enviro_prod){
    $url = "${protocol}://${domain}${disp_port}/demos/${path}";
  } else {
    $url = "${protocol}://${domain}${disp_port}/${path}";
  }

  /*
    Creating constants for heavily used paths makes things a lot easier.
    ex. require_once(LIBRARY_PATH . "Paginator.php")
  */

  // define('BASE_URL', 'http://example.com');
  defined("BASE_PATH") or define("BASE_PATH", realpath(dirname(__FILE__) ));
  defined("LIBRARY_PATH") or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));
  defined("TEMPLATES_PATH") or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));
  defined("INCLUDES_PATH") or define("INCLUDES_PATH", realpath(dirname(__FILE__) . '/includes'));
  defined("IMAGES_PATH") or define("IMAGES_PATH", realpath(dirname(__FILE__) . '/images'));

  /* 
    Define database connection constants 
  */
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASSWORD', 'root');
  define('DB_NAME', 'lorem_test_db');

?>