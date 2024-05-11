<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/private/initialize.php');

$page_title = 'Staff Menu';
include(SHARED_PATH . '/staff_header.php');
?>

<div class="container">
    <div id="content">
        <div id="main-menu">
            <h2>Main Menu</h2>
            <ul>
                <li><a href="<?php echo url_for('/staff/subjects/index.php'); ?>">Subjects</a></li>
                <li><a href="<?php echo url_for('/staff/pages/index.php'); ?>">Pages</a></li>
            </ul>
        </div>
    </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
