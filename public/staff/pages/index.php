<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

$page_set = find_all_pages();

?>

<?php $page_title = 'Pages'; ?>
<?php include('../../../templates/layouts/header.php'); ?>

<div id="content" class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="pages listing">
                <h1>Pages</h1>

                <a class="btn btn-outline-info my-4 font-weight-bold" href="<?php echo url_for('/staff/pages/new.php'); ?>">Create New Page</a>

                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Position</th>
                        <th>Visible</th>
                        <th>Name</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>

                    <?php while ($page = mysqli_fetch_assoc($page_set)) { ?>
                        <?php $subject = find_subject_by_id($page['subject_id']); ?>
                        <tr>
                            <td><?php echo h($page['id']); ?></td>
                            <td><?php echo h($subject['menu_name']); ?></td>
                            <td><?php echo h($page['position']); ?></td>
                            <td><?php echo $page['visible'] == 1 ? 'true' : 'false'; ?></td>
                            <td><?php echo h($page['menu_name']); ?></td>
                            <td>
                              <a class="action" href="<?php echo url_for('/page.php?id=' . h(u($page['id']))); ?>">Visit</a>
                            </td>
                            <td>
                              <a class="action" href="<?php echo url_for('/staff/pages/show.php?id=' . h(u($page['id']))); ?>">Show</a>
                            </td>
                            <td>
                              <a class="action" href="<?php echo url_for('/staff/pages/edit.php?id=' . h(u($page['id']))); ?>">Edit</a>
                            </td>
                            <td>
                              <a class="action" href="<?php echo url_for('/staff/pages/delete.php?id=' . h(u($page['id']))); ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

                <?php mysqli_free_result($page_set); ?>

            </div>
        </div>
    </div>
</div>

<?php include('../../../templates/layouts/footer.php'); ?>
