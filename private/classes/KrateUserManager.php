<?php

namespace FiveTwoFive\KrateCMS\UserManagement;

class KrateUserManager {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function login($username, $password) {
        // Prepare and execute the SQL query to find the user by username
        $stmt = $this->db->prepare("SELECT user_id, password_hash FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($user_id, $hashed_password);
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                // Authentication successful
                return ['user_id' => $user_id, 'username' => $username];
            } else {
                // Authentication failed
                return false;
            }
        } else {
            // User not found
            return false;
        }
    }

    public function register($username, $password, $email, $first_name, $last_name) {
        // Check if username or email already exists
        if ($this->doesUserExist($username, $email)) {
            return false;  // User already exists
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute the SQL query to add the new user
        $stmt = $this->db->prepare("INSERT INTO users (username, password_hash, email, first_name, last_name) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $hashed_password, $email, $first_name, $last_name);
        $success = $stmt->execute();

        return $success;
    }

    public function doesUserExist($username, $email) {
        $stmt = $this->db->prepare("SELECT username FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function getUserDetails($user_id) {
        $stmt = $this->db->prepare("SELECT username, email, first_name, last_name FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }

    public function getAllUsers() {
        $stmt = $this->db->prepare("SELECT user_id, first_name, last_name, email, username, role FROM users");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

}
