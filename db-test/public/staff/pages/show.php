<?php require_once ('../../../private/initialize.php');?>

<?php
//    $id = isset($_GET['id']) ? $_GET['id'] : '1';

$id = $_GET['id'] ?? '1'; // PHP > 7.0

?>

<?php $page_title = 'Show Page'; ?>

<?php include (SHARED_PATH . '/staff_header.php');?>

<div id="content">

    <a href="<?php echo url_for('/staff/pages/index.php')?>" class="back-link d-block mb-4">&laquo; Back to Pages List</a>
    <div class="page show">
        <p>Page ID: <?php echo h($id); ?></p>
    </div> <!-- end .subjects .listing -->
</div><!-- end #content -->

<?php include (SHARED_PATH . '/staff_footer.php');?>
