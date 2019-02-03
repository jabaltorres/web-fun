<?php

    require_once ('../../../private/initialize.php');

    if(!isset($_GET['id'])){
        redirect_to(url_for('/staff/pages/index.php'));
    }

    $id = $_GET['id'];

    if(is_post_request()) {
        $result = delete_page($id);
        redirect_to(url_for('/staff/pages/index.php'));
    } else {
        $page = find_page_by_id($id);
    }

?>

<?php $page_title = 'Delete Page'; ?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
    <a href="<?php echo url_for('/staff/pages/index.php'); ?>" class="back-link d-block mb-4">&laquo; Back to Pages List</a>

    <div class="page edit">
        <h1>Delete Page</h1>
        <p>Are you sure you want to delete this page?</p>
        <p class="item"><?php echo h($page['menu_name']); ?></p>

        <div>
            <h4>Content</h4>
            <?php echo h($page['content']); ?>
        </div>

        <form action="<?php echo url_for('/staff/pages/delete.php?id=' . h(u($page['id']))); ?>" method="post">
            <div id="operations">
                <input type="submit" name="commit" value="Delete Page" />
            </div>
        </form>

    </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
