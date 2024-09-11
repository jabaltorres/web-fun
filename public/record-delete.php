<?php

require_once('../src/initialize.php');


require_once('../src/classes/KrateUserManager.php');

use Fivetwofive\KrateCMS\KrateUserManager;

// Initialize the KrateUserManager with the existing $db connection
$userManager = new KrateUserManager($db);

$userManager->checkLoggedIn();

// Function to delete the vinyl record
function deleteVinylRecord($id) {
    global $db;

    // Prepare the SQL statement
    $sql = "DELETE FROM vinyl_records WHERE record_id = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    return mysqli_stmt_execute($stmt);
}

// Function to get the vinyl record details
function getVinylRecordById($id): ?array {
    global $db;

    $sql = "SELECT * FROM vinyl_records WHERE record_id = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result) ?: null;  // Return the record or null if not found
}

// Check if the form has been submitted (delete action)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $record_id = $_GET['id'] ?? null;

    if (!$record_id) {
        echo "Record not found!";
        exit;
    }

    // Delete the record
    if (deleteVinylRecord($record_id)) {
        // Redirect to a list or another page after deletion
        header("Location: index.php?message=Record deleted successfully");
        exit;
    } else {
        echo "Error deleting record.";
        exit;
    }
}

// If GET request, display the confirmation prompt
$record_id = $_GET['id'] ?? null;

if (!$record_id) {
    echo "Record not found!";
    exit;
}

// Fetch the record details for confirmation
$record = getVinylRecordById($record_id);

if (!$record) {
    echo "Record not found!";
    exit;
}

include('../templates/layout/header.php');
?>

    <div class="container py-4">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Delete Vinyl Record: <?php echo $record['title']; ?> by <?php echo $record['artist']; ?></h1>

                <p>Are you sure you want to delete the following record?</p>

                <ul>
                    <li><strong>Title:</strong> <?php echo $record['title']; ?></li>
                    <li><strong>Artist:</strong> <?php echo $record['artist']; ?></li>
                    <li><strong>Genre:</strong> <?php echo $record['genre']; ?></li>
                    <li><strong>Release Year:</strong> <?php echo $record['release_year']; ?></li>
                    <li><strong>Label:</strong> <?php echo $record['label']; ?></li>
                    <li><strong>Catalog Number:</strong> <?php echo $record['catalog_number']; ?></li>
                    <li><strong>Format:</strong> <?php echo $record['format']; ?></li>
                    <li><strong>Speed:</strong> <?php echo $record['speed']; ?></li>
                    <li><strong>Condition:</strong> <?php echo $record['condition']; ?></li>
                    <li><strong>Purchase Date:</strong> <?php echo $record['purchase_date']; ?></li>
                    <li><strong>Purchase Price:</strong> $<?php echo number_format($record['purchase_price'], 2); ?></li>
                    <li><strong>Notes:</strong> <?php echo $record['notes']; ?></li>
                    <!-- If you have images -->
                    <?php if (!empty($record['front_image'])): ?>
                        <li><strong>Front Image:</strong> <img src="<?php echo '/uploads/' . basename($record['front_image']); ?>" alt="Front Image" style="max-width: 100px;"></li>
                    <?php endif; ?>
                    <?php if (!empty($record['back_image'])): ?>
                        <li><strong>Back Image:</strong> <img src="<?php echo '/uploads/' . basename($record['back_image']); ?>" alt="Back Image" style="max-width: 100px;"></li>
                    <?php endif; ?>
                </ul>

                <form method="POST" action="record-delete.php?id=<?php echo $record['record_id']; ?>">
                    <button type="submit" class="btn btn-danger">Delete Record</button>
                    <a href="record-edit.php?id=<?php echo $record['record_id']; ?>" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

<?php include('../templates/layout/footer.php'); ?>