<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

require_login();

$admin_set = find_all_admins();

?>

<?php $page_title = 'Admins'; ?>
<?php include('../../../templates/layout/header.php'); ?>

<div id="content" class="container">
    <div class="row">
        <div class="col-12">
            <div class="admins listing">
                <h1>Admins</h1>

                <div class="actions">
                    <a class="action" href="<?php echo url_for('/staff/admins/new.php'); ?>">Create New Admin</a>
                </div>

                <table class="table table-striped">
                    <tr>
                        <th>ID</th>
                        <th>First</th>
                        <th>Last</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                    </tr>

                    <?php while ($admin = mysqli_fetch_assoc($admin_set)) { ?>
                        <tr>
                            <td><?php echo h($admin['id']); ?></td>
                            <td><?php echo h($admin['first_name']); ?></td>
                            <td><?php echo h($admin['last_name']); ?></td>
                            <td><?php echo h($admin['email']); ?></td>
                            <td><?php echo h($admin['username']); ?></td>
                            <td><a class="action"
                                   href="<?php echo url_for('/staff/admins/show.php?id=' . h(u($admin['id']))); ?>">View</a>
                            </td>
                            <td><a class="action"
                                   href="<?php echo url_for('/staff/admins/edit.php?id=' . h(u($admin['id']))); ?>">Edit</a>
                            </td>
                            <td><a class="action"
                                   href="<?php echo url_for('/staff/admins/delete.php?id=' . h(u($admin['id']))); ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>

                <?php
                mysqli_free_result($admin_set);
                ?>
            </div>
        </div>
    </div>
</div>

<?php include('../../../templates/layout/footer.php'); ?>
