<?php
    // this is for <title>
    $title = "Host Information details";

    // This is for breadcrumbs if I want a custom title other than the default
    $page_title = "This is the host index file";

    // This is the subheading
    $page_subheading = "Welcome to the Host Info page";

    //custom CSS for this page only
    $custom_class = "host-page";

    include_once($_SERVER['DOCUMENT_ROOT'] . '/private/initialize.php');

    // If not logged in, redirect to login page
    if (!is_logged_in()) {
        redirect_to('/public/contacts/login.php');
    }

    include_once(INCLUDES_PATH . '/site-header.php');
?>

    <div class="container">

        <?php
        include_once(INCLUDES_PATH . '/navigation.php');
        ?>

        <section class="<?php echo $custom_class; ?>">

            <?php include_once(INCLUDES_PATH . '/headline-page.php'); ?>

            <article>
                <h3>Note:</h3>
                <p>This is supposed to be some sort of domain dash board.</p>

                <div class="host-page-section">
                    <?php
                    echo "<p class='font-weight-bold mb-2'>Paths: </p>";
                    echo '<div class="">PRIVATE_PATH <pre>' . PRIVATE_PATH . '</pre></div>';
                    echo '<div class="">PROJECT_PATH <pre>' . PROJECT_PATH . '</pre></div>';
                    echo '<div class="">PUBLIC_PATH <pre>' . PUBLIC_PATH . '</pre></div>';
                    echo '<div class="">SHARED_PATH <pre>' . SHARED_PATH . '</pre></div>';
                    echo '<div class="">Includes Path <pre>' . INCLUDES_PATH . '</pre></div>';
                    echo '<div class="">INCLUDES_PATH <pre>' . IMAGES_PATH . '</pre></div>';
                    echo '<div class="">$enviro_prod <pre>' . $enviro_prod . '</pre></div>';
                    ?>
                </div>

                <div class="host-page-section">
                    <?php
                    echo "<p class='font-weight-bold mb-2'>Other Vars: </p>";
                    echo "Base dir: " . $base_dir . "<br>";
                    echo "Protocol: " . $protocol . "<br>";
                    echo "Server Name: " . $server_name . "<br>";
                    echo "Script Name: " . $script_name . "<br>";
                    echo "Doc Root: " . $doc_root . "<br>";
                    echo "Base URL: " . $base_url . "<br>";
                    echo "Port: " . $port . "<br>";
                    echo "Created URL: " . $url . "<br>";
                    ?>
                </div>

                <div class="host-page-section">
                    <?php
                    echo "Actual Link: <pre>" . $actual_link . "</pre>";
                    echo "HTTP_HOST : <pre>" . $http_host . "</pre>";
                    echo "HTTP USER AGENT: <pre>" . $user_agent . "</pre>";
                    echo "PHP_SELF: <pre>" . $_SERVER['PHP_SELF'] . "</pre>";
                    echo "Server name + Server port: <pre>" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "</pre>";
                    ?>
                </div>

                <div class="host-page-section">
                    <?php
                        if ($server_name == $enviro_prod) {
                            // Production Environment
                            echo "${protocol}://${server_name}${disp_port}/demos/${path}";
                            echo "<br>Current Environment: Prod";
                        } else {
                            // Local Environment
                            echo "${protocol}://${server_name}${disp_port}";
                            echo "<br>Current Environment: Local Dev";
                        }
                    ?>
                </div>

                <div class="host-page-section">
                    <h3>Host information courtesy of JavaScript</h3>
                    <div id="host-info"></div>
                </div>

            </article>

        </section>
    </div>

<?php include_once(INCLUDES_PATH . '/site-footer.php'); ?>