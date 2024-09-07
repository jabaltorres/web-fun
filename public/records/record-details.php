<?php

require_once('../../src/initialize.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/classes/KrateUserManager.php');

use Fivetwofive\KrateCMS\KrateUserManager;

// Initialize the KrateUserManager with the existing $db connection
$userManager = new KrateUserManager($db);

// Use isLoggedIn to check if the user is logged in for conditional content display
$loggedIn = $userManager->isLoggedIn();

// Fetch the record_id from the query string
$record_id = $_GET['id'] ?? null;

if (!$record_id) {
    echo "Record not found!";
    exit;
}

// Function to get a specific vinyl record by ID
function getVinylRecordById($id): ?array {
    global $db;

    // Prepare SQL query
    $sql = "SELECT * FROM vinyl_records WHERE record_id = ?";
    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch and return the record details
    return mysqli_fetch_assoc($result) ?: null;  // Return the record or null if not found
}

// Get the record details
$record = getVinylRecordById($record_id);

if (!$record) {
    echo "Record not found!";
    exit;
}

include('../../templates/layout/header.php');
?>

<style>
    .record-img {
        margin-bottom: 1rem;
        max-width: 500px;
    }
</style>

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4"><?php echo $record['title']; ?> by <?php echo $record['artist']; ?></h1>

            <a class="btn btn-outline-info mb-4 font-weight-bold" href="<?php echo url_for('/records/index.php'); ?>">&laquo; Back to List</a>

            <div><strong>Genre:</strong> <?php echo $record['genre']; ?></div>
            <div><strong>Release Year:</strong> <?php echo $record['release_year']; ?></div>
            <div><strong>Label:</strong> <?php echo $record['label']; ?></div>
            <div><strong>Catalog Number:</strong> <?php echo $record['catalog_number']; ?></div>
            <div><strong>Format:</strong> <?php echo $record['format']; ?></div>
            <div><strong>Speed:</strong> <?php echo $record['speed']; ?></div>
            <div><strong>Condition:</strong> <?php echo $record['condition']; ?></div>
            <div><strong>Purchase Date:</strong> <?php echo $record['purchase_date']; ?></div>
            <div><strong>Purchase Price:</strong> $<?php echo number_format($record['purchase_price'], 2); ?></div>
            <div><strong>Notes:</strong> <?php echo $record['notes']; ?></div>
            <?php if (!empty($record['purchase_link'])): ?>
                <p><strong>Purchase / Audio Link:</strong> <a href="<?php echo htmlspecialchars($record['purchase_link']); ?>" target="_blank">Buy or Listen</a></p>
            <?php endif; ?>

            <!-- Display the front image if available -->
            <?php if (!empty($record['front_image'])): ?>
                <p><strong>Front Image:</strong></p>
                <img class="record-img record-img-front" src="<?php echo '/records/uploads/' . basename($record['front_image']); ?>" alt="Front of Record">
            <?php endif; ?>

            <!-- Display the back image if available -->
            <?php if (!empty($record['back_image'])): ?>
                <p><strong>Back Image:</strong></p>
                <img class="record-img record-img-front" src="<?php echo '/records/uploads/' . basename($record['back_image']); ?>" alt="Back of Record">
            <?php endif; ?>
        </div>

        <?php if ($loggedIn) : ?>
            <div class="col-12">
                <a class="btn btn-primary" href="<?php echo url_for('/records/record-edit.php?id=' . $record['record_id']); ?>">Edit Record</a>
                <a class="btn btn-danger" href="<?php echo url_for('/records/record-delete.php?id=' . $record['record_id']); ?>">Delete Record</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include('../../templates/layout/footer.php'); ?>