<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../private/initialize.php');
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


include(SHARED_PATH . '/site-header.php');
include(INCLUDES_PATH . '/navigation.php');

?>


<div class="container">
    <h2>Add New User</h2>
    <section>
        <form action="user-add.php" method="post">
            <fieldset class="mb-4">
                <legend>Personal Information</legend>
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </fieldset>
            <fieldset class="mb-4">
                <legend>Account Details</legend>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </fieldset>
            <fieldset class="mb-4">
                <legend>User Role</legend>
                <label for="role">Role:</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="Administrator">Administrator</option>
                    <option value="Manager">Manager</option>
                    <option value="Standard User">Standard User</option>
                    <option value="Guest" selected>Guest</option>
                </select>
            </fieldset>
            <input type="submit" class="btn btn-primary" value="Add User">
        </form>
    </section>
</div>

<?php include_once(SHARED_PATH . '/site-footer.php'); ?>