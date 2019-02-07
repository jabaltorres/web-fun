<?php require_once '../config.php';?>
<?php include '../includes/site-header.php';?>
<div class="container">
    <?php include '../includes/masthead.php';?>
    <?php include '../includes/navigation.php';?>

    <section>
        <h2>Remove Contact(s)</h2>
        <p>Please select the contact(s) to delete from `email_list` and click Remove.</p>

        <a class="btn btn-outline-info mb-4 font-weight-bold" href="<?php echo '/db-test/index.php'; ?>">&laquo; Back to List</a>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

            <?php
                $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or die('Error connecting to MySQL server.');

                // Delete the customer rows (only if the form has been submitted)
                if (isset($_POST['submit'])) {
                    foreach ($_POST['todelete'] as $delete_id) {
                        $query = "DELETE FROM email_list WHERE id='" . $delete_id ."'";
                        mysqli_query($dbc, $query)
                        or die('Error querying database.');
                    }
                    echo "Contact(s) removed.<br />";
                }

                // Display the customer rows with checkboxes for deleting
                $query = "SELECT * FROM email_list";
                $result = mysqli_query($dbc, $query);
                while ($row = mysqli_fetch_array($result)) {
                    echo '<input type="checkbox" value="' . $row['id'] . '" name="todelete[]" />';
                    echo $row['first_name'];
                    echo ' ' . $row['last_name'];
                    echo ' ' . $row['email'];
                    echo '<br />';
                }

                mysqli_close($dbc);
            ?>

            <input type="submit" name="submit" value="Remove" class="btn btn-primary mt-4" />
        </form>
    </section>
</div>

<?php include '../includes/site-footer.php';?>