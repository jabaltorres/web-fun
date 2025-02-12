<?php require_once('../../../src/initialize.php'); ?>

<?php
// $id = isset($_GET['id']) ? $_GET['id'] : '1';
$id = $_GET['id'] ?? '1'; // PHP > 7.0

$subject = find_subject_by_id($id);

?>

<?php $page_title = 'Show Subject'; ?>
<?php include('../../../templates/layouts/header.php'); ?>

<div id="content" class="container py-5">
    <div class="row">
        <div class="col-12">
            <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

            <div class="subject show">

                <h1>Subject: <?php echo h($subject['menu_name']); ?></h1>

                <div class="attributes">
                    <dl>
                        <dt>Menu Name</dt>
                        <dd><?php echo h($subject['menu_name']); ?></dd>
                    </dl>
                    <dl>
                        <dt>Position</dt>
                        <dd><?php echo h($subject['position']); ?></dd>
                    </dl>
                    <dl>
                        <dt>Visible</dt>
                        <dd><?php echo $subject['visible'] == '1' ? 'true' : 'false'; ?></dd>
                    </dl>
                </div>

            </div>
        </div>
    </div>
</div>
<?php include('../../../templates/layouts/footer.php'); ?>
