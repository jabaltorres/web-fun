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
    // Add the leading '/' if not present
    if ($script_path[0] != '/') {
        $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
}

/**
 * URL-encodes a string
 * @param string $string
 * @return string
 */
function u($string = "")
{
    return urlencode($string);
}

/**
 * URL-encodes a string using raw encoding
 * @param string $string
 * @return string
 */
function raw_u($string = "")
{
    return rawurlencode($string);
}

/**
 * Escapes HTML special characters in a string
 * @param string $string
 * @return string
 */
function h($string = "")
{
    return htmlspecialchars($string);
}

/**
 * Sends a 404 Not Found header and exits
 */
function error_404()
{
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit();
}

/**
 * Sends a 500 Internal Server Error header and exits
 */
function error_500()
{
    header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
    exit();
}

/**
 * Redirects to a specified location
 * @param string $location
 */
function redirect_to($location)
{
    header("Location: " . $location);
    exit;
}

/**
 * Checks if the request method is POST
 * @return bool
 */
function is_post_request()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/**
 * Checks if the request method is GET
 * @return bool
 */
function is_get_request()
{
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

/**
 * Displays errors in a formatted HTML block
 * @param array $errors
 * @return string
 */
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

/**
 * Retrieves and clears the session message
 * @return string|null
 */
function get_and_clear_session_message()
{
    if (isset($_SESSION['message']) && $_SESSION['message'] !== '') {
        $msg = $_SESSION['message'];
        unset($_SESSION['message']);
        return $msg;
    }
}

/**
 * Displays the session message if it exists
 * @return string|null
 */
function display_session_message()
{
    $msg = get_and_clear_session_message();
    if (!is_blank($msg)) {
        return '<div id="message" class="alert alert-success" role="alert">' . h($msg) . '</div>';
    }
}

/**
 * Checks the time of day and echoes a greeting
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

/**
 * Checks for an error and displays a message if one exists
 * @param mixed $error
 */
function check_for_error($error)
{
    $errorMessage = "An error has occurred.";
    if ($error) {
        echo $errorMessage;
    }
}

/**
 * Removes the file extension from a filename
 * @param string $file
 * @return string
 */
function remove_file_extension($file)
{
    // File extension type
    $fileExtension = ".php";
    return str_replace($fileExtension, "", $file);
}

/**
 * Reverses an array and echoes its values
 * @param array $array
 */
function reverse_array($array)
{
    $newTempArray = array_reverse($array);

    foreach ($newTempArray as $value) {
        echo "This is the new template array value: {$value}<br>";
    }

    // return $newTempArray;
}

/**
 * Prints values of an array
 * @param array $array
 */
function printArrayValues($array)
{
    $tempArray = array();

    foreach ($array as $value) {
        echo "Print Array Values: " . $value . "<br>";
        array_push($tempArray, $value);
    }

    // reverse_array($tempArray);
}

/**
 * Prints a header block with content from an array
 * @param array $array
 */
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

/**
 * Checks if the page is in preview mode
 * @return bool
 */
function is_preview(): bool
{
    $preview = false;
    if (isset($_GET['preview'])) {
        // Previewing should require admin to be logged in
        $preview = $_GET['preview'] === 'true';
    }
    return $preview;
}

/**
 * Displays a preview alert message
 */
function show_preview_alert()
{
    $previewAlertMessage = '<div class="container">';
    $previewAlertMessage .= '<div class="alert alert-warning" role="alert">You are previewing the page</div>';
    $previewAlertMessage .= '</div>';
    echo $previewAlertMessage;
}
?>
