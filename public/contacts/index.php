<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/private/initialize.php');
require_login();

$title = "DB Test Page";
$page_heading = "This is the DB Test page";
$page_subheading = "Welcome to the DB test page";
$custom_class = "db-test-page";
$contact_set = find_all_contacts();

include_once(INCLUDES_PATH . '/site-header.php');
?>

<div class="container <?php echo $custom_class; ?>">
    <?php
        include_once(INCLUDES_PATH . '/masthead.php');
        include_once(INCLUDES_PATH . '/navigation.php');
    ?>

    <section>
        <?php
            include_once(INCLUDES_PATH . '/headline-page.php');
            include_once(INCLUDES_PATH . '/db-menu.php');
        ?>
    </section>

    <section>
        <h4 class="mb-2 h4 font-weight-bold">Contact Entries</h4>
        <p>This uses the `find_all_contacts()` function from the `query_functions.php` file.</p>
        <table class="table table-striped border">
            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">&nbsp;</th>
                <th scope="col">&nbsp;</th>
                <th scope="col">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($contact = mysqli_fetch_assoc($contact_set)) : ?>
                <tr>
                    <td><?php echo h($contact['id']); ?></td>
                    <td><?php echo h($contact['first_name']); ?></td>
                    <td><?php echo h($contact['last_name']); ?></td>
                    <td><?php echo h($contact['email']); ?></td>
                    <td><a class="action btn d-block mx-auto btn-info" href="<?php echo url_for('/contacts/contact-show.php?id=' . h(u($contact['id']))); ?>">View</a></td>
                    <td><a class="action btn d-block mx-auto btn-warning" href="<?php echo url_for('/contacts/contact-edit.php?id=' . h(u($contact['id']))); ?>">Edit</a></td>
                    <td><a class="action btn d-block mx-auto btn-danger" href="<?php echo url_for('/contacts/contact-delete.php?id=' . h(u($contact['id']))); ?>">Delete</a></td>
                </tr>
            <?php endwhile; ?>
            <?php mysqli_free_result($contact_set); ?>
            </tbody>
        </table>
    </section>
</div><!-- end .container -->

<?php include_once(INCLUDES_PATH . '/site-footer.php'); ?>
