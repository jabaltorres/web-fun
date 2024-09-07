<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/classes/KrateUserManager.php');

    use Fivetwofive\KrateCMS\KrateUserManager;

    // Initialize the KrateUserManager with the existing $db connection
    $userManager = new KrateUserManager($db);

    // Enforce the user is logged in (will redirect if not)
    $userManager->checkLoggedIn();

    // this is for <title>
    $title = "Host Information details";

    // This is for breadcrumbs if I want a custom title other than the default
    $page_title = "This is the host index file";

    // This is the subheading
    $page_subheading = "Welcome to the Host Info page";

    //custom CSS for this page only
    $custom_class = "host-page";

    include('../../templates/layout/header.php');

?>

<div class="container py-5">

    <section class="<?php echo $custom_class; ?>">

        <?php include('../../templates/components/headline.php'); ?>

        <article>
            <h3>Note:</h3>
            <p>This is supposed to be some sort of domain dash board.</p>

            <div class="host-page-section">
                <?php
                echo "<p class='font-weight-bold mb-2'>Paths: </p>";
                echo '<div class="">PRIVATE_PATH <pre>' . PRIVATE_PATH . '</pre></div>';
                echo '<div class="">PROJECT_PATH <pre>' . PROJECT_PATH . '</pre></div>';
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

<?php include('../../templates/layout/footer.php'); ?>