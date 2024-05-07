<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/private/initialize.php');
require_login();

$title = "Contact Page";
$page_heading = "This is the Contacts Page";
$page_subheading = "Welcome to the Contacts page";
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

    <div class="row">
        <div class="col">
            <form action="index.php" method="get">
                <div class="form-row">
                    <div class="col">
                        <span class="font-weight-bold">Sort</span>
                    </div>
                </div>
                <div class="form-row align-items-center">
                    <div class="col">
                        <label for="sort" class="sr-only">Sort by:</label>
                        <select id="sort" class="custom-select" name="sort">
                            <option value="id" <?php echo ($sort == 'id') ? 'selected' : ''; ?>>ID</option>
                            <option value="first_name" <?php echo ($sort == 'first_name') ? 'selected' : ''; ?>>First Name</option>
                            <option value="last_name" <?php echo ($sort == 'last_name') ? 'selected' : ''; ?>>Last Name</option>
                            <option value="email" <?php echo ($sort == 'email') ? 'selected' : ''; ?>>Email</option>
                            <option value="favorite" <?php echo ($sort == 'favorite') ? 'selected' : ''; ?>>Favorite</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Sort</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col">
            <form action="search-results.php" method="get">
                <div class="form-row">
                    <div class="col">
                        <span class="font-weight-bold">Search</span>
                    </div>
                </div>
                <div class="form-row align-items-center">
                    <div class="col">
                        <label for="search" class="sr-only">Search:</label>
                        <input type="text" id="search" class="form-control" name="search" placeholder="Search contacts..." required>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <section>


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
