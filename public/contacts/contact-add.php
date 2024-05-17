<?php
require_once('../../private/initialize.php');
require_login();

$title = "Add Email";
$page_heading = "Create a new contact";
$page_subheading = "Test the database functionality";
$custom_class = "add-email-page";

include_once(SHARED_PATH . '/site-header.php');
include_once(SHARED_PATH . '/navigation.php');
?>

<div class="container <?php echo $custom_class; ?>">

    <section id="form-section">
        <?php include_once(SHARED_PATH . '/headline-page.php'); ?>

        <?php
        if (isset($_POST['submit'])) {
            $first_name = $_POST['firstname'];
            $last_name = $_POST['lastname'];
            $email = $_POST['email'];
            $output_form = 'no';

            if (empty($first_name) || empty($last_name) || empty($email)) {
                echo 'Please fill out all of the email information.<br />';
                $output_form = 'yes';
            } else {
                $dbc = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('Error connecting to MySQL server.');
                $query = "INSERT INTO contact_list (first_name, last_name, email) VALUES (?, ?, ?)";

                $stmt = mysqli_prepare($dbc, $query);
                mysqli_stmt_bind_param($stmt, 'sss', $first_name, $last_name, $email);

                if (mysqli_stmt_execute($stmt)) {
                    echo '<h4 class="mb-4">Entry added for: ' . htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name) . '</h4>';
                } else {
                    if (mysqli_errno($dbc) == 1062) {
                        echo '<h4 class="mb-4 error">Error: The email address ' . htmlspecialchars($email) . ' is already in use.</h4>';
                    } else {
                        echo '<h4 class="mb-4 error">An error occurred while inserting the data. Please try again later.</h4>';
                    }
                }

                mysqli_stmt_close($stmt);
                mysqli_close($dbc);
            }
        } else {
            $output_form = 'yes';
        }

        if ($output_form == 'yes'): ?>
            <form id="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="firstname" id="name-label">First name:</label>
                <input type="text" id="firstname" name="firstname" /><br />
                <label for="lastname">Last name:</label>
                <input type="text" id="lastname" name="lastname" /><br />
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" /><br />
                <input type="submit" name="submit" value="Submit" id="button" class="btn btn-primary" />
            </form>
        <?php endif; ?>

    </section>
</div>

<?php include_once(SHARED_PATH . '/site-footer.php'); ?>
