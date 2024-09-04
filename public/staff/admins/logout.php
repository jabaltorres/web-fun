<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

    log_out_admin();
    redirect_to(url_for('/staff/admins/login.php'));
?>
