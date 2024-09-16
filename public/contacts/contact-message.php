<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/classes/KrateUserManager.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php'); // Autoload Postmark

use Fivetwofive\KrateCMS\KrateUserManager;
use Postmark\PostmarkClient;

// Initialize the KrateUserManager with the existing $db connection
$userManager = new KrateUserManager($db);

// Ensure the user is logged in
$userManager->checkLoggedIn();

if (!isset($_GET['id'])) {
    redirect_to(url_for('/index.php'));
}

$id = $_GET['id'];
$contact = find_contact_by_id($id);

if (is_post_request()) {
    $from = 'info@fivetwofive.com'; // Update this to the Postmark verified sender email
    $subject = $_POST['subject'];
    $text = $_POST['message']; // updated the key to reflect the form input name "message"
    $output_form = false;

    if (empty($subject) && empty($text)) {
        // We know both $subject AND $text are blank
        echo '<div class="alert alert-warning p-4 mb-4">You forgot the email subject and body text.</div>';
        $output_form = true;
    }

    if (empty($subject) && (!empty($text))) {
        echo '<div class="alert alert-warning p-4 mb-4">You forgot the email subject.</div>';
        $output_form = true;
    }

    if (!empty($subject) && empty($text)) {
        echo '<div class="alert alert-warning p-4 mb-4">You forgot the email body text.</div>';
        $output_form = true;
    }

    if (!empty($subject) && !empty($text)) {
        $postmarkApiToken = $_ENV['POSTMARK_API_TOKEN'];
        $client = new PostmarkClient($postmarkApiToken);

        // Get the contact details from the database
        $to = $contact['email'];
        $first_name = $contact['first_name'];
        $last_name = $contact['last_name'];
        $msg = "Dear $first_name $last_name,\n\n$text";

        try {
            // Send email using Postmark
            $sendResult = $client->sendEmail(
                $from, // From email (should be verified in Postmark)
                $to,   // To email
                $subject, // Subject
                $msg    // Body (plain text)
            );

            if ($sendResult['ErrorCode'] === 0) {
                echo '<div class="alert alert-success p-4">Message sent successfully to: ' . $to . '</div>';
            } else {
                echo '<div class="alert alert-danger p-4">Failed to send message: ' . $sendResult['Message'] . '</div>';
            }

        } catch (Exception $e) {
            echo '<div class="alert alert-danger p-4">An error occurred while sending the message: ' . $e->getMessage() . '</div>';
        }
    }
} else {
    $output_form = true;
    $subject = '';
    $text = '';
}

$title = "Contact Message";
// this is for <title>

$page_heading = "Contact Message";
// This is for breadcrumbs if I want a custom title other than the default

$page_subheading = "Send a message to your contact";
// This is the subheading

$custom_class = "contact-message-page";
// Custom CSS for this page only

include('../../templates/layout/header.php');
?>
<div class="container py-5 <?php echo $custom_class; ?>">

    <section>
        <?php include('../../templates/components/headline.php'); ?>
    </section>

    <div class="row">
        <div class="col">

            <section class="mb-4">
                <!-- Displaying some values -->
                <?php echo 'User Id: ' . $_SESSION['user_id'] . '</br>'; ?>
                <?php echo 'User Username: ' . $_SESSION['username'] . '</br>'; ?>
                <?php echo 'User First Name: ' . $_SESSION['first_name'] . '</br>'; ?>
            </section>

            <section class="">
                <p>Send an email to a contact list member.</p>

                <div class="content w-75 mx-auto">

                    <a class="btn btn-outline-info mb-4 font-weight-bold" href="<?php echo url_for('/contacts/index.php'); ?>">&laquo; Back to List</a>

                    <?php if ($output_form): ?>
                        <form method="post" action="<?php echo url_for('/contacts/contact-message.php?id=' . h(u($contact['id']))); ?>">

                            <div class="h5">Contact: <?php echo h($contact['first_name']) . " " . h($contact['last_name']); ?></div>
                            <div class="h5 mb-3">Address: <?php echo h($contact['email']); ?></div>

                            <hr>

                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <select class="form-control" name="subject" id="subject" required>
                                    <option value="" disabled selected>Select a subject</option>
                                    <option value="Hello">Hello</option>
                                    <option value="Compliment">Compliment</option>
                                    <option value="Insult">Insult</option>
                                    <option value="Inquiry">Inquiry</option>
                                    <option value="Sales Pitch">Sales Pitch</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="message">Your Message</label>
                                <textarea class="form-control" id="message" name="message" rows="5" required><?php echo h($text); ?></textarea>
                            </div>

                            <input class="btn btn-primary" type="submit" name="submit" value="Send Message" />
                        </form>
                    <?php endif; ?>
                </div>
            </section>
        </div><!-- end .col -->
    </div><!-- end .row -->

</div><!-- end .container -->
<?php include('../../templates/layout/footer.php'); ?>
