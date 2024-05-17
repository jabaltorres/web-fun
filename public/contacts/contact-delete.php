<?php
require_once('../../private/initialize.php');

require_login();

    if(!isset($_GET['id'])) {
        redirect_to(url_for('/staff/subjects/index.php'));
    }
    $id = $_GET['id'];

    if(is_post_request()) {

        $result = delete_contact($id);
        redirect_to(url_for('/contacts/index.php'));

    } else {
        $subject = find_contact_by_id($id);
    }

    $contact = find_contact_by_id($id);

    $title = "DB Test | Delete Contact";
    // this is for <title>

    $page_heading = "Delete Contact";
    // This is for breadcrumbs if I want a custom title other than the default

    $page_subheading = "Welcome to the DB test page";
    // This is the subheading

    $custom_class = "db-test-page";
    //custom CSS for this page only

include_once(SHARED_PATH . '/site_header.php');
include_once(SHARED_PATH . '/navigation.php');
?>

<div class="container <?php echo $custom_class; ?>">

    <section>
        <?php include_once(SHARED_PATH . '/headline-page.php');?>
        <?php include_once(SHARED_PATH . '/nav-contacts.php');?>
    </section>

    <div class="row">
        <div class="col">
            <section>
                <div id="content" class="">
                    <a class="btn btn-outline-info mb-4 font-weight-bold" href="<?php echo url_for('/contacts/index.php'); ?>">&laquo; Back to List</a>

                    <div class="contact show mb-4">

                        <h1 class="h3 text-danger font-weight-bold">Delete Contact</h1>
                        <p>Are you sure you want to delete this contact?</p>

                        <form action="<?php echo url_for('/contacts/contact-delete.php?id=' . h(u($contact['id']))); ?>" method="post">

                            <p class="h4">Contact: <?php echo h($contact['first_name']) . " " . h($contact['last_name'] ); ?></p>

                            <div class="attributes mb-4">
                                <dl class="mb-2">
                                    <dt>First Name</dt>
                                    <dd class="font-weight-bold h5"><?php echo h($contact['first_name']); ?></dd>
                                </dl>
                                <dl class="mb-2">
                                    <dt>Last Name</dt>
                                    <dd class="font-weight-bold h5"><?php echo h($contact['last_name']); ?></dd>
                                </dl>
                                <dl class="mb-2">
                                    <dt>Email</dt>
                                    <dd class="font-weight-bold h5"><?php echo h($contact['email']); ?></dd>
                                </dl>

                                <dl class="mb-2">
                                    <dt>Comments</dt>
                                    <dd class="font-weight-bold h5"><?php echo h($contact['comments']); ?></dd>
                                </dl>
                            </div><!-- end .attributes -->

                            <div id="operations">
                                <input type="submit" name="commit" class="btn btn-danger" value="Delete Contact" />
                            </div>

                        </form>
                    </div><!-- end .contact -->

                </div><!-- end #content -->
            </section>
        </div><!-- end .col -->
    </div><!-- end .row -->

</div><!-- end .container -->
<?php include_once(SHARED_PATH . '/site_footer.php'); ?>