<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

require_login();

$id = $_GET['id'] ?? '1'; // PHP > 7.0
$admin = find_admin_by_id($id);

?>

<?php $page_title = 'Show Admin'; ?>
<?php include('../../../templates/layout/header.php'); ?>

    <div id="content" class="container py-4">
        <div class="row">
            <div class="col-12">
                <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

                <div class="admin show">

                    <h1>Admin: <?php echo h($admin['username']); ?></h1>

                    <div class="actions">
                        <a class="action"
                           href="<?php echo url_for('/staff/admins/edit.php?id=' . h(u($admin['id']))); ?>">Edit</a>
                        <a class="action" href="<?php echo url_for('/staff/admins/delete.php?id=' . h(u($admin['id']))); ?>">Delete</a>
                    </div>

                    <div class="attributes">
                        <dl>
                            <dt>First name</dt>
                            <dd><?php echo h($admin['first_name']); ?></dd>
                        </dl>
                        <dl>
                            <dt>Last name</dt>
                            <dd><?php echo h($admin['last_name']); ?></dd>
                        </dl>
                        <dl>
                            <dt>Email</dt>
                            <dd><?php echo h($admin['email']); ?></dd>
                        </dl>
                        <dl>
                            <dt>Username</dt>
                            <dd><?php echo h($admin['username']); ?></dd>
                        </dl>
                    </div>

                </div>
            </div>
        </div>
    </div>

<?php include('../../../templates/layout/footer.php'); ?>