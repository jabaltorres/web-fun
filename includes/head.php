<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
    <title><?php echo $title ?></title> 

    <link rel="apple-touch-icon-precomposed" href="apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="apple-touch-icon-144x144-precomposed.png">

    <link href='http://fonts.googleapis.com/css?family=Gudea|Old+Standard+TT' rel='stylesheet' type='text/css'>
    <link href="https://fontastic.s3.amazonaws.com/mWtd8iTgMRgyWPztf4g6Zh/icons.css" rel="stylesheet">
    
    <?php 

      $base_dir = __DIR__;

      // server protocol
      $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';

      // domain name
      $domain = $_SERVER['SERVER_NAME'];
      $doc_root = $_SERVER['DOCUMENT_ROOT'];

      // $base_url = preg_replace("!^${doc_root}!", '', $base_dir);
      $base_url = preg_replace("!^${doc_root}!", '', $base_dir);

      // server port
      $port = $_SERVER['SERVER_PORT'];
      $disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";

      // put em all together to get the complete base URL
      // $url = "${protocol}://${domain}${disp_port}${base_url}";
      $url = "${protocol}://${domain}${disp_port}/web-fun";
    ?>

    <link rel="stylesheet" href="<?php echo $url; ?>/css/slick.css">
    <link rel="stylesheet" href="<?php echo $url; ?>/css/style.css">

    <meta name="description" content="Time for some web fun">
    <meta name="author" content="Jabal Torres">
    <meta name="keywords" content="HTML5, CSS3, SASS, jQuery"> 
    <meta property="og:title" content="This is my litte happy place">
    <meta property="og:image" content="link_to_image">
    <meta property="og:description" content="This is my litte happy place">
  </head>
  <body>