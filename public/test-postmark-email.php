<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php'); // Ensure Postmark is loaded

use Postmark\PostmarkClient;

// Test the Postmark Email
function testPostmarkEmail() {
    global $postmarkApiToken; // Use the Postmark API token from your .env or config

    $client = new PostmarkClient($postmarkApiToken);

    // Define admin email addresses
    $adminEmails = ["jabal@fivetwofive.com", "jabaltorres@gmail.com"]; // Replace with actual emails

    $subject = "Postmark Test Email";
    $htmlBody = "<strong>This is a test email</strong> to verify Postmark integration.";
    $textBody = "This is a test email to verify Postmark integration.";

    foreach ($adminEmails as $toEmail) {
        try {
            $client->sendEmail(
                "no-reply@fivetwofive.com", // Sender's email
                $toEmail,                  // Admin's email
                $subject,                  // Email subject
                $htmlBody,                 // HTML body
                $textBody                  // Text body
            );
            echo "Test email sent successfully to {$toEmail}.<br>";
        } catch (\Exception $e) {
            echo "Failed to send email: " . $e->getMessage() . "<br>";
        }
    }
}

testPostmarkEmail();
?>