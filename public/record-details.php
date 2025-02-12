<?php

require_once('../src/initialize.php');

require_once('../src/Fivetwofive/KrateCMS/UserManager.php');

use Fivetwofive\KrateCMS\UserManager;

// Initialize the UserManager with the existing $db connection
$userManager = new UserManager($db);

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

include('../templates/layouts/header.php');
?>

<style>
    .record-img {
        margin-bottom: 1rem;
        max-width: 560px;
        transition: transform 0.5s ease-in-out, border-radius 0.5s ease-in-out;

    }

    .rotate {
        animation: spin 4s linear infinite;
        border-radius: 100%;
    }

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
</style>

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4"><?php echo $record['title']; ?></h1>
        </div>

        <div id="record-img-audio" class="col-12 col-lg-6">
            <!-- Display the front image if available -->
            <?php if (!empty($record['front_image'])): ?>
                <img class="record-img record-img-front" src="<?php echo '/uploads/' . basename($record['front_image']); ?>" alt="Front of Record">
                <p>Front Image</p>
            <?php else: ?>
                <!-- <img  class="record-img record-img-front" src="assets/images/placeholder/placeholder-1x1.png" alt="Placeholder Record Image"> -->
                <img  class="record-img record-img-front" src="assets/images/vinyl-record.png" alt="Placeholder Record Image">

                <p>Placeholder Image</p>
            <?php endif; ?>

            <!-- Display the back image if available -->
            <?php if (!empty($record['back_image'])): ?>
                <img class="record-img record-img-front" src="<?php echo '/uploads/' . basename($record['back_image']); ?>" alt="Back of Record">
                <p>Back Image</p>
            <?php endif; ?>

            <?php if (!empty($record['audio_file_url'])): ?>
                <div class="mb-4">
                    <audio class="audio-player" controls="1" loop=""><source src="<?php echo htmlspecialchars($record['audio_file_url']); ?>" type="audio/mp3"></audio>
                </div>
            <?php endif; ?>

            <?php if (!empty($record['purchase_link'])): ?>
                <div class="d-lg-none mb-4 mb-lg-0">
                    <a href="<?php echo htmlspecialchars($record['purchase_link']); ?>" target="_blank" class="btn btn-primary">Purchase</a>
                </div>
            <?php endif; ?>

            <div class="col-12 actions mb-5">
                <a class="btn btn-outline-info font-weight-bold" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to List</a>
                <?php if ($loggedIn) : ?>
                    <a class="btn btn-warning" href="<?php echo url_for('/record-edit.php?id=' . $record['record_id']); ?>">Edit Record</a>
                    <a class="btn btn-danger" href="<?php echo url_for('/record-delete.php?id=' . $record['record_id']); ?>">Delete Record</a>
                <?php endif; ?>
            </div>
        </div>
        <div id="record-details" class="col-12 col-lg-6">
            <?php if (!empty($record['title'])): ?>
                <p class="h3"><strong>Title:</strong> <?php echo $record['title']; ?></p>
            <?php endif; ?>

            <?php if (!empty($record['artist'])): ?>
                <p class="h4"><strong>Artist:</strong> <?php echo $record['artist']; ?></p>
            <?php endif; ?>

            <div class="details mb-4">
              <?php if (!empty($record['genre'])): ?>
                  <div><strong>Genre:</strong> <?php echo $record['genre']; ?></div>
              <?php endif; ?>

              <?php if (!empty($record['release_year'])): ?>
                  <div><strong>Release Year:</strong> <?php echo $record['release_year']; ?></div>
              <?php endif; ?>

              <?php if (!empty($record['label'])): ?>
                  <div><strong>Label:</strong> <?php echo $record['label']; ?></div>
              <?php endif; ?>

              <?php if (!empty($record['catalog_number'])): ?>
                  <div><strong>Catalog Number:</strong> <?php echo $record['catalog_number']; ?></div>
              <?php endif; ?>

              <?php if (!empty($record['format'])): ?>
                  <div><strong>Format:</strong> <?php echo $record['format']; ?></div>
              <?php endif; ?>

              <?php if (!empty($record['speed'])): ?>
                  <div><strong>Speed:</strong> <?php echo $record['speed']; ?></div>
              <?php endif; ?>

              <?php if (!empty($record['bpm'])): ?>
                  <div><strong>Beats Per Minute:</strong> <?php echo $record['bpm']; ?></div>
              <?php endif; ?>

              <?php if (!empty($record['condition'])): ?>
                  <div><strong>Condition:</strong> <?php echo $record['condition']; ?></div>
              <?php endif; ?>

              <?php if (!empty($record['purchase_date'])): ?>
                  <div><strong>Purchase Date:</strong> <?php echo $record['purchase_date']; ?></div>
              <?php endif; ?>

              <?php if (!empty($record['purchase_price'])): ?>
                  <div><strong>Purchase Price:</strong> $<?php echo number_format($record['purchase_price'], 2); ?></div>
              <?php endif; ?>

              <?php if (!empty($record['notes'])): ?>
                  <p><strong>Notes:</strong> <?php echo $record['notes']; ?></p>
              <?php endif; ?>
            </div>

            <?php if (!empty($record['purchase_link'])): ?>
                <div>
                    <a href="<?php echo htmlspecialchars($record['purchase_link']); ?>" target="_blank" class="btn btn-primary">Purchase</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const audioPlayer = document.querySelector('.audio-player');
        const recordImage = document.querySelector('.record-img-front');

        if (audioPlayer && recordImage) {
            // When the audio starts playing, add the 'rotate' class to the image
            audioPlayer.addEventListener('play', function () {
                recordImage.classList.add('rotate');
            });

            // When the audio pauses, remove the 'rotate' class from the image
            audioPlayer.addEventListener('pause', function () {
                recordImage.classList.remove('rotate');
            });

            // Also stop rotating when the audio ends
            audioPlayer.addEventListener('ended', function () {
                recordImage.classList.remove('rotate');
            });
        }
    });
</script>

<?php include('../templates/layouts/footer.php'); ?>