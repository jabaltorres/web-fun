<?php

    require_once ('../../../private/initialize.php');

    if(!isset($_GET['id'])){
        redirect_to(url_for('/staff/subjects/index.php'));
    }

    $id = $_GET['id'];

    if(is_post_request()) {
        $result = delete_subject($id);
        redirect_to(url_for('/staff/subjects/index.php'));
    } else {
        $subject = find_subject_by_id($id);
    }

?>

<?php $page_title = 'Delete Subject'; ?>

<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
    <a href="<?php echo url_for('/staff/subjects/index.php'); ?>" class="back-link d-block mb-4">&laquo; Back to Subjects List</a>

    <div class="subject edit">
        <h1>Delete Subject</h1>
        <p>Are you sure you want to delete this subject?</p>
        <p class="item"><?php echo h($subject['menu_name']); ?></p>

        <form action="<?php echo url_for('/staff/subjects/delete.php?id=' . h(u($id))); ?>" method="post">
            <div id="operations">
                <input type="submit" name="commit" value="Delete Subject" />
            </div>
        </form>

    </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php');?>
