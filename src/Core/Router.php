<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Core;

class Router
{
    private array $routes = [];

    public function addRoute(string $method, string $path, callable $action): void
    {
        $this->routes[$method][$path] = $action;
    }

    public function resolve(string $method, string $path): bool
    {
        // Remove query string if present
        $path = parse_url($path, PHP_URL_PATH);
        
        // Remove trailing slashes, leading slashes, and index.php if present
        $path = '/' . trim(str_replace('index.php', '', $path), '/');

        // Check for exact matches
        if (isset($this->routes[$method][$path])) {
            ($this->routes[$method][$path])();
            return true;
        }

        // No route matched
        return false;
    }
} 