<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

use Fivetwofive\KrateCMS\UserManager;

try {
    $userManager = new UserManager($db);
    $userManager->logout();
} catch (Exception $e) {
    error_log("Logout error: " . $e->getMessage());
}

header("Location: login.php");
exit();
?>