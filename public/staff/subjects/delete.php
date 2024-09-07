<?php

require_once('../../../src/initialize.php');

if (!isset($_GET['id'])) {
    redirect_to(url_for('/staff/subjects/index.php'));
}
$id = $_GET['id'];

if (is_post_request()) {

    $result = delete_subject($id);
    $_SESSION['message'] = 'The subject was deleted successfully.';
    redirect_to(url_for('/staff/subjects/index.php'));

} else {
    $subject = find_subject_by_id($id);
}

?>

<?php $page_title = 'Delete Subject'; ?>
<?php include('../../../templates/layout/header.php'); ?>

<div id="content" class="container py-5">
    <div class="row">
        <div class="col-12">
            <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

            <div class="subject delete">
                <h1>Delete Subject</h1>
                <p>Are you sure you want to delete this subject?</p>
                <p class="item"><?php echo h($subject['menu_name']); ?></p>

                <form action="<?php echo url_for('/staff/subjects/delete.php?id=' . h(u($subject['id']))); ?>"
                      method="post">
                    <div id="operations">
                        <input type="submit" name="commit" value="Delete Subject" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../../../templates/layout/footer.php'); ?>
