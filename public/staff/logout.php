<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/private/initialize.php');

// Todo: udpate Staff log out to reflect contacts log out.
unset($_SESSION['username']);
// or you could use
// $_SESSION['username'] = NULL;

redirect_to(url_for('/staff/login.php'));

?>
