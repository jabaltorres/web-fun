<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

use Postmark\PostmarkClient;

function sendTestEmail($to, $subject, $htmlBody, $textBody)
{
    // Get the Postmark API token from the environment variables
    global $postmarkApiToken;

    $client = new PostmarkClient($postmarkApiToken);

    // Sender's email address (must be a verified sender in Postmark)
    $fromEmail = "jabal@fivetwofive.com";

    // Optional parameters based on the documentation
    $tag = "test-email";
    $trackOpens = true; // Enable open tracking
    $trackLinks = "None"; // No link tracking
    $messageStream = "broadcast"; // Use the broadcast stream

    try {
        // Send an email using Postmark
        $sendResult = $client->sendEmail(
            $fromEmail,      // Sender's email address
            $to,             // Recipient's email address
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

        return $sendResult;
    } catch (Exception $e) {
        echo "Error sending email: " . $e->getMessage();
    }
}

// Trigger the test email function
$htmlBody = "<strong>Hello</strong>, this is a test email from KrateCMS using PostmarkApp.";
$textBody = "Hello, this is a test email from KrateCMS using PostmarkApp.";
$result = sendTestEmail("jabaltorres@gmail.com", "Test Email from KrateCMS", $htmlBody, $textBody);

if ($result) {
    echo "Test email sent successfully!";
} else {
    echo "Failed to send the test email.";
}
?>