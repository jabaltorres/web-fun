<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

use Fivetwofive\KrateCMS\UserManager;
use Postmark\PostmarkClient;

// Instantiate the KrateUserManager class
$userManager = new UserManager($db);

// Ensure the user is logged in
$userManager->checkLoggedIn();

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize form inputs
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = 'Please enter a valid email address.';
    } else {
        // Send email via Postmark
        try {
            $postmarkApiToken = $_ENV['POSTMARK_API_TOKEN'];
            $client = new PostmarkClient($postmarkApiToken);

            // Email content
            $fromEmail = "info@fivetwofive.com"; // Replace with your email
            $toEmail = "jabal@fivetwofive.com"; // Replace with admin email
            $htmlBody = "<p><strong>Name:</strong> {$name}</p><p><strong>Email:</strong> {$email}</p><p><strong>Message:</strong><br/>{$message}</p>";

            // Send email using Postmark
            $client->sendEmail(
                $fromEmail,
                $toEmail,
                $subject,
                $htmlBody
            );

            $successMessage = "Thank you for contacting us, {$name}. We'll get back to you soon!";
        } catch (Exception $e) {
            $errorMessage = 'Failed to send your message. Please try again later.';
            error_log("Error sending contact form: " . $e->getMessage());
        }
    }
}

$title = "Demo Form Page"; // this is for <title>
$page_title = "Demo Form";
$page_subheading = "Powered by PostmarkApp";

include('../../../templates/layout/header.php');
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12 col-lg-6 mx-auto">
            <section>
                <header>
                    <h1 class="class-h2"><?php echo $page_title; ?></h1>
                    <h2 class="class-h3"><?php echo $page_subheading; ?></h2>

                    <?php
                    // Display error message if any
                    if ($errorMessage) {
                        echo "<div class='alert alert-danger'>$errorMessage</div>";
                    }
                    // Display success message if form was successfully submitted
                    elseif ($successMessage) {
                        echo "<div class='alert alert-success'>$successMessage</div>";
                    }
                    ?>
                </header>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" class="border p-4">
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" name="name" id="name" value="<?php echo h($name ?? ''); ?>" required />
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address:</label>
                        <input type="email" name="email" id="email" value="<?php echo h($email ?? ''); ?>" required />
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input type="text" name="subject" id="subject" value="<?php echo h($subject ?? ''); ?>" required />
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea name="message" id="message" required><?php echo h($message ?? ''); ?></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<?php include('../../../templates/layout/footer.php'); ?>