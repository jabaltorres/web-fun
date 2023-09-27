<?php
    require_once '../../private/initialize.php';

    $title = "Components Page"; // this is for <title>
    $page_title = "This is the components page"; //this is for breadcrumbs if I want a custom title other than the default
    $addCSS = ""; //custom CSS for this page only
    include_once(INCLUDES_PATH . '/site-header.php');
?>

    <div class="container">

        <?php include_once(INCLUDES_PATH . '/masthead.php'); ?>
        <?php include_once(INCLUDES_PATH . '/navigation.php'); ?>

        <div class="site-inner">

            <div class="row">
                <div class="col-12 col-md-8 mx-auto">
                    <div class="article-list-wrapper sticky-top">
                        <span class="d-block font-weight-bold py-2">Blog</span>
                        <div>Just testing some things here!</div>
                        <?php

                            function output_php_files($directory) {
                                // Check if the directory exists
                                $directory = dir($directory);

                                // TODO: fix this error handling
                                if (!$directory) {
                                    check_for_error(true);
                                    echo "The directory does not exist.";
                                }

                                // variable to hold the path to the directory
                                $directoryPath = $directory->path;

                                $results = array();

                                while (false !== ($entry = $directory->read())) {
                                    if ($entry != "." && $entry != ".."){
                                        $results[] = $entry;
                                    }
                                }

                                $directory->close();

                                // reverse the array
                                $reversedArray = array_reverse($results);

                                echo "<ul>";
                                foreach ($reversedArray as $item) {
                                    $entryPrettyName = remove_file_extension($item);
                                    echo "<li><a href='{$directoryPath}/{$item}'>{$entryPrettyName}</a></li>";
                                }
                                echo "</ul>";
                            }

                            $links = output_php_files("./posts");



                        ?>



                    </div>
                </div>
            </div>
        </div>

    </div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');