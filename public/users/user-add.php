<?php

// Turn on PHP error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once($_SERVER['DOCUMENT_ROOT'] . '/private/initialize.php');
require_login();

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create database connection
    $conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME); // Fixed typo from DB_USER to DB_PASS

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password']; // Capture confirm password from form
    $role = $_POST['role'];

    // Validate password and confirm password
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, username, password_hash, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $first_name, $last_name, $email, $username, $hashed_password, $role);

        // Execute the statement
        if ($stmt->execute()) {
            echo "New user added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New User</title>
</head>
<body>
<h2>Add New User</h2>
<form action="user-add.php" method="post">
    <label for="first_name">First Name:</label><br>
    <input type="text" id="first_name" name="first_name" required><br>
    <label for="last_name">Last Name:</label><br>
    <input type="text" id="last_name" name="last_name" required><br>
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>
    <label for="username">Username:</label><br>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br>
    <label for="confirm_password">Confirm Password:</label><br>
    <input type="password" id="confirm_password" name="confirm_password" required><br>
    <label for="role">Role:</label><br>
    <select id="role" name="role" required>
        <option value="Administrator">Administrator</option>
        <option value="Manager">Manager</option>
        <option value="Standard User">Standard User</option>
        <option value="Guest">Guest</option>
    </select><br><br>
    <input type="submit" value="Add User">
</form>
</body>
</html>
