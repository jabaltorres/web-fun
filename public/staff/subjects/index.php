<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

$subject_set = find_all_subjects();

?>

<?php $page_title = 'Subjects'; ?>
<?php include('../../../templates/layouts/header.php'); ?>

<div id="content" class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="subjects listing">
                <h1>Subjects</h1>

                <div class="actions mb-4">
                    <a class="action btn btn-primary" href="<?php echo url_for('/staff/subjects/new.php'); ?>">Create New Subject</a>
                </div>

                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>Position</th>
                        <th>Visible</th>
                        <th>Name</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>

                    <?php while ($subject = mysqli_fetch_assoc($subject_set)) { ?>
                        <tr>
                            <td><?php echo h($subject['id']); ?></td>
                            <td><?php echo h($subject['position']); ?></td>
                            <td><?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?></td>
                            <td><?php echo h($subject['menu_name']); ?></td>
                            <td><a class="action"
                                   href="<?php echo url_for('/staff/subjects/show.php?id=' . h(u($subject['id']))); ?>">View</a>
                            </td>
                            <td><a class="action"
                                   href="<?php echo url_for('/staff/subjects/edit.php?id=' . h(u($subject['id']))); ?>">Edit</a>
                            </td>
                            <td><a class="action"
                                   href="<?php echo url_for('/staff/subjects/delete.php?id=' . h(u($subject['id']))); ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

                <?php
                mysqli_free_result($subject_set);
                ?>
            </div>
        </div>
    </div>

</div>

<?php include('../../../templates/layouts/footer.php'); ?>
