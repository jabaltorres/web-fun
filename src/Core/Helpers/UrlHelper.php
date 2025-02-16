<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Core\Helpers;

class UrlHelper
{
    private string $wwwRoot;

    public function __construct(string $wwwRoot)
    {
        $this->wwwRoot = $wwwRoot;
    }

    /**
     * Generate a URL for a script path
     *
     * @param string $scriptPath
     * @return string
     */
    public function urlFor(string $scriptPath): string
    {
        if ($scriptPath[0] !== '/') {
            $scriptPath = "/" . $scriptPath;
        }
        return $this->wwwRoot . $scriptPath;
    }

    public function redirect(string $location): never
    {
        header("Location: " . $location);
        exit;
    }

    public function error404(): never
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        exit();
    }

    public function error500(): never
    {
        header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
        exit();
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

    public function u(string $string): string {
        return urlencode($string);
    }
}