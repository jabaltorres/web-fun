<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/private/initialize.php');
require_login();

$title = "Contact Page";
$page_heading = "This is the Users Page";
$page_subheading = "Welcome to the Users page";
$custom_class = "users-page";

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
        ?>
    </section>

    <section>
        <h4 class="mb-2 h4 font-weight-bold">Users</h4>
        <a href="user-add.php"  class="btn btn-outline-info mb-4 font-weight-bold">Add User</a>
    </section>
</div><!-- end .container -->

<?php include_once(INCLUDES_PATH . '/site-footer.php'); ?>
