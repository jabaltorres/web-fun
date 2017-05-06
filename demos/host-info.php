<?
  $title = "Host Info file"; 
  // this is for <title>

  $page_title = "This is the host index file";
  // This is for breadcrumbs if I want a custom title other than the default

  $page_subheading = "Welcome to the Host Info page"; 
  // This is the subheading

  $custom_class = "host-page"; 
  //custom CSS for this page only

  // Preliminaries
  include_once('../config.php');  
  include_once(INCLUDES_PATH . '/head.php');
?>
  <div class="container">
  
  <?php

    include_once(INCLUDES_PATH . '/masthead.php');
    include_once(INCLUDES_PATH . '/navigation.php');
  ?>

  <section class="<?php echo $custom_class; ?>">

    <?php include_once(INCLUDES_PATH . '/headline-page.php');?>
    
    <article>
      <h3>Note:</h3>
      <p>This is supposed to be some sort of domain dash board.</p>
      
      <?php
        // echo $url; // = http://example.com/path/directory

        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $http_host = $_SERVER[HTTP_HOST];

        echo "<h4>Page Title: " . $title . "</h4>";

        echo "Base dir: " . $base_dir . "<br>";
        echo "Protocol: " . $protocol . "<br>";
        echo "Domain: " . $domain . "<br>";
        echo "Doc Root: " . $doc_root . "<br>";
        echo "Base URL: " . $base_url . "<br>";
        echo "Port: " . $port . "<br>";
        echo "Created URL: " . $url . "<br>";

        echo "<p>&nbsp;</p>";

        echo "Base Path: " . BASE_PATH . "<br>";
        echo "Library Path: " . LIBRARY_PATH . "<br>";
        echo "Templates Path: " . TEMPLATES_PATH . "<br>";
        echo "Images Path: " . IMAGES_PATH . "<br>";
        echo "Actual URL: " . $actual_link . "<br>";
        echo "HTTP Host: " . $http_host . "<br>";

        echo "<p>&nbsp;</p>";
        echo "Base URL - 2: " . BASE_URL . "<br>";
        echo "Server name + Server port: " . $_SERVER['SERVER_NAME'] .":  ". $_SERVER['SERVER_PORT']. "<br>";
        echo "Path Translated: " . $_SERVER['PATH_TRANSLATED'] . "<br>";

        echo "<p>&nbsp;</p>";
        echo $_SERVER['PHP_SELF'];
        echo "<br>";
        echo $_SERVER['SERVER_NAME'];
        echo "<br>";
        echo $_SERVER['HTTP_HOST'];
        echo "<br>";
        echo $_SERVER['HTTP_REFERER'];
        echo "<br>";
        echo $_SERVER['HTTP_USER_AGENT'];
        echo "<br>";
        echo $_SERVER['SCRIPT_NAME'];


      ?>  
    </article>
    <article>
      <h3>Host information courtesy of JavaScript</h3>
      
      <!-- being used by javascript-->
      <div id="host-info" class=""></div>
    </article>
  </section>

<?php include_once(INCLUDES_PATH . '/feet.php');?>