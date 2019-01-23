<?php
// Start the session
require_once('startsession.php');

// Insert the page header
$page_title = 'Where opposites attract!';
require_once( 'includes/header.php' );

require_once('appvars.php');
require_once('connectvars.php');

// Show the navigation menu
require_once( 'includes/navmenu.php' );

// Connect to the database
$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Retrieve the user data from MySQL
$query = "SELECT user_id, first_name FROM db_test_users WHERE first_name IS NOT NULL ORDER BY first_name DESC LIMIT 5";
$data = mysqli_query($dbc, $query);

// Loop through the array of user data, formatting it as HTML
echo '<h4>Latest members:</h4>';
echo '<table>';
while ($row = mysqli_fetch_array($data)) {

	if (isset($_SESSION['user_id'])) {
		echo '<td><a href="viewprofile.php?user_id=' . $row['user_id'] . '">' . $row['first_name'] . '</a></td></tr>';
	}
	else {
		echo '<td>' . $row['first_name'] . '</td></tr>';
	}
}
echo '</table>';

mysqli_close($dbc);
?>

<?php
// Insert the page footer
require_once( 'includes/footer.php' );
?>
