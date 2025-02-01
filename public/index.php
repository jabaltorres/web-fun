<?php

require_once('../src/initialize.php');

use Fivetwofive\KrateCMS\UserManager;

try {
    // Initialize the UserManager with the existing $db connection
    $userManager = new UserManager($db);

    // Use isLoggedIn to check if the user is logged in for conditional content display
    $loggedIn = $userManager->isLoggedIn();

    // Check if the user is an administrator
    $isAdmin = isset($_SESSION['user_id']) ? $userManager->isAdmin($_SESSION['user_id']) : false;

    /**
     * Get all vinyl records from the database, optionally filtered by a search term.
     *
     * @param string|null $search_term The search term to filter records by title or artist.
     * @return array|null Returns an array of records, or null if no records are found or on failure.
     */
    function getAllVinylRecords(?string $search_term = null): ?array {
        global $db;

        // Base SQL query
        $sql = "SELECT * FROM vinyl_records";

        // If a search term is provided, filter the results by title or artist
        if ($search_term) {
            $sql .= " WHERE title LIKE ? OR artist LIKE ? ORDER BY created_at DESC";
            $stmt = mysqli_prepare($db, $sql);
            $search_term = '%' . $search_term . '%'; // Add wildcards for partial matching
            mysqli_stmt_bind_param($stmt, 'ss', $search_term, $search_term);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        } else {
            $sql .= " ORDER BY created_at DESC";
            $result = mysqli_query($db, $sql);
        }

        // Fetch all records and return as an associative array or null if no results
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        
        return null;
    }

    // Get the search term from the query string if provided
    $search_term = $_GET['search'] ?? null;

    // Display all vinyl records, filtered by search term if provided
    $records = getAllVinylRecords($search_term);

    // Check if there's a message in the query string
    $message = $_GET['message'] ?? null;

} catch (Exception $e) {
    error_log("Error in index page: " . $e->getMessage());
    $error = "An error occurred while loading the page.";
}

include('../templates/layout/header.php');
?>
    <div class="hero">
        <div class="jumbotron jumbotron-fluid px-4">
            <div class="container text-center">

                <h1 class="display-4"><?= $settingsManager->getSetting('site_name'); ?></h1>
                <p class="lead"><?= $settingsManager->getSetting('site_tagline'); ?></p>

                <!-- Search Form -->
                <form class="form-inline d-block mx-auto" action="index.php" method="GET">
                    <input type="text" name="search" class="form-control mr-2 mb-2 mb-md-0" placeholder="Search by Title or Artist" value="<?php echo htmlspecialchars($search_term); ?>">
                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="index.php" class="btn btn-outline-secondary ml-2">Clear</a>
                </form>
            </div>
        </div>
    </div>
    <div class="container py-4 border mb-5">
        <div class="row">
            <div class="col-12 col-md-6">
                <h2>All Vinyl Records</h2>
            </div>

            <div class="col-12 col-md-6">
                <div class="action text-right">
                    <a class="btn btn-primary mb-4" href="<?php echo url_for('record-add.php'); ?>">Add New Record</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">

                <!-- Display the success message if it exists -->
                <?php if ($message): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>

                <section class="record-table">
                    <?php if (!empty($records)): ?>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Artist</th>
                                <th>Release Year</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($records as $record): ?>
                                <tr>
                                    <td>
                                      <a href="<?php echo url_for('/record-details.php?id=' . $record['record_id']); ?>">
                                          <?php echo htmlspecialchars($record['title']); ?>
                                      </a>
                                    </td>
                                    <td><?php echo htmlspecialchars($record['artist']); ?></td>
                                    <td><?php echo htmlspecialchars($record['release_year']); ?></td>
                                    <td>
                                        <a href="<?php echo url_for('/record-details.php?id=' . $record['record_id']); ?>" class="btn btn-info btn-sm">View Details</a>
                                        <?php
                                            if ($loggedIn) {
                                                echo '<a href="' . url_for('/record-edit.php?id=' . $record['record_id']) . '" class="btn btn-secondary btn-sm ml-1 mr-2">Edit Details</a>';
                                                echo '<a href="' . url_for('/record-delete.php?id=' . $record['record_id']) . '" class="btn btn-danger btn-sm">Delete Record</a>';
                                            }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No records found.</p>
                    <?php endif; ?>
                </section>
            </div>
        </div>
    </div>

    <?php include('../templates/layout/footer.php'); ?>