<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/classes/KrateUserManager.php');

use Fivetwofive\KrateCMS\KrateUserManager;

// Instantiate the user manager
$userManager = new KrateUserManager($db);

// Use the logout function
$userManager->logout();

// Redirect to the login page or another appropriate page
header("Location: login.php");
exit();
?>