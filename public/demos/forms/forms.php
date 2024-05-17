<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../private/initialize.php');

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
        $jtMessage = [];
        $jtMessage['name'] = $_POST['name'] ?? '';
        $jtMessage['subject'] = $_POST['subject'] ?? '';
        $jtMessage['email'] = $_POST['email'] ?? '';
        $jtMessage['message'] = $_POST['message'] ?? '';
    }

    $title = "Form Page"; // this is for <title>
    $page_title = "This is the form page";
    $page_subheading = "Make your own bacon ipsum";

    include_once(SHARED_PATH . '/site_header.php');
?>

<?php include_once(SHARED_PATH . '/navigation.php'); ?>

<div class="container">

    <section class="forms">

        <header>
            <h1 class="h2"><?php echo $page_title; ?></h1>
            <h2 class="h3"><?php echo $page_subheading; ?></h2>
        </header>

        <?php echo display_errors($errors); ?>

        <form method="post" action="<?php echo url_for('../forms/forms.php'); ?>">

            <div class="form-group">
                <label for="exampleFormControlInput1">Full Name:</label>
                <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="John Smith" value="<?php echo h($jtMessage['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="exampleFormControlInput2">Email address:</label>
                <input type="email" name="email" class="form-control" id="exampleFormControlInput2" placeholder="name@example.com" value="<?php echo h($jtMessage['email']); ?>"required>
            </div>

            <div class="form-group">
                <label for="exampleFormControlSelect1">Subject</label>
                <select class="form-control" name="subject" id="exampleFormControlSelect1">
                    <option <?php if($jtMessage['subject'] == "Hello") echo 'selected="selected"';?>>Hello</option>
                    <option <?php if($jtMessage['subject'] == "Compliment") echo 'selected="selected"';?>>Compliment</option>
                    <option <?php if($jtMessage['subject'] == "Insult") echo 'selected="selected"';?>>Insult</option>
                    <option <?php if($jtMessage['subject'] == "Inquiry") echo 'selected="selected"';?>>Inquiry</option>
                    <option <?php if($jtMessage['subject'] == "Sales Pitch") echo 'selected="selected"';?>>Sales Pitch</option>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleFormControlTextarea1">Message:</label>
                <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3" required><?php echo h($jtMessage['message']); ?></textarea>
            </div>

            <input type="submit" name="send" value="Send Message" class="btn btn-primary">
        </form>
    </section>
</div>

<?php include_once(SHARED_PATH . '/site-footer.php'); ?>