<?php
    $title = "Host Information details";
    // this is for <title>

    $page_title = "This is the host index file";
    // This is for breadcrumbs if I want a custom title other than the default

    $page_subheading = "Welcome to the Host Info page";
    // This is the subheading

    $custom_class = "host-page";
    //custom CSS for this page only

    // Preliminaries
    include_once('../private/initialize.php');

    if ( !is_logged_in() ) {
        redirect_to('../public/contacts/login.php');
    } else {
        // Do nothing, let the rest of the page proceed
    }

    include_once(INCLUDES_PATH . '/site-header.php');
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

                echo "<p>Paths: </p>";
                echo '<div class="">Private Path: ' . PRIVATE_PATH . '</div>';
                echo '<div class="">Project Path: ' . PROJECT_PATH . '</div>';
                echo '<div class="">Public Path: ' . PUBLIC_PATH . '</div>';
                echo '<div class="">Shared Path: ' . SHARED_PATH . '</div>';
                echo '<div class="">Includes Path: ' . INCLUDES_PATH . '</div>';
                echo '<div class="">Images Path: ' . IMAGES_PATH . '</div>';
                echo '<div class="">Blocks Path: ' . BLOCKS_PATH . '</div>';
                echo '<div class="">Incl Path: ' . INCL_PATH . '</div>';
                echo '<div class="">Enviro Prod: ' . $enviro_prod . '</div>';

                echo "<p>Other Vars: </p>";
                echo "Base dir: " . $base_dir . "<br>";
                echo "Protocol: " . $protocol . "<br>";
                echo "Server Name: " . $server_name . "<br>";
                echo "Script Name: " . $script_name . "<br>";
                echo "Doc Root: " . $doc_root . "<br>";
                echo "Base URL: " . $base_url . "<br>";
                echo "Port: " . $port . "<br>";
                echo "Created URL: " . $url . "<br>";


                echo "<p>&nbsp;</p>";
                echo "Actual Link: " . $actual_link . "<br>";
                echo "HTTP Host: " . $http_host . "<br>";
                echo "HTTP USER AGENT: " . $user_agent . "<br>";
                echo "PHP_SELF: " . $_SERVER['PHP_SELF'];

                echo "<p>&nbsp;</p>";
                echo "Server name + Server port: " . $_SERVER['SERVER_NAME'] . ":  ". $_SERVER['SERVER_PORT']. "<br>";
            ?>

            <div class="border mt-2 p-4">
                <?php
                    if ($server_name == $enviro_prod){
                        // Production Environment
                        //		      $url = "${protocol}://${server_name}${disp_port}/demos/${path}";
                        echo "${protocol}://${server_name}${disp_port}/demos/${path}";
                        echo "<br>Environment: Prod";
                    } else {
                        // Local Environment
                        // $url = "${protocol}://${domain}${disp_port}/${path}";
                        //		      $url = "${protocol}://${server_name}${disp_port}";
                        echo "${protocol}://${server_name}${disp_port}";
                        echo "<br>Environment: Local Dev";
                    }
                ?>
            </div>

        </article>

        <article>
            <h3>Host information courtesy of JavaScript</h3>

            <!-- being used by javascript-->
            <div id="host-info" class=""></div>
        </article>

    </section>
</div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');?>