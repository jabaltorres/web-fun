<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Middleware;

use Fivetwofive\KrateCMS\Services\UserManager;

class AuthMiddleware
{
    /**
     * Ensures user is logged in, redirects to login if not
     *
     * @param UserManager $userManager
     * @param bool $requireAdmin Whether to check for admin privileges
     * @return void
     */
    public static function requireLogin(UserManager $userManager, bool $requireAdmin = false): void
    {
        if (!$userManager->isLoggedIn()) {
            $_SESSION['error'] = 'Please log in to access this page';
            redirect_to('/users/login.php');
        }

        if ($requireAdmin) {
            $currentUserId = $_SESSION['user_id'] ?? null;
            if (!$currentUserId || !$userManager->isAdmin($currentUserId)) {
                $_SESSION['error'] = 'Unauthorized access. Admin privileges required.';
                redirect_to('/contacts/index.php');
            }
        }
    }
} 