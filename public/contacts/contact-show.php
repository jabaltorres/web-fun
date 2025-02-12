<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/Fivetwofive/KrateCMS/UserManager.php');

use Fivetwofive\KrateCMS\UserManager;

// Initialize the UserManager with the existing $db connection
$userManager = new UserManager($db);

// Ensure the user is logged in
$userManager->checkLoggedIn();

$id = $_GET['id'] ?? '1';
$contact = find_contact_by_id($id);
$title = "DB Test Page";
$page_heading = "This is the DB Test page";
$page_subheading = "Welcome to the DB test page";
$custom_class = "db-test-page";
include('../../templates/layouts/header.php');
?>

<div class="container py-5 <?php echo $custom_class; ?>">

    <section>
        <?php include('../../templates/components/headline.php');?>
        <?php include('../../templates/components/nav_contacts.php');?>
    </section>

    <div class="row">
        <div class="col">
            <section id="content">
                <a class="btn btn-outline-info mb-4 font-weight-bold" href="<?php echo url_for('/contacts/index.php'); ?>">&laquo; Back to List</a>

                <div class="contact show mb-4">
                    <h1 class="h3">Contact: <?php echo h($contact['first_name']) . " " . h($contact['last_name']); ?></h1>



                    <div class="attributes">
                        <?php
                        if ($contact['image'] == '') {
                            echo '<img src="uploads/no-image.png" alt="No image available" style="max-width: 200px;">';
                        } else {
                            echo '<div class="contact-image mb-3"><img src="uploads/' . h($contact['image']) . '" alt="Contact image" style="max-width: 200px;"></div>';
                        }
                        ?>

                        <?php if ($contact['favorite']): ?>
                            <p>Favorited</p>
                        <?php endif; ?>

                        <dl class="mb-2">
                            <dt>First Name</dt>
                            <dd class="font-weight-bold h5"><?php echo h($contact['first_name']); ?></dd>
                            <dt>Last Name</dt>
                            <dd class="font-weight-bold h5"><?php echo h($contact['last_name']); ?></dd>
                            <dt>Contact Number</dt>
                            <dd class="font-weight-bold h5"><?php echo $contact['contact_number'] ? '<a href="tel:' . h($contact['contact_number']) . '">' . h($contact['contact_number']) . '</a>' : 'No contact number'; ?></dd>
                            <dt>Email</dt>
                            <dd class="font-weight-bold h5"><?php echo $contact['email'] ? '<a href="mailto:' . h($contact['email']) . '">' . h($contact['email']) . '</a>' : 'No contact email address'; ?></dd>
                            <dt>Comments</dt>
                            <dd class="font-weight-bold"><?php echo $contact['comments'] ?: 'No comments'; ?></dd>
                            <dt>Ranking</dt>
                            <dd class="font-weight-bold h5"><?php echo h($contact['rank_description']) ?: 'No ranking assigned'; ?></dd>
                        </dl>
                    </div>
                </div>

                <a class="btn btn-warning font-weight-bold" href="<?php echo url_for('/contacts/contact-edit.php?id=' . h(u($contact['id']))); ?>">Edit Contact</a>
                <a class="btn btn-success font-weight-bold" href="<?php echo url_for('/contacts/contact-message.php?id=' . h(u($contact['id']))); ?>">Send Message &raquo;</a>
            </section>
        </div>
    </div>
</div>

<?php include('../../templates/layouts/footer.php'); ?>
