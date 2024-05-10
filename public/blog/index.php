<?php
// Include the necessary configuration and functions
require_once '../../private/initialize.php';

// Page metadata
$title = "Components Page"; // Title for browser title bar
$page_title = "This is the components page"; // Title for the page, can be used in breadcrumbs or headers
$addCSS = ""; // Placeholder for page-specific CSS if needed
include_once(INCLUDES_PATH . '/site-header.php'); // Include the site header
?>

<?php
    include_once(INCLUDES_PATH . '/masthead.php'); // Include the masthead
    include_once(INCLUDES_PATH . '/navigation.php'); // Include the navigation bar
?>

<div class="container">
    <div class="site-inner">
        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                <div class="article-list-wrapper sticky-top">

                    <h1 class="page-title mb-3">Blog</h1>

                    <div class="output-php-files">

                        <?php
                        /**
                         * Outputs an HTML list of all PHP files in a specified directory, sorted in descending order.
                         * @param string $directory Path to the directory to scan for PHP files.
                         */
                        function output_php_files($directory) {
                            $files = glob($directory . "/*.php"); // Retrieve all PHP files in the specified directory
                            if (!$files) {
                                echo "No PHP files found in the directory."; // Handle case where no files are found
                                return;
                            }

                            rsort($files); // Sort the files array in descending alphabetical order

                            echo "<ul>";
                            foreach ($files as $file) {
                                $fileBaseName = basename($file); // Extract the filename from the path
                                $entryPrettyName = htmlspecialchars(remove_file_extension($fileBaseName), ENT_QUOTES, 'UTF-8'); // Remove the extension and escape HTML characters
                                echo "<li><a href='{$file}'>{$entryPrettyName}</a></li>"; // Output each file as an HTML list item
                            }
                            echo "</ul>";
                        }

                        output_php_files("./posts"); // Call the function with the directory path
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once(INCLUDES_PATH . '/site-footer.php'); // Include the site footer ?>
