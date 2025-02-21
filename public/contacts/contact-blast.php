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
$sessionHelper = $app['sessionHelper'];

use Postmark\PostmarkClient;
use Fivetwofive\KrateCMS\Middleware\AuthMiddleware;

try {
    // Check authentication with admin requirement
    AuthMiddleware::requireLogin($userManager, true);

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
                $contacts = $contactManager->findAllContacts('email');
                $sentCount = 0;
                $failedCount = 0;

                while ($contact = $contacts->fetch_assoc()) {
                    // Prepare email content for each contact
                    $html_body = "<p>Dear " . h($contact['first_name']) . " " . h($contact['last_name']) . ",</p>" . $text;
                    $text_body = "Dear " . $contact['first_name'] . " " . $contact['last_name'] . ",\n\n" . strip_tags($text);

                    try {
                        // Send email
                        $sendResult = $client->sendEmail(
                            $from,
                            $contact['email'],
                            $subject,
                            $html_body,
                            $text_body
                        );

                        if ($sendResult->ErrorCode === 0) {
                            $sentCount++;
                        } else {
                            $failedCount++;
                            error_log("Failed to send to {$contact['email']}: {$sendResult->Message}");
                        }
                    } catch (Exception $e) {
                        $failedCount++;
                        error_log("Error sending to {$contact['email']}: " . $e->getMessage());
                    }
                }

                if ($sentCount > 0) {
                    $success = true;
                    $_SESSION['message'] = "Successfully sent {$sentCount} messages" . 
                                         ($failedCount > 0 ? " ({$failedCount} failed)" : "");
                } else {
                    throw new RuntimeException('Failed to send any messages');
                }
            } catch (Exception $e) {
                $errors[] = 'Failed to send messages: ' . $e->getMessage();
            }
        }
    }

    $title = "Mass Email";
    $page_heading = "Send Mass Email";
    $page_subheading = "Send an email to all contacts";
    $custom_class = "contact-blast-page";

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

            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                <strong>Warning:</strong> This will send an email to all contacts in the system.
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

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Messages sent successfully!
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="post" action="<?= $urlHelper->urlFor('/contacts/contact-blast.php'); ?>" 
                          onsubmit="return validateForm();">
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" 
                                   value="<?= h($_POST['subject'] ?? ''); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control wysiwyg" id="message" name="message" 
                                      rows="10"><?php echo h($_POST['message'] ?? ''); ?></textarea>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Send to All Contacts
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