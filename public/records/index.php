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

// Check if there's a message in the query string
$message = $_GET['message'] ?? null;

include('../../templates/layout/header.php');
?>

<div class="container py-4">
    <div class="row">
        <div class="col-12">

            <!-- Display the success message if it exists -->
            <?php if ($message): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <h1 class="mb-4">My Vinyl Records Collection</h1>

            <a class="btn btn-primary mb-4" href="<?php echo url_for('/records/record-add.php'); ?>">Add New Record</a>

            <section class="border p-4">
                <h2>All Vinyl Records</h2>

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
                                <td><?php echo htmlspecialchars($record['title']); ?></td>
                                <td><?php echo htmlspecialchars($record['artist']); ?></td>
                                <td><?php echo htmlspecialchars($record['release_year']); ?></td>
                                <td class="text-right">
                                    <a href="<?php echo url_for('/records/record-details.php?id=' . $record['record_id']); ?>" class="btn btn-info btn-sm">View Details</a>
                                    <a href="<?php echo url_for('/records/record-edit.php?id=' . $record['record_id']); ?>" class="btn btn-secondary btn-sm">Edit Details</a>
                                    <a href="<?php echo url_for('/records/record-delete.php?id=' . $record['record_id']); ?>" class="btn btn-danger btn-sm">Delete Record</a>
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

<?php include('../../templates/layout/footer.php'); ?>