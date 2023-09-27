<?php

// This turns on error reporting
ini_set('display_errors','1');

/**
 * This file is for functions that are used throughout the site
 * @param $script_path
 * @return string
 * @author Jabal Torres <jabaltorres@gmail.com>
 */
function url_for($script_path): string
{
    // add the leading '/' if not present
    if ($script_path[0] != '/') {
        $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
}

function u($string = "")
{
    return urlencode($string);
}

function raw_u($string = "")
{
    return rawurlencode($string);
}

function h($string = "")
{
    return htmlspecialchars($string);
}

function error_404()
{
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit();
}

function error_500()
{
    header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
    exit();
}

function redirect_to($location)
{
    header("Location: " . $location);
    exit;
}

function is_post_request()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request()
{
    return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function display_errors($errors = array())
{
    $output = '';
    if (!empty($errors)) {
        $output .= "<div class=\"errors\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach ($errors as $error) {
            $output .= "<li>" . h($error) . "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}

function get_and_clear_session_message()
{
    if (isset($_SESSION['message']) && $_SESSION['message'] != '') {
        $msg = $_SESSION['message'];
        unset($_SESSION['message']);
        return $msg;
    }
}

function display_session_message()
{
    $msg = get_and_clear_session_message();
    if (!is_blank($msg)) {
        return '<div id="message">' . h($msg) . '</div>';
    }
}

/*
 * This function is used to check the time of day and echo a greeting
 */
function timeOfDayGreeting()
{
    $time = date("H");
    $greeting = "";
    if ($time < "12") {
        $greeting = "Good Morning!";
    } elseif ($time >= "12" && $time < "17") {
        $greeting = "Good Afternoon!";
    } elseif ($time >= "17" && $time < "19") {
        $greeting = "Good Evening!";
    } elseif ($time >= "19") {
        $greeting = "Good Night!";
    }
    echo '<div class="greeting-msg mb-4">';
    echo $greeting . "<br>";
    echo "The time is " . date("h:i:sa") . "<br>";
    echo '</div>';
}

// Helper function: Check for errors
function check_for_error($error)
{
    $errorMessage = "An error has occurred.";
    if ($error) {
        echo $errorMessage;
    }
}

// Helper function: remove the file extension from the file name
function remove_file_extension($file)
{
    // file extension type
    $fileExtension = ".php";
    return str_replace($fileExtension, "", $file);
}

// Helper function: reverse an array
function reverse_array($array)
{
    $newTempArray = array_reverse($array);

    foreach ($newTempArray as $value) {
        echo "This is the new template arry value: {$value}<br>";
    }

    // return $newTempArray;
}

function printArrayValues($array)
{
    $tempArray = array();

    foreach ($array as $value) {
        echo "Print Array Values: " . $value . "<br>";
        array_push($tempArray, $value);
    }

    // reverse_array($tempArray);

}

// Helper function: print the header block
function lorem_print_header_block($array)
{
    // Helper function: check for an id
    function check_for_id($value)
    {
        if (array_key_exists('id', $value)) {
            return $value['id'];
        }
    }

    echo '<header class="block-header">';
    foreach ($array as $value) {
        echo '<div id="' . check_for_id($value) . '" class="' . $value['class'] . '">' . $value['content'] . '</div>';
    }
    echo '</header>';
}

?>
