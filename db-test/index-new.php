<?php
    require_once('private/initialize.php');



  $title = "DB Page"; 
  // this is for <title>

  $page_heading = "This is the home page";
  // This is for breadcrumbs if I want a custom title other than the default

  $page_subheading = "Welcome to the DB test page"; 
  // This is the subheading

  $custom_class = "db-test-page"; 
  //custom CSS for this page only


$contact_set = find_all_contacts();


  include_once(INCLUDES_PATH . '/head.php');
?>

<div class="container <?php echo $custom_class; ?>">
    <?php
        include_once(INCLUDES_PATH . '/masthead.php');
        include_once(INCLUDES_PATH . '/navigation.php');
        include_once(INCLUDES_PATH . '/email-db-nav.php');
    ?>

    <?php //TODO: Put all DB test files in one directory ?>

    <section>
        <?php include_once(INCLUDES_PATH . '/headline-page.php');?>
        <?php include_once(INCLUDES_PATH . '/db-menu.php');?>
    </section>

    <section>
        <a href="/globe-bank/public/staff/index.php">WIP - Globe Bank Staff Area</a>
    </section>

    <section>
        <h4>Database Entries</h4>

        <table class="table list">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>

            <?php while($contact = mysqli_fetch_assoc($contact_set)) { ?>
                <tr>
                    <td><?php echo h($contact['id']); ?></td>
                    <td><?php echo h($contact['first_name']); ?></td>
                    <td><?php echo h($contact['last_name']); ?></td>
                    <td><?php echo h($contact['email']); ?></td>
                    <td><a class="action" href="<?php echo url_for('/staff/subjects/show.php?id=' . h(u($subject['id']))); ?>">View</a></td>
                    <td><a class="action" href="<?php echo url_for('edit.php?id=' . h(u($contact['id']))); ?>">Edit</a></td>
                    <td><a class="action" href="<?php echo url_for('/staff/subjects/delete.php?id=' . h(u($subject['id']))); ?>">Delete</a></td>
                </tr>
            <?php } ?>
        </table>

        <?php mysqli_free_result($subject_set); ?>
    </section>

  <?php include '../includes/feet.php';?>