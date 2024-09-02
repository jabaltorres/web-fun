<?php

namespace Fivetwofive\KrateCMS;

use mysqli;
use mysqli_result;
use mysqli_stmt;

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
        $stmt = $this->prepareStatement("SELECT user_id, password_hash, first_name FROM users WHERE username = ?", "s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $hashed_password, $first_name);
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                return ['user_id' => $user_id, 'username' => $username, 'first_name' => $first_name];
            }
        }
        return null;
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

    // User Management

    /**
     * Registers a new user in the database.
     *
     * @param string $username Username
     * @param string $password Password
     * @param string $email Email address
     * @param string $first_name First name
     * @param string $last_name Last name
     * @return bool Returns true if registration is successful, false otherwise
     */
    public function register(string $username, string $password, string $email, string $first_name, string $last_name): bool
    {
        if ($this->doesUserExist($username, $email)) {
            return false;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->prepareStatement("INSERT INTO users (username, password_hash, email, first_name, last_name) VALUES (?, ?, ?, ?, ?)", "sssss", $username, $hashed_password, $email, $first_name, $last_name);
        return $stmt->execute();
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
        $stmt = $this->prepareStatement("SELECT username, email, first_name, last_name FROM users WHERE user_id = ?", "i", $user_id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            return $result->fetch_assoc() ?: null;
        }
        return null;
    }

    /**
     * Checks if the given user is an Administrator.
     *
     * This method verifies the role of a user by querying the database
     * for the user's role based on their user ID. It then checks if the
     * role is 'Administrator'.
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
     * This method first fetches the current password hash for the user
     * from the database. It then verifies that the provided current password
     * matches the stored hash. If the verification is successful, the new
     * password is hashed and updated in the database.
     *
     * Note: The result from the first query is freed to ensure that the
     * MySQL connection is ready for the subsequent update query.
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
