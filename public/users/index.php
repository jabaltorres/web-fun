<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/private/initialize.php');
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

// Check if user is logged in
$loggedIn = isset($_SESSION['user_id']);
?>

<?php include($_SERVER['DOCUMENT_ROOT'] . '/private/shared/users_header.php'); ?>
<div class="container">
    <h1>User List</h1>

    <section class="user-content">
        <?php if ($loggedIn): ?>
            <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>! Here is the exclusive content for logged-in users.</p>
            <form method="post" action="logout.php"> <!-- Point this form to your logout script -->
                <input type="submit" value="Log Out" class="btn btn-primary">
            </form>
        <?php else: ?>
            <p>Please <a href="login.php">log in</a> to view this section.</p>
        <?php endif; ?>
    </section>

    <?php if ($result && $result->num_rows > 0): ?>
        <h3>All Users</h3>
        <table class="table table-striped">
            <thead class="thead-dark">
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
</div>


<?php include($_SERVER['DOCUMENT_ROOT'] . '/private/shared/users_footer.php'); ?>