<?php
    $title = $title ?? 'Web Fun | Default title;';
    $url = $url ?? '';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" type="image/ico" href="favicon.ico" />
    <title><?php echo $title ?></title> 

    <link rel="apple-touch-icon-precomposed" href="<?php echo $url; ?>/public/images/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $url; ?>/public/images/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $url; ?>/public/images/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $url; ?>/public/images/apple-touch-icon-144x144-precomposed.png">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto" rel="stylesheet">

      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    
    <link rel="stylesheet" href="<?php echo $url; ?>/css/slick.css">
    <link rel="stylesheet" href="<?php echo $url; ?>/css/style.css">

    <meta name="description" content="<?php echo $site_description; ?>">
    <meta name="author" content="<?php echo $site_author; ?>">
    <meta name="keywords" content="<?php echo $site_keywords; ?>">

    <meta property="og:title" content="This is my litte happy place">
    <meta property="og:image" content="link_to_image">
    <meta property="og:description" content="This is my litte happy place">
  </head>
  <body>