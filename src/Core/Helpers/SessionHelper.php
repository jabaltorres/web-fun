<?php
declare(strict_types=1);

namespace Fivetwofive\KrateCMS\Core\Helpers;

class SessionHelper
{
    /**
     * Get and clear a session message
     *
     * @return string|null
     */
    public static function getAndClearMessage(): ?string
    {
        if (isset($_SESSION['message']) && $_SESSION['message'] !== '') {
            $msg = $_SESSION['message'];
            unset($_SESSION['message']);
            return $msg;
        }
        return null;
    }

    /**
     * Set a session message
     *
     * @param string $message
     * @return void
     */
    public static function setMessage(string $message): void
    {
        $_SESSION['message'] = $message;
    }

    /**
     * Check if user is logged in
     *
     * @return bool
     */
    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Get current user ID
     *
     * @return int|null
     */
    public static function getCurrentUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }
} 