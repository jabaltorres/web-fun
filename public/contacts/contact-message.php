<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/Fivetwofive/KrateCMS/UserManager.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php'); // Autoload Postmark

use Fivetwofive\KrateCMS\UserManager;
use Postmark\PostmarkClient;

// Initialize the UserManager with the existing $db connection
$userManager = new UserManager($db);

// Ensure the user is logged in
$userManager->checkLoggedIn();

// Initialize variables
$output_form = false;
$subject = '';
$text = '';

// Validate 'id' from GET and ensure it's a positive integer
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
    $id = intval($_GET['id']);
    $contact = find_contact_by_id($id);
    if (!$contact) {
        // Contact not found, redirect to contacts list
        redirect_to(url_for('/contacts/index.php'));
    }
} else {
    // Invalid or missing 'id', redirect to contacts list
    redirect_to(url_for('/contacts/index.php'));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input data
    $from = 'info@fivetwofive.com'; // Ensure this is a verified sender in Postmark
    $subject = trim($_POST['subject'] ?? '');
    $text = $_POST['message'] ?? ''; // HTML content from TinyMCE
    $errors = [];

    // Check for empty fields
    if (empty($subject)) {
        $errors[] = 'Please provide an email subject.';
    }

    if (empty($text)) {
        $errors[] = 'Please provide the email body text.';
    }

    // If there are errors, display them
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div class="alert alert-warning p-4 mb-4 text-center">' . h($error) . '</div>';
        }
        $output_form = true;
    } else {
        // Get Postmark API token
        $postmarkApiToken = $_ENV['POSTMARK_API_TOKEN'] ?? '';
        if (empty($postmarkApiToken)) {
            echo '<div class="alert alert-danger p-4 text-center">Email sending configuration is missing.</div>';
            $output_form = true;
        } else {
            $client = new PostmarkClient($postmarkApiToken);

            // Get the contact details from the database
            $to = $contact['email'];
            $first_name = $contact['first_name'];
            $last_name = $contact['last_name'];

            // Prepare the email body
            $html_body = "<p>Dear " . h($first_name) . " " . h($last_name) . ",</p>" . $text;
            $text_body = "Dear " . $first_name . " " . $last_name . ",\n\n" . strip_tags($text);

            try {
                // Send email using Postmark
                $sendResult = $client->sendEmail(
                    $from,       // From email (verified sender)
                    $to,         // To email
                    $subject,    // Subject
                    $html_body,  // HTML body
                    $text_body   // Text body
                );

                // Check the response for success
                if ($sendResult->ErrorCode === 0) {
                    echo '<div class="alert alert-success p-4 mb-0 text-center">Message sent successfully to: ' . h($to) . '</div>';
                } else {
                    echo '<div class="alert alert-danger p-4 mb-0 text-center">Failed to send message: ' . h($sendResult->Message) . '</div>';
                }
            } catch (Exception $e) {
                echo '<div class="alert alert-danger p-4 mb-0 text-center">An error occurred while sending the message: ' . h($e->getMessage()) . '</div>';
            }
        }
    }
} else {
    $output_form = true;
}

$title = "Contact Message";
$page_heading = "Contact Message";
$page_subheading = "Send a message to your contact";
$custom_class = "contact-message-page";

include('../../templates/layout/header.php');
?>

    <script>
        tinymce.init({
            selector: 'textarea.wysiwyg',
            plugins: [
                'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link',
                'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount', 'code',
            ],
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | ' +
                'bullist numlist outdent indent | link image | code codesample',
            menubar: false,
            height: 600
        });
    </script>

    <div class="container py-5 <?php echo h($custom_class); ?>">

        <section>
            <?php include('../../templates/components/headline.php'); ?>
        </section>

        <div class="row">
            <div class="col">

                <section class="mb-4 d-none">
                    <!-- Displaying user information securely -->
                    <p>User Id: <?php echo h($_SESSION['user_id']); ?></p>
                    <p>User Username: <?php echo h($_SESSION['username']); ?></p>
                    <p>User First Name: <?php echo h($_SESSION['first_name']); ?></p>
                </section>

                <section>
                    <div class="content w-75 mx-auto">
                        <?php if ($output_form): ?>
                            <form method="post" action="<?php echo url_for('/contacts/contact-message.php?id=' . h(u($contact['id']))); ?>" onsubmit="return validateForm();">

                                <div class="h5">Contact: <?php echo h($contact['first_name']) . " " . h($contact['last_name']); ?></div>
                                <div class="h5 mb-3">Email Address: <?php echo h($contact['email']); ?></div>

                                <hr>

                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <select class="form-control" name="subject" id="subject" required>
                                        <option value="" disabled <?php echo $subject == '' ? 'selected' : ''; ?>>Select a subject</option>
                                        <option value="Hello" <?php echo $subject == 'Hello' ? 'selected' : ''; ?>>Hello</option>
                                        <option value="Compliment" <?php echo $subject == 'Compliment' ? 'selected' : ''; ?>>Compliment</option>
                                        <option value="Insult" <?php echo $subject == 'Insult' ? 'selected' : ''; ?>>Insult</option>
                                        <option value="Inquiry" <?php echo $subject == 'Inquiry' ? 'selected' : ''; ?>>Inquiry</option>
                                        <option value="Sales Pitch" <?php echo $subject == 'Sales Pitch' ? 'selected' : ''; ?>>Sales Pitch</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="message">Your Message</label>
                                    <textarea class="form-control wysiwyg" id="message" name="message" rows="5" ><?php echo h($text); ?></textarea>
                                </div>

                                <input class="btn btn-primary" type="submit" name="submit" value="Send Message" />
                            </form>

                            <script>
                                function validateForm() {
                                    tinymce.triggerSave();
                                    var messageContent = document.getElementById('message').value.trim();
                                    if (messageContent === '') {
                                        alert('Please enter your message.');
                                        return false; // Prevent form submission
                                    }
                                    return true; // Allow form submission
                                }
                            </script>
                        <?php endif; ?>
                    </div>
                </section>
            </div><!-- end .col -->
        </div><!-- end .row -->

    </div><!-- end .container -->
<?php include('../../templates/layout/footer.php'); ?>