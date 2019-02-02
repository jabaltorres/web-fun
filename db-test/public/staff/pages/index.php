<?php require_once ('../../../private/initialize.php');?>

<?php
    $pages = [
        ['id' => '1', 'position' => '1', 'visible' => '1', 'menu_name' => 'Globe Bank'],
        ['id' => '2', 'position' => '2', 'visible' => '1', 'menu_name' => 'History'],
        ['id' => '3', 'position' => '3', 'visible' => '1', 'menu_name' => 'Leadership'],
        ['id' => '4', 'position' => '4', 'visible' => '1', 'menu_name' => 'Contact Us'],
    ];
?>

<?php $page_title = 'Pages'; ?>

<?php include (SHARED_PATH . '/staff_header.php');?>

    <div id="content">
        <div class="pages listing">
            <h1>Pages</h1>

            <div class="actions">
                <a href="<?php echo url_for('/staff/pages/new.php'); ?>" class="action">Create New Page</a>
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

                <?php foreach ($pages as $page): ?>
                    <tr>
                        <td><?php echo h($page['id']); ?></td>
                        <td><?php echo h($page['position']); ?></td>
                        <td><?php echo $page['visible'] == 1 ? 'true' : 'false'; ?></td>
                        <td><?php echo h($page['menu_name']); ?></td>

                        <?php /* URL encoding and html escaping the page id */ ?>
                        <td><a class="action" href="<?php echo url_for('/staff/pages/show.php?id=' . h(u($page['id']))); ?>">View</a></td>

                        <td><a class="action" href="<?php echo url_for('/staff/pages/edit.php?id=' . h(u($page['id']))); ?>">Edit</a></td>
                        <td><a class="action" href="#">Delete</a></td>
                    </tr>
                <?php endforeach; ?>

            </table>

        </div> <!-- end .subjects .listing -->
    </div><!-- end #content -->

<?php include (SHARED_PATH . '/staff_footer.php');?>