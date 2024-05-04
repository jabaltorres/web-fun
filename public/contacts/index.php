<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/private/initialize.php');
require_login();

$title = "DB Test Page";
$page_heading = "This is the DB Test page";
$page_subheading = "Welcome to the DB test page";
$custom_class = "db-test-page";

// Retrieve sort parameter from GET request or default to 'id'
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';

// Fetch contacts with the specified sorting
$contact_set = find_all_contacts($sort);

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
        <form action="index.php" method="get">
            <label for="sort">Sort by:</label>
            <select id="sort" name="sort">
                <option value="id" <?php echo ($sort == 'id') ? 'selected' : ''; ?>>ID</option>
                <option value="first_name" <?php echo ($sort == 'first_name') ? 'selected' : ''; ?>>First Name</option>
                <option value="last_name" <?php echo ($sort == 'last_name') ? 'selected' : ''; ?>>Last Name</option>
                <option value="email" <?php echo ($sort == 'email') ? 'selected' : ''; ?>>Email</option>
            </select>
            <button type="submit">Sort</button>
        </form>

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
