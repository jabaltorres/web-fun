<?php

require_once('../../../src/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/pages/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  $result = delete_page($id);
  $_SESSION['message'] = 'The page was deleted successfully.';
  redirect_to(url_for('/staff/pages/index.php'));

} else {
  $page = find_page_by_id($id);
}

?>

<?php $page_title = 'Delete Page'; ?>
<?php include('../../../templates/layouts/header.php');?>

<div id="content" class="container py-5">
    <div class="row">
        <div class="col-12">
            <a class="btn btn-outline-info my-4 font-weight-bold" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back to List</a>

            <div class="page delete">
                <h1>Delete Page</h1>
                <p>Are you sure you want to delete this page?</p>
                <p class="item"><?php echo h($page['menu_name']); ?></p>

                <form action="<?php echo url_for('/staff/pages/delete.php?id=' . h(u($page['id']))); ?>" method="post">
                    <div id="operations">
                        <input type="submit" name="commit" value="Delete Page" class="btn btn-danger"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../../../templates/layouts/footer.php'); ?>
