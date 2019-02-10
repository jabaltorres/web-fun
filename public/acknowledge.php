<?php
    if (isset($_POST['send'])) {

        $from_email       = 'info@jabaltorres.com'; //from mail, sender email address
        $recipient_email  = 'jabaltorres@gmail.com'; //recipient email address

        //Load POST data from HTML form
        $sender_name    = $_POST["name"]; //sender name
        $reply_to_email = $_POST["email"]; //sender email, it will be used in "reply-to" header
        $subject        = $_POST["subject"]; //subject for the email

        //body of the email
        $message = 'Name: ' . $sender_name . "\r\n";
        $message .= 'Email: ' . $reply_to_email . "\r\n";
        $message .= 'Subject: ' . $subject . "\r\n";
        $message .= 'Comments: ' . $_POST['message'];

        /*Always remember to validate the form fields like this
            if(strlen($sender_name)<1) {
                die('Name is too short or empty!');
            }
        */

        //header
        $headers = "MIME-Version: 1.0\r\n"; // Defining the MIME version
        $headers .= "From: ".$from_email."\r\n"; // Sender Email
        $headers .= "Reply-To: ".$reply_to_email."\r\n"; // Email address to reach back
        $headers .= 'Content-Type: text/plain; charset=utf-8'; // Defining Content-Type

        $success = mail($recipient_email, $subject, $message, $headers);
    }

?>

<body>
  <?php if ($success) { ?>
      <h1>Thank You</h1>
      Your message has been sent.
  <?php } else { ?>
      <h1>Oops!</h1>
      Sorry, there was a problem sending your message.
  <?php } ?>
</body>