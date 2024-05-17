<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../private/initialize.php');
require_login();

$search = $_GET['search'] ?? '';
$title = "Search Results";
$page_heading = "Search Results for: " . htmlspecialchars($search);
$custom_class = "search-results-page";

function search_contacts($search) {
    global $db;
    $sql = "SELECT * FROM contact_list WHERE ";
    $sql .= "first_name LIKE '%" . db_escape($db, $search) . "%' ";
    $sql .= "OR last_name LIKE '%" . db_escape($db, $search) . "%' ";
    $sql .= "OR email LIKE '%" . db_escape($db, $search) . "%'";
    $sql .= "ORDER BY first_name ASC, last_name ASC"; // You can adjust the sorting as needed

    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
}

$contacts = search_contacts($search);

include_once(SHARED_PATH . '/site_header.php');
include_once(SHARED_PATH . '/navigation.php');
?>


<div class="container <?php echo $custom_class; ?>">

    <a class="btn btn-outline-info mb-4 font-weight-bold" href="<?php echo url_for('/contacts/index.php'); ?>">&laquo; Back to List</a>

    <h1><?php echo $page_heading; ?></h1>

    <div class="content mb-5">
        <?php if (mysqli_num_rows($contacts) > 0): ?>
            <table class="table table-striped">
                <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($contact = mysqli_fetch_assoc($contacts)) : ?>
                    <tr>
                        <td><?php echo h($contact['id']); ?></td>
                        <td><?php echo h($contact['first_name']); ?></td>
                        <td><?php echo h($contact['last_name']); ?></td>
                        <td><?php echo h($contact['email']); ?></td>
                        <td>
                            <a href="<?php echo url_for('/contacts/contact-show.php?id=' . h(u($contact['id']))); ?>" class="btn btn-info btn-sm">View</a>
                            <a href="<?php echo url_for('/contacts/contact-edit.php?id=' . h(u($contact['id']))); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?php echo url_for('/contacts/contact-delete.php?id=' . h(u($contact['id']))); ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info" role="alert">
                <p>No contacts found matching your search criteria.</p>
            </div>
        <?php endif; ?>
    </div>



    <a class="btn btn-outline-info mb-4 font-weight-bold" href="<?php echo url_for('/contacts/index.php'); ?>">&laquo; Back to List</a>

    <?php mysqli_free_result($contacts); ?>
</div>

<?php include_once(SHARED_PATH . '/site-footer.php'); ?>
