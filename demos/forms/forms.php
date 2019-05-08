<?php
    require_once '../../private/initialize.php';

    if ( is_post_request() ) {
        $jtMessage = [];
        $jtMessage['name'] = $_POST['name'] ?? '';
        $jtMessage['email'] = $_POST['email'] ?? '';
        $jtMessage['subject'] = $_POST['subject'] ?? '';
        $jtMessage['message'] = $_POST['message'] ?? '';

//        echo $jtMessage['name'] . '<br>';
//        echo $jtMessage['email'] . '<br>';
//        echo $jtMessage['subject'] . '<br>';
//        echo $jtMessage['message'] . '<br>';

        // https://php.net/manual/en/function.print-r.php
//        print_r ($jtMessage);

        $errors = validate_jt_test_form($jtMessage);

    } else {

    }

    $title = "Form Page"; // this is for <title>
    $page_title = "This is the form page";
    $page_subheading = "Make your own bacon ipsum";

    include_once(INCLUDES_PATH . '/site-header.php');
?>

<div class="container">
    <?php include_once(INCLUDES_PATH . '/masthead.php'); ?>
    <?php include_once(INCLUDES_PATH . '/navigation.php'); ?>

    <section class="forms">

        <header>
            <h1 class="h2"><?php echo $page_title; ?></h1>
            <h2 class="h3"><?php echo $page_subheading; ?></h2>
        </header>

        <?php echo display_errors($errors); ?>

        <form method="post" action="<?php echo url_for('../forms/forms.php'); ?>">

            <div class="form-group">
                <label for="exampleFormControlInput1">Full Name:</label>
                <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="John Smith" required>
            </div>

            <div class="form-group">
                <label for="exampleFormControlInput2">Email address:</label>
                <input type="email" name="email" class="form-control" id="exampleFormControlInput2" placeholder="name@example.com" required>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1">Subject</label>
                <select class="form-control" name="subject" id="exampleFormControlSelect1">
                    <option>Hello</option>
                    <option>Compliment</option>
                    <option>Insult</option>
                    <option>Inquiry</option>
                    <option>Sales Pitch</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Message:</label>
                <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3" required></textarea>
            </div>

            <input type="submit" name="send" value="Send Message" class="btn btn-primary">
        </form>
    </section>
</div>

<?php include_once(INCLUDES_PATH . '/site-footer.php'); ?>