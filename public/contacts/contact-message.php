<?php
declare(strict_types=1);

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../../config/bootstrap.php');

// Get services from the container
$contactManager = $app['contactManager'];
$userManager = $app['userManager'];
$urlHelper = $app['urlHelper'];

use Fivetwofive\KrateCMS\Middleware\AuthMiddleware;
use Postmark\PostmarkClient;

try {
    // Check authentication
    AuthMiddleware::requireLogin($userManager);

    // Get contact ID from URL parameters
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    if ($id === 0) {
        throw new InvalidArgumentException('Invalid contact ID');
    }

    // Fetch contact data
    $contact = $contactManager->findContactById($id);
    
    if (!$contact) {
        throw new RuntimeException('Contact not found');
    }

    $errors = [];
    $success = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize and validate input data
        $from = $_ENV['MAIL_FROM_ADDRESS'] ?? 'info@fivetwofive.com';
        $subject = trim($_POST['subject'] ?? '');
        $text = $_POST['message'] ?? '';

        // Validate inputs
        if (empty($subject)) {
            $errors[] = 'Please provide an email subject.';
        }
        if (empty($text)) {
            $errors[] = 'Please provide the email body text.';
        }

        if (empty($errors)) {
            $postmarkApiToken = $_ENV['POSTMARK_API_TOKEN'] ?? '';
            
            if (empty($postmarkApiToken)) {
                throw new RuntimeException('Email sending configuration is missing.');
            }

            try {
                $client = new PostmarkClient($postmarkApiToken);

                // Prepare email content
                $html_body = "<p>Dear " . h($contact['first_name']) . " " . h($contact['last_name']) . ",</p>" . $text;
                $text_body = "Dear " . $contact['first_name'] . " " . $contact['last_name'] . ",\n\n" . strip_tags($text);

                // Send email
                $sendResult = $client->sendEmail(
                    $from,
                    $contact['email'],
                    $subject,
                    $html_body,
                    $text_body
                );

                if ($sendResult->ErrorCode === 0) {
                    $_SESSION['message'] = 'Message sent successfully.';
                    redirect_to('/contacts/index.php');
                } else {
                    throw new RuntimeException('Failed to send message: ' . $sendResult->Message);
                }
            } catch (Exception $e) {
                $errors[] = 'Failed to send message: ' . $e->getMessage();
            }
        }
    }

    $title = "Send Message";
    $page_heading = "Send Message";
    $page_subheading = "Send a message to " . h($contact['first_name']) . " " . h($contact['last_name']);
    $custom_class = "contact-message-page";

    // Start output buffering
    ob_start();
    
    include('../../src/Views/templates/header.php');
?>

<div class="container py-5 <?php echo h($custom_class); ?>">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h2"><?php echo h($page_heading); ?></h1>
                <a class="btn btn-outline-primary" href="<?= $urlHelper->urlFor('/contacts/index.php'); ?>">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo h($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <h3 class="h5">Recipient Details</h3>
                        <p class="mb-1">
                            <strong>Name:</strong> <?php echo h($contact['first_name']) . " " . h($contact['last_name']); ?>
                        </p>
                        <p class="mb-0">
                            <strong>Email:</strong> <?php echo h($contact['email']); ?>
                        </p>
                    </div>

                    <form method="post" action="<?= $urlHelper->urlFor('/contacts/contact-message.php?id=' . $contact['id']); ?>" 
                          onsubmit="return validateForm();">
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <select class="form-control" name="subject" id="subject" required>
                                <option value="" disabled selected>Select a subject</option>
                                <option value="Hello">Hello</option>
                                <option value="Compliment">Compliment</option>
                                <option value="Inquiry">Inquiry</option>
                                <option value="Sales Pitch">Sales Pitch</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control wysiwyg" id="message" name="message" 
                                      rows="10"><?php echo h($_POST['message'] ?? ''); ?></textarea>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    tinymce.init({
        selector: 'textarea.wysiwyg',
        plugins: [
            'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link',
            'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount', 'code'
        ],
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | ' +
                'bullist numlist outdent indent | link image | code codesample',
        menubar: false,
        height: 400,
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        }
    });

    function validateForm() {
        tinymce.triggerSave();
        var messageContent = document.getElementById('message').value.trim();
        if (messageContent === '') {
            alert('Please enter your message.');
            return false;
        }
        return true;
    }
</script>

<?php
    include('../../src/Views/templates/footer.php');
    
    // End output buffering and flush
    ob_end_flush();
} catch (Exception $e) {
    // Log the error
    error_log($e->getMessage());
    // Clean output buffer
    ob_end_clean();
    // Redirect to error page
    redirect_to('/error.php');
}
?>