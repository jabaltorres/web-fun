<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Core;

use Exception;

/**
 * Class Router
 * 
 * Handles routing of requests to the appropriate controllers and methods.
 */
class Router
{
    private array $routes = [];

    public function addRoute(string $method, string $path, callable $action): void
    {
        $this->routes[$method][$path] = $action;
    }

    // Convenience method for GET routes
    public function get(string $path, callable $action): void
    {
        $this->addRoute('GET', $path, $action);
    }

    // Convenience method for POST routes
    public function post(string $path, callable $action): void
    {
        $this->addRoute('POST', $path, $action);
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

    /**
     * Dispatches the request to the appropriate route handler.
     *
     * @param string $uri The URI of the request.
     * @return void
     * @throws Exception If no route matches the request.
     */
    public function dispatch(string $uri): void
    {
        // Logic to match the URI with defined routes and call the corresponding handler
        // This is a placeholder implementation; you should replace it with actual routing logic.

        // Example: Check if the URI matches any defined routes
        if (!isset($this->routes[$uri])) {
            throw new Exception("No route matched for URI: $uri");
        }

        // Call the handler for the matched route
        $handler = $this->routes[$uri];
        $handler(); // Assuming the handler is a callable
    }
} 