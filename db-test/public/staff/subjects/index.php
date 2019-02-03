<?php require_once ('../../../private/initialize.php'); ?>

<?php
    $subject_set = find_all_subjects();
?>

<?php $page_title = 'Subjects'; ?>

<?php include (SHARED_PATH . '/staff_header.php'); ?>

    <div id="content">
        <div class="subjects listing">
            <h1>Subjects</h1>

            <div class="actions mb-4">
                <a href="<?php echo url_for('/staff/subjects/new.php'); ?>" class="action">Create New Subject</a>
            </div>

            <table class="table list">
                <tr>
                    <th>ID</th>
                    <th>Position</th>
                    <th>Visible</th>
                    <th>Name</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>

                <?php while ($subject = mysqli_fetch_assoc($subject_set)): ?>
                    <tr>
                        <td><?php echo h($subject['id']); ?></td>
                        <td><?php echo h($subject['position']); ?></td>
                        <td><?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?></td>
                        <td><?php echo h($subject['menu_name']); ?></td>

                        <?php /* URL encoding and html escaping the page id */ ?>
                        <td><a class="action" href="<?php echo url_for('/staff/subjects/show.php?id=' . h(u($subject['id']))); ?>">View</a></td>
                        <td><a class="action" href="<?php echo url_for('/staff/subjects/edit.php?id=' . h(u($subject['id']))); ?>">Edit</a></td>
                        <td><a class="action" href="<?php echo url_for('/staff/subjects/delete.php?id=' . h(u($subject['id']))); ?>">Delete</a></td>
                    </tr>
                <?php endwhile; ?>

            </table>

            <?php mysqli_free_result($subject_set); ?>

        </div> <!-- end .subjects .listing -->
    </div><!-- end #content -->

<?php include (SHARED_PATH . '/staff_footer.php'); ?>