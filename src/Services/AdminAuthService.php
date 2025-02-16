<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Services;

class AdminAuthService
{
    public function login(array $admin): bool
    {
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

    public function logout(): bool
    {
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

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['admin_id']) && 
               $_SESSION['ip_address'] === $_SERVER['REMOTE_ADDR'];
    }

    public function requireLogin(string $loginPath): void
    {
        if (!$this->isLoggedIn()) {
            header("Location: " . $loginPath);
            exit;
        }
    }
} 