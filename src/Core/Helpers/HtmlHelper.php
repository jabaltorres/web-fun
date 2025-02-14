<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Core\Helpers;

class HtmlHelper
{
    /**
     * Escape HTML special characters in a string
     *
     * @param string $string
     * @return string
     */
    public static function escape(string $string = ""): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Display errors in a formatted HTML block
     *
     * @param array $errors
     * @return string
     */
    public static function displayErrors(array $errors = []): string
    {
        if (empty($errors)) {
            return '';
        }

        $output = "<div class=\"errors\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach ($errors as $error) {
            $output .= "<li>" . self::escape($error) . "</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";

        return $output;
    }
} 