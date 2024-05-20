<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/classes/KrateUserManager.php');

use Fivetwofive\KrateCMS\KrateUserManager;

// Create a database connection, necessary to instantiate KrateUserManager
$conn = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Instantiate the user manager
$userManager = new KrateUserManager($conn);

// Use the logout function
$userManager->logout();

// Redirect to the login page or another appropriate page
header("Location: login.php");
exit();
?>