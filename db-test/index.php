<?php
    require_once('private/initialize.php');

    $title = "DB Test Page";
    // this is for <title>

    $page_heading = "This is the DB Test page";
    // This is for breadcrumbs if I want a custom title other than the default

    $page_subheading = "Welcome to the DB test page";
    // This is the subheading

    $custom_class = "db-test-page";
    //custom CSS for this page only

    $contact_set = find_all_contacts();
    // From globe_bank tutorial


  include_once(INCLUDES_PATH . '/site-header.php');
?>

<div class="container <?php echo $custom_class; ?>">
    <?php
        include_once(INCLUDES_PATH . '/masthead.php');
        include_once(INCLUDES_PATH . '/navigation.php');
    ?>

    <section>
        <?php include_once(INCLUDES_PATH . '/headline-page.php');?>
        <?php include_once(INCLUDES_PATH . '/db-menu.php');?>
    </section>

    <section>
        <a href="/globe-bank/public/staff/index.php">WIP - Globe Bank Staff Area</a>
    </section>

    <section>
        <h4 class="mb-4 h4 font-weight-bold">Contact Entries</h4>

        <table class="table table-striped border">
            <thead class="thead-dark">
            <tr>
                <th scope="col" class="font-weight-bold">ID</th>
                <th scope="col" class="font-weight-bold">First Name</th>
                <th scope="col" class="font-weight-bold">Last Name</th>
                <th scope="col" class="font-weight-bold">Email</th>
                <th scope="col">&nbsp;</th>
                <th scope="col">&nbsp;</th>
                <th scope="col">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
                <?php while($contact = mysqli_fetch_assoc($contact_set)): ?>
                    <tr class="">
                        <td class="align-middle"><?php echo h($contact['id']); ?></td>
                        <td class="align-middle"><?php echo h($contact['first_name']); ?></td>
                        <td class="align-middle"><?php echo h($contact['last_name']); ?></td>
                        <td class="align-middle"><?php echo h($contact['email']); ?></td>
                        <td><a class="action btn btn-sm btn-info d-block mx-auto" href="<?php echo url_for('/staff/subjects/show.php?id=' . h(u($subject['id']))); ?>">View</a></td>
                        <td><a class="action btn btn-sm btn-warning d-block mx-auto" href="<?php echo url_for('edit.php?id=' . h(u($contact['id']))); ?>">Edit</a></td>
                        <td><a class="action btn btn-sm btn-danger d-block mx-auto" href="<?php echo url_for('/staff/subjects/delete.php?id=' . h(u($subject['id']))); ?>">Delete</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php mysqli_free_result($subject_set); ?>
    </section>

</div><!-- end .container -->
<?php include '../includes/site-footer.php';?>