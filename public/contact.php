<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php'); // Initialize your app
use Postmark\PostmarkClient;

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
            $sendResult = $client->sendEmail(
                $fromEmail,
                $toEmail,
                $subject,
                $htmlBody,
                $message
            );

            $successMessage = "Thank you for contacting us, {$name}. We'll get back to you soon!";
        } catch (Exception $e) {
            $errorMessage = 'Failed to send your message. Please try again later.';
            error_log("Error sending contact form: " . $e->getMessage());
        }
    }
}

include('contact-us.php'); // Include your form markup file
?>