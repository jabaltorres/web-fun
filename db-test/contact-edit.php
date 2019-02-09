<?php
    require_once('private/initialize.php');

require_login();

    if(!isset($_GET['id'])) {
      redirect_to(url_for('/index.php'));
    }
    $id = $_GET['id'];

    if(is_post_request()) {

      // Handle form values sent by new.php

      $contact = [];
      $contact['id'] = $id;
      $contact['first_name'] = $_POST['first_name'] ?? '';
      $contact['last_name'] = $_POST['last_name'] ?? '';
      $contact['email'] = $_POST['email'] ?? '';

      $result = update_contact($contact);
      if($result === true) {
        redirect_to(url_for('/index.php'));
      } else {
        $errors = $result;
        //var_dump($errors);
      }

    } else {

      $contact = find_contact_by_id($id);

    }

    // my original code
    $title = "Edit Contact";
    // this is for <title>

    $page_heading = "Edit the contact";
    // This is for breadcrumbs if I want a custom title other than the default

    $page_subheading = "Test the database functionality";
    // This is the subheading

    $custom_class = "edit-contact-page";
    //custom CSS for this page only

    include_once(INCLUDES_PATH . '/site-header.php');

?>

<div class="container <?php echo $custom_class; ?>">

    <?php include_once(INCLUDES_PATH . '/masthead.php'); ?>
    <?php include_once(INCLUDES_PATH . '/navigation.php'); ?>

    <section id="form-section">
        <?php include_once(INCLUDES_PATH . '/headline-page.php');?>

        <?php echo display_errors($errors); ?>

        <a class="btn btn-outline-info mb-4 font-weight-bold" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to List</a>

        <form id="form" method="post" action="<?php echo url_for('/contact-edit.php?id=' . h(u($id))); ?>">
            <label for="first_name">First name:</label>
            <input type="text" name="first_name" value="<?php echo h($contact['first_name']); ?>" /><br />

            <label for="last_name">Last name:</label>
            <input type="text" name="last_name" value="<?php echo h($contact['last_name']); ?>" /><br />

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?php echo h($contact['email']); ?>" /><br />

            <input type="submit" name="submit" value="Edit Contact" id="button" class="btn btn-warning" />
            <a class="btn btn-danger" href="<?php echo url_for('/contact-remove.php'); ?>">Delete Contact(s)</a>

        </form>
    </section>
</div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');?>






