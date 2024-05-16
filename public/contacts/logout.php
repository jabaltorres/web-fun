<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../private/initialize.php');

log_out_admin();
redirect_to(url_for('/contacts/login.php'));

?>
