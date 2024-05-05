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
                <option value="favorite" <?php echo ($sort == 'favorite') ? 'selected' : ''; ?>>Favorite</option>
            </select>
            <button type="submit">Sort</button>
        </form>

        <!-- index.php -->
        <form action="search-results.php" method="get">
            <input type="text" name="search" placeholder="Search contacts..." required>
            <button type="submit">Search</button>
        </form>

        <h4 class="mb-2 h4 font-weight-bold">Contact Entries</h4>
        <p>This uses the `find_all_contacts()` function from the `query_functions.php` file.</p>
        <table class="table table-striped border">
            <thead class="thead-dark">
            <tr>
                <th scope="col"><a href="#" class="sort-header" data-sort="id">ID</a></th>
                <th scope="col"><a href="#" class="sort-header" data-sort="first_name">First Name</a></th>
                <th scope="col"><a href="#" class="sort-header" data-sort="last_name">Last Name</a></th>
                <th scope="col"><a href="#" class="sort-header" data-sort="email">Email</a></th>
                <th scope="col"><a href="#" class="sort-header" data-sort="favorite">Favorite</a></th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            <?php while ($contact = mysqli_fetch_assoc($contact_set)) : ?>
                <tr>
                    <td><?php echo h($contact['id']); ?></td>
                    <td><?php echo h($contact['first_name']); ?></td>
                    <td><?php echo h($contact['last_name']); ?></td>
                    <td><?php echo h($contact['email']); ?></td>
                    <td><?php echo $contact['favorite'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <a href="<?php echo url_for('/contacts/contact-show.php?id=' . h(u($contact['id']))); ?>" class="btn btn-info btn-sm">View</a>
                        <a href="<?php echo url_for('/contacts/contact-edit.php?id=' . h(u($contact['id']))); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="<?php echo url_for('/contacts/contact-delete.php?id=' . h(u($contact['id']))); ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
            <?php endwhile; ?>
            <?php mysqli_free_result($contact_set); ?>
            </tbody>
        </table>
    </section>
</div><!-- end .container -->

<script>
	document.addEventListener("DOMContentLoaded", function() {
		// Attach click event to all elements with class 'sort-header'
		const sortableHeaders = document.querySelectorAll('.sort-header');
		sortableHeaders.forEach(function(header) {
			header.addEventListener('click', function(e) {
				e.preventDefault(); // Prevent default link behavior
				const sortKey = this.getAttribute('data-sort'); // Get the sorting key from the data attribute
				window.location.href = `?sort=${sortKey}`; // Redirect to the same page with the new sort parameter
			});
		});
	});
</script>

<?php include_once(INCLUDES_PATH . '/site-footer.php'); ?>
