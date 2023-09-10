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
                <div class="col-12">
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

                                echo "<ul>";

                                // echo type of $directory
                                // echo 'The directory variable is this type:' . gettype($directory) . "<br>";

                                $results = array();

                                while (false !== ($entry = $directory->read())) {

                                    if ($entry != "." && $entry != ".."){

                                        $results[] = $entry;

                                        // remove the file extension from the file name
                                        $entryPrettyName = remove_file_extension($entry);

                                        echo "<li><a href='{$directoryPath}/{$entry}'>{$entryPrettyName}</a></li>";
                                    }
                                }

                                echo "</ul>";

                                // print the array values
                                // printArrayValues($results);

                                $directory->close();
                            }

                            $links = output_php_files("./posts");

//                            echo 'This is the end of the php file.';
                        ?>



                    </div>
                </div>
            </div>
        </div>

    </div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');