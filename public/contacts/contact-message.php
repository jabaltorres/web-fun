<?php
require_once('../../private/initialize.php');

require_login();

    if(!isset($_GET['id'])) {
        redirect_to(url_for('/index.php'));
    }

    $id = $_GET['id'];
    $contact = find_contact_by_id($id);

    if(is_post_request()) {

        $from = 'jabaltorre@gmail.com';
        $subject = $_POST['subject'];
        $text = $_POST['emailtext'];
        $output_form = false;

        if (empty($subject) && empty($text)) {
            // We know both $subject AND $text are blank
            echo '<div class="border border-warning p-4 mb-4">You forgot the email subject and body text.</div>';
            $output_form = true;
        }

        if (empty($subject) && (!empty($text))) {
            echo '<div class="border border-warning p-4 mb-4">You forgot the email subject.</div>';
            $output_form = true;
        }

        if ( (!empty($subject)) && empty($text) ) {
            echo '<div class="border border-warning p-4 mb-4">You forgot the email body text.</div>';
            $output_form = true;
        }

    } else {
        $output_form = true;
        $subject = '';
        $text = '';

    }

    $title = "Contact Message";
    // this is for <title>

    $page_heading = "Contact Message";
    // This is for breadcrumbs if I want a custom title other than the default

    $page_subheading = "Send a message to your contact";
    // This is the subheading

    $custom_class = "contact-message-page";
    //custom CSS for this page only

    include_once(SHARED_PATH . '/site_header.php');
include_once(SHARED_PATH . '/navigation.php');
?>

<div class="container <?php echo $custom_class; ?>">

    <section>
        <?php include_once(SHARED_PATH . '/headline-page.php');?>
    </section>

    <div class="row">
        <div class="col">
            <section class="">
                <h2 class="h3"><span class="font-weight-bold">Private:</span> For Test use ONLY</h2>
                <p>Write and send an email to contact list members.</p>

                <?php

                    if ( (!empty($subject)) && (!empty($text)) ) {
                        $dbc = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME)
                        or die('Error connecting to MySQL server.');

                        $query = "SELECT * FROM contact_list WHERE id='" . $id . "'";
                        $result = mysqli_query($dbc, $query)
                        or die('Error querying database.');

                        while ($row = mysqli_fetch_array($result)){
                            $to = $row['email'];
                            $first_name = $row['first_name'];
                            $last_name = $row['last_name'];
                            $msg = "Dear $first_name $last_name,\n$text";
                            mail($to, $subject, $msg, 'From:' . $from);
                            echo '<div class="border border-warning p-4">Message sent to: ' . $to . '</div>';
                        }

                        mysqli_close($dbc);
                    }
                ?>

                <div class="content w-75 mx-auto">

                    <a class="btn btn-outline-info mb-4 font-weight-bold" href="<?php echo url_for('/contacts/index.php'); ?>">&laquo; Back to List</a>

                    <?php if ($output_form): ?>
                        <form method="post" action="<?php echo url_for('/contact-message.php?id=' . h(u($contact['id']))); ?>">

                            <div class="h5">Contact: <?php echo h($contact['first_name']) . " " . h($contact['last_name']); ?></div>
                            <div class="h5 mb-3">Address: <?php echo h($contact['email']); ?></div>

                            <hr>

                            <label for="subject">Subject of email:</label><br />
                            <input id="subject" name="subject" type="text" value="<?php echo $subject; ?>" size="30" /><br />

                            <label for="emailtext">Body of email:</label><br />
                            <textarea name="emailtext" rows="8" cols="40"><?php echo $text; ?></textarea><br />

                            <input class="btn" type="submit" name="submit" value="Send Message" />
                        </form>
                    <?php endif; ?>
                </div>
            </section>
        </div><!-- end .col -->
    </div><!-- end .row -->

</div><!-- end .container -->
<?php include_once(SHARED_PATH . '/site_footer.php'); ?>

