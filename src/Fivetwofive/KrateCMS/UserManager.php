<?php

declare(strict_types=1);

namespace Fivetwofive\KrateCMS;

use mysqli;
use mysqli_result;
use mysqli_stmt;
use Postmark\PostmarkClient;
use InvalidArgumentException;
use Exception;

/**
 * Class UserManager
 * 
 * Handles user authentication, registration, and management operations.
 */
class UserManager
{
    /** @var array<string> Admin email addresses for notifications */
    private const ADMIN_EMAILS = [
        'jabal@fivetwofive.com',
        'jabaltorres@gmail.com'
    ];

    /**
     * Valid user roles for the system.
     * 
     * - Administrator: Full system access
     * - Manager: Can manage content and users
     * - Standard User: Standard authenticated user access
     * - Guest: Limited access
     * 
     * @var array<string>
     */
    public const VALID_ROLES = [
        'Administrator',
        'Manager',
        'Standard User',
        'Guest'
    ];

    /** @var mysqli */
    private $db;

    /** @var PostmarkClient|null */
    private $postmarkClient;

    /**
     * Constructor to initialize the UserManager.
     *
     * @param mysqli $dbConnection Database connection object
     * @param string|null $postmarkApiToken Optional Postmark API token
     */
    public function __construct(mysqli $dbConnection, ?string $postmarkApiToken = null)
    {
        $this->db = $dbConnection;
        if ($postmarkApiToken) {
            $this->postmarkClient = new PostmarkClient($postmarkApiToken);
        }
    }

