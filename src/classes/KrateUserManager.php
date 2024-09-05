<?php

namespace Fivetwofive\KrateCMS;

use mysqli;
use mysqli_result;
use mysqli_stmt;
use Postmark\PostmarkClient;

class KrateUserManager
{
    private mysqli $db;

    /**
     * Constructor to initialize the KrateUserManager with a database connection.
     *
     * @param mysqli $dbConnection Database connection object
     */
    public function __construct(mysqli $dbConnection)
    {
        $this->db = $dbConnection;
    }

    // Session and Authentication Management

    /**
     * Authenticates a user with username and password.
     *
     * @param string $username User's username
     * @param string $password User's password
     * @return array|null Returns user data array if successful, null otherwise
     */
    public function login(string $username, string $password): ?array
    {
        $stmt = $this->prepareStatement("SELECT user_id, password_hash, first_name, email FROM users WHERE username = ?", "s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $hashed_password, $first_name, $email);
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                // Send a login notification email to admins
                $this->sendLoginNotificationToAdmins($first_name, $email);

                return ['user_id' => $user_id, 'username' => $username, 'first_name' => $first_name, 'email' => $email];
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
        global $postmarkApiToken;

        // Ensure the Postmark API token is available
        if (!isset($postmarkApiToken) || empty($postmarkApiToken)) {
            error_log("Postmark API Token is missing or not set.");
            return;
        }

        // Create a new instance of the Postmark client
        $client = new PostmarkClient($postmarkApiToken);

        // Define admin email addresses
        $adminEmails = ["jabal@fivetwofive.com", "jabaltorres@gmail.com"];

        // Subject of the email
        $subject = "User Login Notification";

        // HTML body of the email
        $htmlBody = "<strong>User:</strong> {$first_name} ({$email}) just logged in.";

        // Text body of the email (for clients that don't support HTML)
        $textBody = "User: {$first_name} ({$email}) just logged in.";

        foreach ($adminEmails as $toEmail) {
            try {
                // Send the email
                $client->sendEmail(
                    "jabal@fivetwofive.com",// Sender's email
                    $toEmail,                    // Admin's email
                    $subject,                    // Subject
                    $htmlBody,                   // HTML Body
                    $textBody                    // Text Body
                );
                error_log("Login notification sent to: " . $toEmail);
            } catch (\Exception $e) {
                // Handle the error if email fails to send
                error_log("Failed to send login notification: " . $e->getMessage());
            }
        }
    }

    /**
     * Ends the session for the current user, ensuring all session data is cleared.
     */
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            session_unset();
            session_destroy();
        }
    }

    /**
     * Redirects user to login page if not logged in.
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
     * @return bool Returns true if the user is logged in (i.e., `user_id` exists in session), false otherwise.
     */
    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    // User Management

    /**
     * Registers a new user in the database.
     *
     * @param string $username Username
     * @param string $password Password
     * @param string $email Email address
     * @param string $first_name First name
     * @param string $last_name Last name
     * @param string $role User role (e.g., 'Administrator', 'Manager', etc.)
     * @return bool Returns true if registration is successful, false otherwise
     */
    public function register(string $username, string $password, string $email, string $first_name, string $last_name, string $role): bool
    {
        if ($this->doesUserExist($username, $email)) {
            return false;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->prepareStatement("INSERT INTO users (username, password_hash, email, first_name, last_name, role) VALUES (?, ?, ?, ?, ?, ?)", "ssssss", $username, $hashed_password, $email, $first_name, $last_name, $role);
        return $stmt->execute();
    }

    /**
     * Validates user data before registration.
     *
     * @param string $username Username
     * @param string $password Password
     * @param string $confirm_password Confirmation of the password
     * @param string $email Email address
     * @param string $first_name First name
     * @param string $last_name Last name
     * @return string|null Returns an error message if validation fails, null if validation passes
     */
    public function validateUserData(string $username, string $password, string $confirm_password, string $email, string $first_name, string $last_name): ?string
    {
        if ($password !== $confirm_password) {
            return "Passwords do not match.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email address.";
        }

        if ($this->doesUserExist($username, $email)) {
            return "Error: Unable to add user. User might already exist.";
        }

        return null;
    }

    /**
     * Registers a new user in the database after validating their data.
     *
     * @param array $userData An associative array containing the user's details
     * @return bool Returns true if registration is successful, false otherwise
     * @throws \Exception If validation fails, an exception is thrown with the validation error message
     */
    public function registerUser(array $userData): bool
    {
        $error_message = $this->validateUserData(
            $userData['username'],
            $userData['password'],
            $userData['confirm_password'],
            $userData['email'],
            $userData['first_name'],
            $userData['last_name']
        );

        if ($error_message) {
            throw new \Exception($error_message);
        }

        return $this->register(
            $userData['username'],
            $userData['password'],
            $userData['email'],
            $userData['first_name'],
            $userData['last_name'],
            $userData['role'] // Ensure the role is passed and saved correctly
        );
    }

    /**
     * Checks if a user exists by username or email.
     *
     * @param string $username Username
     * @param string $email Email address
     * @return bool Returns true if user exists, false otherwise
     */
    public function doesUserExist(string $username, string $email): bool
    {
        $stmt = $this->prepareStatement("SELECT username FROM users WHERE username = ? OR email = ?", "ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    /**
     * Retrieves detailed information for a specific user.
     *
     * @param int $user_id User's ID
     * @return array|null Returns user data array if found, null otherwise
     */
    public function getUserDetails(int $user_id): ?array
    {
        $stmt = $this->prepareStatement("SELECT username, email, first_name, last_name, role FROM users WHERE user_id = ?", "i", $user_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_assoc() ?: null;
        }
        return null;
    }

    /**
     * Checks if the given user is an Administrator.
     *
     * @param int $userId The ID of the user to check.
     * @return bool Returns true if the user is an Administrator, otherwise false.
     */
    public function isAdmin($userId): bool {
        $stmt = $this->prepareStatement("SELECT role FROM users WHERE user_id = ?", "i", $userId);
        $stmt->execute();
        $stmt->bind_result($role);
        $stmt->fetch();
        return $role === 'Administrator';
    }

    /**
     * Fetches all users from the database.
     *
     * @return mysqli_result|null Result set containing all users
     */
    public function getAllUsers(): ?mysqli_result
    {
        $stmt = $this->prepareStatement("SELECT user_id, first_name, last_name, email, username, role FROM users");
        if ($stmt->execute()) {
            return $stmt->get_result();
        }
        return null;
    }

    /**
     * Changes the user's password after verifying the current password.
     *
     * @param int $userId The ID of the user whose password is being changed.
     * @param string $currentPassword The current password provided by the user for verification.
     * @param string $newPassword The new password that the user wants to set.
     * @return bool Returns true if the password was successfully updated, otherwise false.
     */
    public function changePassword(int $userId, string $currentPassword, string $newPassword): bool
    {
        // Fetch the user's current password hash
        $stmt = $this->prepareStatement("SELECT password_hash FROM users WHERE user_id = ?", "i", $userId);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        // Free the result to allow the next query
        $stmt->free_result();

        // Verify the current password
        if (password_verify($currentPassword, $hashed_password)) {
            // Hash the new password
            $new_hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_stmt = $this->prepareStatement("UPDATE users SET password_hash = ? WHERE user_id = ?", "si", $new_hashed_password, $userId);
            return $update_stmt->execute();
        }

        return false; // Current password did not match
    }

    // Helper Methods

    /**
     * Helper function to prepare SQL statements.
     * @param string $query SQL query
     * @param string $types Types of the parameters
     * @param mixed ...$params Parameters for the query
     * @return mysqli_stmt Prepared statement
     */
    private function prepareStatement(string $query, string $types = "", ...$params): mysqli_stmt
    {
        $stmt = $this->db->prepare($query);
        if ($stmt === false) {
            throw new \Exception("Failed to prepare statement: " . $this->db->error);
        }
        if ($types && $params) {
            $stmt->bind_param($types, ...$params);
        }
        return $stmt;
    }
}