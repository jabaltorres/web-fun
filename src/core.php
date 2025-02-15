<?php
declare(strict_types=1);

// Turn on error reporting
ini_set('display_errors', '1');

// Add this at the top of the file with other use statements
use Fivetwofive\KrateCMS\Models\KrateSettings;

// Load class autoloader and configuration
require_once __DIR__ . '/../vendor/autoload.php';

// Initialize services (this could be moved to a service container/dependency injection)
use Fivetwofive\KrateCMS\Core\Database\DatabaseConnection;
use Fivetwofive\KrateCMS\Core\Database\DatabaseService;
use Fivetwofive\KrateCMS\Core\Auth\AdminAuthService;
use Fivetwofive\KrateCMS\Core\Validation\ValidationService;
use Fivetwofive\KrateCMS\Core\Helpers\UrlHelper;
use Fivetwofive\KrateCMS\Services\SocialLinksService;
use Fivetwofive\KrateCMS\Core\Helpers\HtmlHelper;

// Legacy function aliases for backward compatibility
function h(string $string = ""): string {
    return HtmlHelper::escape($string);
}

function url_for(string $path): string {
    global $urlHelper;
    return $urlHelper->urlFor($path);
}

function redirect_to(string $location): never {
    global $urlHelper;
    $urlHelper->redirect($location);
}

// -------------------- Database Functions --------------------

function db_connect(string $db_server, string $db_user, string $db_pass, string $db_name): mysqli {
    $connection = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
    confirm_db_connect();
    return $connection;
}

function db_disconnect(?mysqli $connection): void {
    if($connection instanceof mysqli) {
        mysqli_close($connection);
    }
}

function db_escape(mysqli $connection, string $string): string {
    return mysqli_real_escape_string($connection, $string);
}

function confirm_db_connect(): void {
    if(mysqli_connect_errno()) {
        throw new RuntimeException(
            sprintf(
                "Database connection failed: %s (%d)",
                mysqli_connect_error(),
                mysqli_connect_errno()
            )
        );
    }
}

function confirm_result_set($result_set): void {
    if (!$result_set) {
        throw new RuntimeException("Database query failed.");
    }
}

// -------------------- Authentication Functions --------------------

function log_in_admin(array $admin): bool {
    if (!isset($admin['id']) || !isset($admin['username'])) {
        return false;
    }
    
    session_regenerate_id(true);
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['last_login'] = time();
    $_SESSION['username'] = $admin['username'];
    $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
    return true;
}

function log_out_admin(): bool {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
    return true;
}

function admin_is_logged_in(): bool {
    return isset($_SESSION['admin_id']) && 
           $_SESSION['ip_address'] === $_SERVER['REMOTE_ADDR'];
}

function require_login() {
    if(!admin_is_logged_in()) {
        redirect_to(url_for('/staff/admins/login.php'));
    }
}

// -------------------- Validation Functions --------------------

function is_blank(?string $value): bool {
    return !isset($value) || trim($value) === '';
}

function has_presence(?string $value): bool {
    return !is_blank($value);
}

function has_length(string $value, array $options): bool {
    if(isset($options['min']) && !has_length_greater_than($value, $options['min'] - 1)) {
        return false;
    } 
    if(isset($options['max']) && !has_length_less_than($value, $options['max'] + 1)) {
        return false;
    } 
    if(isset($options['exact']) && !has_length_exactly($value, $options['exact'])) {
        return false;
    }
    return true;
}

function has_length_greater_than($value, $min) {
    return strlen($value) > $min;
}

function has_length_less_than($value, $max) {
    return strlen($value) < $max;
}

function has_length_exactly($value, $exact) {
    return strlen($value) == $exact;
}

function has_inclusion_of($value, $set) {
    return in_array($value, $set);
}

function has_exclusion_of($value, $set) {
    return !in_array($value, $set);
}

function has_string($value, $required_string) {
    return strpos($value, $required_string) !== false;
}

function has_valid_email_format(string $value): bool {
    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
}

// -------------------- Utility Functions --------------------

function u($string = ""): string {
    return urlencode($string);
}

function raw_u($string = ""): string {
    return rawurlencode($string);
}

function error_404(): void {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit();
}

function error_500(): void {
    header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
    exit();
}

function is_post_request(): bool {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function is_get_request(): bool {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

function display_errors($errors = []): string {
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

// -------------------- Session Functions --------------------

function get_and_clear_session_message(): ?string {
    if (isset($_SESSION['message']) && $_SESSION['message'] !== '') {
        $msg = $_SESSION['message'];
        unset($_SESSION['message']);
        return $msg;
    }
    return null;
}

function display_session_message(): ?string {
    $msg = get_and_clear_session_message();
    if (!is_blank($msg)) {
        return '<div id="message" class="alert alert-success" role="alert">' . h($msg) . '</div>';
    }
    return null;
}

// -------------------- Query Functions --------------------

// Note: The query functions from query_functions.php have been intentionally 
// left out of this consolidation as they are specific to your database schema 
// and would be better maintained in a separate file or broken into model-specific files.

// You may want to create separate files for specific model queries like:
// - admin_queries.php
// - subject_queries.php
// - page_queries.php
// - contact_queries.php

/**
 * Generate HTML for social media links based on the provided settings.
 *
 * @param Fivetwofive\KrateCMS\Models\KrateSettings $settings
 * @return string
 */
function displaySocialLinks(KrateSettings $settings): string {
    $socialSettings = [
        'Facebook' => 'social_facebook',
        'Instagram' => 'social_instagram',
        'LinkedIn' => 'social_linkedin'
    ];

    $links = array_reduce(
        array_keys($socialSettings),
        function(array $carry, string $platform) use ($settings, $socialSettings): array {
            $url = $settings->getSetting($socialSettings[$platform]);
            if ($url) {
                $carry[] = sprintf(
                    '<li><a href="%s" target="_blank" rel="noopener noreferrer">%s</a></li>',
                    h($url),
                    h($platform)
                );
            }
            return $carry;
        },
        []
    );

    return $links ? sprintf('<ul class="social-links">%s</ul>', implode('', $links)) : '';
}

?> 