    /**
     * Authenticates a user with username and password.
     *
     * @param string $username User's username
     * @param string $password User's password
     * @return array<string, mixed>|null Returns user data array if successful
     * @throws Exception If database query fails
     */
    public function login(string $username, string $password): ?array
    {
        $stmt = $this->prepareStatement(
            "SELECT user_id, password_hash, first_name, email, role 
             FROM users 
             WHERE username = ?",
            "s",
            $username
        );

        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $hashed_password, $first_name, $email, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $this->sendLoginNotificationToAdmins($first_name, $email);

                return [
                    'user_id' => $user_id,
                    'username' => $username,
                    'first_name' => $first_name,
                    'email' => $email,
                    'role' => $role
                ];
            }
        }

        return null;
    }

    /**
     * Sends an email notification to admins when a user logs in.
     *
     * @param string $first_name User's first name
     * @param string $email User's email
     */
    private function sendLoginNotificationToAdmins(string $first_name, string $email): void
    {
        if (!$this->postmarkClient) {
            error_log("Postmark client not initialized - skipping login notification");
            return;
        }

        $subject = "User Login Notification";
        $htmlBody = "<strong>User:</strong> {$first_name} ({$email}) just logged in.";
        $textBody = "User: {$first_name} ({$email}) just logged in.";

        foreach (self::ADMIN_EMAILS as $toEmail) {
            try {
                $this->postmarkClient->sendEmail(
                    "jabal@fivetwofive.com",
                    $toEmail,
                    $subject,
                    $htmlBody,
                    $textBody
                );
                error_log("Login notification sent to: " . $toEmail);
            } catch (Exception $e) {
                error_log("Failed to send login notification: " . $e->getMessage());
            }
        }
    }

    /**
     * Registers a new user after validation.
     *
     * @param array<string, string> $userData User registration data
     * @return bool Success status
     * @throws InvalidArgumentException If validation fails
     * @throws Exception If registration fails
     */
    public function registerUser(array $userData): bool
    {
        $this->validateRegistrationData($userData);

        return $this->register(
            $userData['username'],
            $userData['password'],
            $userData['email'],
            $userData['first_name'],
            $userData['last_name'],
            $userData['role']
        );
    }

    /**
     * Validates user registration data.
     *
     * @param array<string, string> $userData
     * @throws InvalidArgumentException
     */
    private function validateRegistrationData(array $userData): void
    {
        $requiredFields = ['username', 'password', 'confirm_password', 'email', 'first_name', 'last_name', 'role'];
        
        foreach ($requiredFields as $field) {
            if (empty($userData[$field])) {
                throw new InvalidArgumentException("Missing required field: {$field}");
            }
        }

        if ($userData['password'] !== $userData['confirm_password']) {
            throw new InvalidArgumentException("Passwords do not match");
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email address");
        }

        if (!in_array($userData['role'], self::VALID_ROLES, true)) {
            throw new InvalidArgumentException(
                sprintf("Invalid role. Must be one of: %s", implode(', ', self::VALID_ROLES))
            );
        }

        if ($this->doesUserExist($userData['username'], $userData['email'])) {
            throw new InvalidArgumentException("Username or email already exists");
        }
    }

    /**
     * Changes a user's password.
     *
     * @param int $userId
     * @param string $currentPassword
     * @param string $newPassword
     * @return bool Success status
     * @throws Exception If password update fails
     */
    public function changePassword(int $userId, string $currentPassword, string $newPassword): bool
    {
        $stmt = $this->prepareStatement(
            "SELECT password_hash FROM users WHERE user_id = ?",
            "i",
            $userId
        );
        
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        
        if (!$stmt->fetch() || !password_verify($currentPassword, $hashedPassword)) {
            return false;
        }
        
        $stmt->free_result();

        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt = $this->prepareStatement(
            "UPDATE users SET password_hash = ? WHERE user_id = ?",
            "si",
            $newHashedPassword,
            $userId
        );

        return $updateStmt->execute();
    }

    /**
     * Redirects user to login page if not logged in.
     *
     * @return void
     */
    public function checkLoggedIn(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /users/login.php");
            exit;
        }
    }

    /**
     * Check if the user is currently logged in.
     *
     * @return bool Returns true if the user is logged in
     */
    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * Checks if the given user is an Administrator.
     *
     * @param int $userId The ID of the user to check
     * @return bool Returns true if the user is an Administrator
     * @throws Exception If database query fails
     */
    public function isAdmin(int $userId): bool 
    {
        $stmt = $this->prepareStatement(
            "SELECT role FROM users WHERE user_id = ?",
            "i",
            $userId
        );
        
        $stmt->execute();
        $stmt->bind_result($role);
        $stmt->fetch();
        $stmt->close();
        
        return $role === 'Administrator';
    }

    /**
     * Fetches all users from the database.
     *
     * @return mysqli_result|null Result set containing all users
     * @throws Exception If database query fails
     */
    public function getAllUsers(): ?mysqli_result
    {
        $stmt = $this->prepareStatement(
            "SELECT user_id, first_name, last_name, email, username, role 
             FROM users 
             ORDER BY user_id ASC"
        );
        
        if ($stmt->execute()) {
            return $stmt->get_result();
        }
        
        return null;
    }

    /**
     * Ends the session for the current user.
     *
     * @return void
     */
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            // Clear the session cookie
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

            // Destroy the session
            session_unset();
            session_destroy();
        }
    }

    /**
     * Registers a new user in the database.
     *
     * @param string $username Username
     * @param string $password Password
     * @param string $email Email address
     * @param string $first_name First name
     * @param string $last_name Last name
     * @param string $role User role
     * @return bool Returns true if registration is successful
     * @throws Exception If database query fails
     */
    private function register(
        string $username,
        string $password,
        string $email,
        string $first_name,
        string $last_name,
        string $role
    ): bool {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->prepareStatement(
            "INSERT INTO users (username, password_hash, email, first_name, last_name, role) 
             VALUES (?, ?, ?, ?, ?, ?)",
            "ssssss",
            $username,
            $hashed_password,
            $email,
            $first_name,
            $last_name,
            $role
        );

        return $stmt->execute();
    }

    /**
     * Prepares an SQL statement with parameters.
     *
     * @param string $query SQL query
     * @param string $types Parameter types
     * @param mixed ...$params Query parameters
     * @return mysqli_stmt
     * @throws Exception If statement preparation fails
     */
    private function prepareStatement(string $query, string $types = "", ...$params): mysqli_stmt
    {
        $stmt = $this->db->prepare($query);
        if ($stmt === false) {
            throw new Exception("Failed to prepare statement: " . $this->db->error);
        }

        if ($types && $params) {
            $stmt->bind_param($types, ...$params);
        }

        return $stmt;
    }

    /**
     * Updates a user's profile information including role.
     *
     * @param int $userId
     * @param array<string, string> $profileData
     * @return bool
     * @throws Exception If update fails
     */
    public function updateUserProfile(int $userId, array $profileData): bool
    {
        // Validate role if provided
        if (isset($profileData['role']) && !in_array($profileData['role'], self::VALID_ROLES, true)) {
            throw new InvalidArgumentException(
                sprintf("Invalid role. Must be one of: %s", implode(', ', self::VALID_ROLES))
            );
        }

        $stmt = $this->prepareStatement(
            "UPDATE users 
             SET first_name = ?, last_name = ?, email = ?, role = ? 
             WHERE user_id = ?",
            "ssssi",
            $profileData['first_name'],
            $profileData['last_name'],
            $profileData['email'],
            $profileData['role'] ?? 'Standard User',  // Default to 'Standard User' instead of 'User'
            $userId
        );

        return $stmt->execute();
    }

    /**
     * Checks if a user exists by username or email.
     *
     * @param string $username Username
     * @param string $email Email address
     * @return bool Returns true if user exists
     * @throws Exception If database query fails
     */
    public function doesUserExist(string $username, string $email): bool
    {
        $stmt = $this->prepareStatement(
            "SELECT username FROM users WHERE username = ? OR email = ?",
            "ss",
            $username,
            $email
        );
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    /**
     * Retrieves detailed information for a specific user.
     *
     * @param int $user_id User's ID
     * @return array|null Returns user data array if found
     * @throws Exception If database query fails
     */
    public function getUserDetails(int $user_id): ?array
    {
        $stmt = $this->prepareStatement(
            "SELECT username, email, first_name, last_name, role 
             FROM users 
             WHERE user_id = ?",
            "i",
            $user_id
        );
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_assoc() ?: null;
        }
        
        return null;
    }

    /**
     * Allows an admin to change a user's password without requiring the current password.
     *
     * @param int $userId
     * @param string $newPassword
     * @return bool
     * @throws Exception If password update fails
     */
    public function adminChangeUserPassword(int $userId, string $newPassword): bool
    {
        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->prepareStatement(
            "UPDATE users SET password_hash = ? WHERE user_id = ?",
            "si",
            $newHashedPassword,
            $userId
        );

        return $stmt->execute();
    }

    /**
     * Fetches filtered users from the database.
     *
     * @param string $search Search term for name, email, or username
     * @param string $roleFilter Role to filter by
     * @param string $sortField Field to sort by
     * @param string $sortOrder Sort direction (ASC or DESC)
     * @return mysqli_result|null Result set containing filtered users
     * @throws Exception If database query fails
     */
    public function getFilteredUsers(
        string $search = '', 
        string $roleFilter = '', 
        string $sortField = 'user_id',
        string $sortOrder = 'ASC'
    ): ?mysqli_result {
        $conditions = [];
        $params = [];
        $types = '';

        if ($search) {
            $searchTerm = "%$search%";
            $conditions[] = "(first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR username LIKE ?)";
            $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
            $types .= 'ssss';
        }

        if ($roleFilter) {
            $conditions[] = "role = ?";
            $params[] = $roleFilter;
            $types .= 's';
        }

        // Validate sort field to prevent SQL injection
        $validSortFields = ['user_id', 'first_name', 'last_name', 'email', 'username', 'role'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'user_id';
        }

        // Validate sort order
        $sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';

        $sql = "SELECT user_id, first_name, last_name, email, username, role FROM users";
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
        $sql .= " ORDER BY {$sortField} {$sortOrder}";

        $stmt = $this->prepareStatement($sql, $types, ...$params);
        
        if ($stmt->execute()) {
            return $stmt->get_result();
        }
        
        return null;
    }

    /**
     * Retrieves the details of the currently logged-in user.
     *
     * @return array|null Returns user data array if found, null otherwise
     * @throws Exception If database query fails
     */
    public function getCurrentUserDetails(): ?array
    {
        if (!isset($_SESSION['user_id'])) {
            return null; // User is not logged in
        }

        return $this->getUserDetails((int)$_SESSION['user_id']);
    }
} 