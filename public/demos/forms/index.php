<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');


require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/classes/KrateUserManager.php'); // Ensure this path is correct

use Fivetwofive\KrateCMS\KrateUserManager;

// Instantiate the KrateUserManager class
$userManager = new KrateUserManager($db);

// Ensure the user is logged in
$userManager->checkLoggedIn();

use Postmark\PostmarkClient; // Assuming PostmarkClient is already configured in your project

$demoMessage = [];
$errors = [];
$success_message = '';

if (is_post_request()) {
    $demoMessage = [
        'name' => $_POST['name'] ?? '',
        'email' => $_POST['email'] ?? '',
        'subject' => $_POST['subject'] ?? '',
        'message' => $_POST['message'] ?? ''
    ];

    // Validate the form
    $errors = validate_demo_form($demoMessage);

    if (empty($errors)) {
        // Prepare email body with all form field values
        $emailBody = "
        New contact form submission:

        Name: " . h($demoMessage['name']) . "
        Email: " . h($demoMessage['email']) . "
        Subject: " . h($demoMessage['subject']) . "
        Message: " . h($demoMessage['message']) . "
        ";

        global $postmarkApiToken;
        // Email Sending
        $client = new PostmarkClient($postmarkApiToken); // Replace with your actual Postmark API key

        try {
            $result = $client->sendEmail(
                "info@fivetwofive.com", // From email address
                "jabal@fivetwofive.com", // To admin's email address
                "New Demo Form Submission: " . h($demoMessage['subject']), // Email subject
                $emailBody // Email body containing form field values
            );

            // Display success message instead of redirecting to another page
            $success_message = "Thank you, " . h($demoMessage['name']) . ", for your message! Your details have been sent to the admin.";

            // Optionally, you could clear the form fields after submission
            $demoMessage = [];

        } catch (Exception $e) {
            $errors[] = "There was an issue sending the email: " . $e->getMessage();
        }
    }
}

$title = "Demo Form Page"; // this is for <title>
$page_title = "Demo Form";
$page_subheading = "Powered by PostmarkApp";

include('../../../templates/layout/header.php');
?>

  <div class="container py-5">
    <section class="forms">
      <header>
        <h1 class="class-h2"><?php echo $page_title; ?></h1>
        <h2 class="class-h3"><?php echo $page_subheading; ?></h2>

          <?php
          // Display errors if any
          if (!empty($errors)) {
              echo display_errors($errors);
          }
          // Display success message if form was successfully submitted
          elseif ($success_message) {
              echo "<div class='alert alert-success'>$success_message</div>";
          }
          ?>
      </header>

      <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="form-group">
          <label for="name">Full Name:</label>
          <input type="text" name="name" id="name" value="<?php echo h($demoMessage['name'] ?? ''); ?>" required />
        </div>
        <div class="form-group">
          <label for="email">Email Address:</label>
          <input type="email" name="email" id="email" value="<?php echo h($demoMessage['email'] ?? ''); ?>" required />
        </div>
        <div class="form-group">
          <label for="subject">Subject:</label>
          <input type="text" name="subject" id="subject" value="<?php echo h($demoMessage['subject'] ?? ''); ?>" required />
        </div>
        <div class="form-group">
          <label for="message">Message:</label>
          <textarea name="message" id="message" required><?php echo h($demoMessage['message'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </section>
  </div>

<?php include('../../../templates/layout/footer.php'); ?>