<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

require_login();

if (!isset($_GET['id'])) {
    redirect_to(url_for('/staff/admins/index.php'));
}
$id = $_GET['id'];

if (is_post_request()) {
    $result = delete_admin($id);
    $_SESSION['message'] = 'Admin deleted.';
    redirect_to(url_for('/staff/admins/index.php'));
} else {
    $admin = find_admin_by_id($id);
}

?>

<?php include('../../../templates/layouts/header.php'); ?>

<div id="content" class="container py-4">
    <div class="row">
        <div class="col-12">

            <a class="btn btn-info mb-4" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

            <div class="admin delete">
                <h1>Delete Admin</h1>
                <p>Are you sure you want to delete this admin?</p>
                <p class="font-weight-bold"><?php echo h($admin['username']); ?></p>

                <form action="<?php echo url_for('/staff/admins/delete.php?id=' . h(u($admin['id']))); ?>" method="post">
                    <div id="operations">
                        <input type="submit" class="btn btn-danger" name="commit" value="Delete Admin"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../../../templates/layouts/footer.php'); ?>
