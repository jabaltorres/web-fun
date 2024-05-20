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
