<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php'); // Ensure Postmark is loaded

use Postmark\PostmarkClient;

// Ensure the Postmark API token is set
if (empty($postmarkApiToken)) {
    // Set a fallback token for testing (remove this in production)
    $postmarkApiToken = $_ENV['POSTMARK_API_TOKEN']; // Replace with your actual Postmark API token
    // Alternatively, throw an exception or handle the error as needed
    // throw new Exception("Postmark API token is not set.");
}

/**
 * Sends a test email using Postmark to multiple recipients.
 *
 * @param array  $recipients Array of recipient email addresses.
 * @param string $subject The subject of the email.
 * @param string $htmlBody The HTML body of the email.
 * @param string $textBody The plain text body of the email.
 *
 * @return void
 */
function sendTestEmail(array $recipients, string $subject, string $htmlBody, string $textBody): void
{
    global $postmarkApiToken; // Use the Postmark API token from your .env or config

    $client = new PostmarkClient($postmarkApiToken);
    $fromEmail = "jabal@fivetwofive.com"; // Sender's email address (must be a verified sender in Postmark)

    // Optional email parameters
    $tag = "test-email";
    $trackOpens = true;  // Enable open tracking
    $trackLinks = "None";  // No link tracking
    $messageStream = "broadcast";  // Use the broadcast stream

    foreach ($recipients as $toEmail) {
        // Validate email
        if (!filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
            echo "Invalid email format: " . htmlspecialchars($toEmail) . "<br>";
            continue;
        }

        try {
            // Send email using Postmark
            $client->sendEmail(
                $fromEmail,      // Sender's email address
                $toEmail,        // Recipient's email address
                $subject,        // Subject of the email
                $htmlBody,       // HTML body of the email
                $textBody,       // Text body of the email
                $tag,            // Email tag
                $trackOpens,     // Track opens
                null,            // Reply To (optional)
                null,            // CC (optional)
                null,            // BCC (optional)
                null,            // Headers (optional)
                null,            // Attachments (optional)
                $trackLinks,     // Link tracking (optional)
                null,            // Metadata (optional)
                $messageStream   // Message stream
            );
            echo "Test email sent successfully to " . htmlspecialchars($toEmail) . ".<br>";
        } catch (Exception $e) {
            error_log("Failed to send email to {$toEmail}: " . $e->getMessage());
            echo "Failed to send email to " . htmlspecialchars($toEmail) . ". Error: " . htmlspecialchars($e->getMessage()) . "<br>";
        }
    }
}

// Define recipients and email content
$recipients = ["jabal@fivetwofive.com", "jabaltorres@gmail.com"]; // Replace with actual emails
$subject = "Test Email from KrateCMS";
$htmlBody = "<strong>Hello</strong>, this is a test email from KrateCMS using PostmarkApp.";
$textBody = "Hello, this is a test email from KrateCMS using PostmarkApp.";

// Send the test email
sendTestEmail($recipients, $subject, $htmlBody, $textBody);

?>