<?php

require_once('../../src/initialize.php');

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
            <p><strong>Genre:</strong> <?php echo $record['genre']; ?></p>
            <p><strong>Release Year:</strong> <?php echo $record['release_year']; ?></p>
            <p><strong>Label:</strong> <?php echo $record['label']; ?></p>
            <p><strong>Catalog Number:</strong> <?php echo $record['catalog_number']; ?></p>
            <p><strong>Format:</strong> <?php echo $record['format']; ?></p>
            <p><strong>Speed:</strong> <?php echo $record['speed']; ?></p>
            <p><strong>Condition:</strong> <?php echo $record['condition']; ?></p>
            <p><strong>Purchase Date:</strong> <?php echo $record['purchase_date']; ?></p>
            <p><strong>Purchase Price:</strong> $<?php echo number_format($record['purchase_price'], 2); ?></p>
            <p><strong>Notes:</strong> <?php echo $record['notes']; ?></p>

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
    </div>
</div>

<?php include('../../templates/layout/footer.php'); ?>