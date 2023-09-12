<?php

use JetBrains\PhpStorm\Pure;

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

/*
 * This class is used to create a new HTML element
 */
class LoremElement
{

    private string $tag_name;
    private array $attributes = [];
    private string $content;

    public function __construct($tag_name)
    {
        $this->tag_name = $tag_name;
    }

    public function setAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function setContent($content): LoremElement
    {
        $this->content = $content;
        return $this;
    }

    public function render(): string
    {
        // build attribute string
        $attributeString = "";

        // loop through attributes
        foreach ($this->attributes as $name => $value) {
            $attributeString .= " {$name}=\"{$value}\"";
        }

        // open the tag and add attributes
        $html = "<{$this->tag_name} {$attributeString}>";

        // add content
        if ($this->content) {
            $html .= "$this->content";
        }
        // close the tag
        $html .= "</{$this->tag_name}>";

        return $html;
    }
}

// This turns on error reporting
ini_set('display_errors','1');

/**
 * This creates a new HTML card element
 */
class LoremCard {

    private string $id;
    private string $classes;
    private string $content;
    private bool $dark_mode;

//    public function __construct($id, $classes, $content, $dark_mode = false) {
//        $this->id = $id;
//        $this->class = $classes;
//        $this->content = $content;
//        $this->dark_mode = $dark_mode;
//    }

    public function __construct($args=[]) {
        $this->id = $args['id'] ?? '';
        $this->classes = $args['classes'] ?? '';
        $this->content = $args['content'] ?? '';
        $this->dark_mode = $args['dark_mode'] ?? false;
    }

    // Description: This function is used to return the id of the object

    public function setDarkMode(): string
    {
        if ($this->dark_mode == true) {
            return "<div class='bg-primary p-2 dark text-light'>Dark Mode</div>";
        } else {
            return "<div class='bg-secondary p-2 default'>Default Mode</div>";
        }
    }


    /**
     * Description: This function is used to return the class of the object
     */
   #[Pure] public function render(): string
    {
        $html = "<div id=\"{$this->id}\" class=\"{$this->classes}\">";
        $html .= "Excuse me, Let me clear my throat. <br>";
        $html .= "{$this->content} <br>";
        $html .= self::setDarkMode();
        $html .= "</div>";

        return $html;
    }
}

/*
 * This class is used to create a new Audio element
 */
class AudioElement {

    private string $title;
    private string $src;
    private string $type;
    private bool $controls;
    private bool $autoplay;
    private bool $loop;


    public function __construct($title, $src, $type, $controls = true, $autoplay = false, $loop = false) {
        $this->title = $title;
        $this->src = $src;
        $this->type = $type;
        $this->controls = $controls;
        $this->autoplay = $autoplay;
        $this->loop = $loop;
    }

    /**
     * Description: This function is used to set the autoplay attribute
     * @param $autoplay
     * @return string
     */
    public function setAutoplay($autoplay): string
    {
        $this->autoplay = $autoplay;

        if ($this->autoplay == true) {
            return  "autoplay='{$this->autoplay}'";
        } else {
            return "";
        }
    }

    public function setLoop($loop) {
        $this->loop = $loop;
    }

    public function render(): string
    {
        $html = "<h3 class=\"h5 font-weight-bold\">{$this->title}</h3>";
        $html .= "<audio class=\"audio-player\" controls=\"{$this->controls}\" {$this->setAutoplay($this->autoplay)}  loop=\"{$this->loop}\">";
        $html .= "<source src=\"{$this->src}\" type=\"{$this->type}\">";
        $html .= "</audio>";

        return $html;
    }
}

?>
