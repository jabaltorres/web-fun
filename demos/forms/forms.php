<?php
    require_once '../../private/initialize.php';
    $title = "Form Page"; // this is for <title>
    $page_title = "This is the form page"; //this is for breadcrumbs if I want a custom title other than the default
    $addCSS = ""; //custom CSS for this page only
    include_once(INCLUDES_PATH . '/site-header.php');
?>

<div class="container">
    <?php include_once(INCLUDES_PATH . '/masthead.php'); ?>
    <?php include_once(INCLUDES_PATH . '/navigation.php'); ?>

    <section class="forms">

        <div class="hgroup">
            <h1>Forms</h1>
            <p class="lead">This would be a great place to test form validation.</p>
        </div>

        <form method="post" action="acknowledge.php">
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" required>

            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="subject" required>

            <label for="message">Message:</label>
            <textarea name="message" id="message" required></textarea>

            <input type="submit" name="send" value="Send Message" class="btn btn-primary">
        </form>
    </section>
</div>

<?php include_once(INCLUDES_PATH . '/site-footer.php'); ?>