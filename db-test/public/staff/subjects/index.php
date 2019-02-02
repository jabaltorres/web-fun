<?php require_once ('../../../private/initialize.php');?>

<?php
    $subjects = [
        ['id' => '1', 'position' => '1', 'visible' => '1', 'menu_name' => 'About Globe Bank'],
        ['id' => '2', 'position' => '2', 'visible' => '1', 'menu_name' => 'Consumer'],
        ['id' => '3', 'position' => '3', 'visible' => '1', 'menu_name' => 'Business'],
        ['id' => '4', 'position' => '4', 'visible' => '1', 'menu_name' => 'Commercial'],
    ];
?>

<?php $page_title = 'Subjects'; ?>

<?php include (SHARED_PATH . '/staff_header.php');?>

    <div id="content">
        <div class="subjects listing">
            <h1>Subjects</h1>

            <div class="actions">
                <a href="<?php echo url_for('/staff/subjects/new.php');?>" class="action">Create New Subject</a>
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

                <?php foreach ($subjects as $subject): ?>
                    <tr>
                        <td><?php echo h($subject['id']); ?></td>
                        <td><?php echo h($subject['position']); ?></td>
                        <td><?php echo $subject['visible'] == 1 ? 'true' : 'false'; ?></td>
                        <td><?php echo h($subject['menu_name']); ?></td>

                        <?php /* URL encoding and html escaping the page id */ ?>
                        <td><a class="action" href="<?php echo url_for('/staff/subjects/show.php?id=' . h(u($subject['id']))); ?>">View</a></td>

                        <td><a class="action" href="<?php echo url_for('/staff/subjects/edit.php?id=' . h(u($subject['id']))); ?>">Edit</a></td>
                        <td><a class="action" href="#">Delete</a></td>
                    </tr>
                <?php endforeach; ?>

            </table>
        </div> <!-- end .subjects .listing -->
    </div><!-- end #content -->

<?php include (SHARED_PATH . '/staff_footer.php');?>