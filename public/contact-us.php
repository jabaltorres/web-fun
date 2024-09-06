<?php
// Require initialization file
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

?>

<?php include('../templates/layout/header.php'); ?>

    <div id="main" class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <?php include('../templates/components/nav_public.php'); ?>
                </div>
                <div class="col-md-9 ">
                    <div class="page-content">
                        <?php include('../templates/pages/static_contactus.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('../templates/layout/footer.php'); ?>