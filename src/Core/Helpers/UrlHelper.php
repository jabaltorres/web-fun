<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Core\Helpers;

class UrlHelper
{
    /**
     * Generate a URL for a script path
     *
     * @param string $scriptPath
     * @return string
     */
    public static function generate(string $scriptPath): string
    {
        if ($scriptPath[0] != '/') {
            $scriptPath = "/" . $scriptPath;
        }
        return WWW_ROOT . $scriptPath;
    }

    /**
     * URL-encode a string
     *
     * @param string $string
     * @return string
     */
    public static function encode(string $string = ""): string
    {
        return urlencode($string);
    }

    /**
     * Raw URL-encode a string
     *
     * @param string $string
     * @return string
     */
    public static function rawEncode(string $string = ""): string
    {
        return rawurlencode($string);
    }
} 