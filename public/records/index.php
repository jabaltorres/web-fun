<?php

require_once('../../src/initialize.php');

/**
 * Get all vinyl records from the database.
 *
 * @return array|null Returns an array of records, or null if no records are found or on failure.
 */
function getAllVinylRecords(): ?array {
    global $db;

    // Prepare an SQL statement
    $sql = "SELECT * FROM vinyl_records ORDER BY created_at DESC";
    $result = mysqli_query($db, $sql);

    // Fetch all records and return as an associative array or null if no results
    if ($result && mysqli_num_rows($result) > 0) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        return null;  // Return null if the query fails or no records are found
    }
}

// Display all vinyl records
$records = getAllVinylRecords();

include('../../templates/layout/header.php');
?>

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">My Vinyl Records Collection</h1>

            <a class="btn btn-primary mb-4" href="<?php echo url_for('/records/record-add.php'); ?>">Add New Record</a>

            <section class="border p-4">
                <h2>All Vinyl Records</h2>
                <ul>
                    <?php foreach ($records as $record): ?>
                        <li>
                            <?php echo $record['title'] . ' by ' . $record['artist'] . ' (' . $record['release_year'] . ')'; ?>
                            <a href="<?php echo url_for('/records/record-details.php?id=' . $record['record_id']); ?>">View Details</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
        </div>
    </div>
</div>

<?php include('../../templates/layout/footer.php'); ?>