<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/private/initialize.php');
require_login(); // Ensure the user is logged in

require_once($_SERVER['DOCUMENT_ROOT'] . '/private/classes/KrateUserManager.php'); // Ensure this path is correct

// Create database connection
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

use FiveTwoFive\KrateCMS\UserManagement\KrateUserManager;

// Now you can instantiate the User class
$user = new KrateUserManager($conn);

// Fetch all users from the database
$result = $user->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<h2>User List</h2>

<?php if ($result && $result->num_rows > 0): ?>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Username</th>
            <th>Role</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['user_id']) ?></td>
                <td><?= htmlspecialchars($row['first_name']) ?></td>
                <td><?= htmlspecialchars($row['last_name']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= htmlspecialchars($row['role']) ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No users found.</p>
<?php endif; ?>

</body>
</html>
