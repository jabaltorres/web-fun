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
<?php include('../../../templates/layout/header.php');?>

<div id="content" class="container">
    <div class="row">
        <div class="col-12">
            <a class="back-link" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back to List</a>

            <div class="page delete">
                <h1>Delete Page</h1>
                <p>Are you sure you want to delete this page?</p>
                <p class="item"><?php echo h($page['menu_name']); ?></p>

                <form action="<?php echo url_for('/staff/pages/delete.php?id=' . h(u($page['id']))); ?>" method="post">
                    <div id="operations">
                        <input type="submit" name="commit" value="Delete Page" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('../../../templates/layout/footer.php'); ?>
