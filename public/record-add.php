<?php

require_once('../src/initialize.php');
require_once('../src/Fivetwofive/KrateCMS/UserManager.php');

use Fivetwofive\KrateCMS\UserManager;

// Initialize the UserManager with the existing $db connection
$userManager = new UserManager($db);
$userManager->checkLoggedIn();

// Function to add a vinyl record with the purchase link and audio file URL
function addVinylRecord($title, $artist, $genre, $release_year, $label, $catalog_number, $format, $speed, $condition, $purchase_date, $purchase_price, $notes, $front_image_path, $back_image_path, $purchase_link, $audio_file_url, $bpm) {
    global $db;

    // SQL query to insert the record with image paths, purchase link, and audio file URL
    $sql = "INSERT INTO vinyl_records (title, artist, genre, release_year, label, catalog_number, format, speed, `condition`, purchase_date, purchase_price, notes, front_image, back_image, purchase_link, audio_file_url, bpm)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($db, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssssssdsssssi', $title, $artist, $genre, $release_year, $label, $catalog_number, $format, $speed, $condition, $purchase_date, $purchase_price, $notes, $front_image_path, $back_image_path, $purchase_link, $audio_file_url, $bpm);
    return mysqli_stmt_execute($stmt);
}

// Initialize error array
$errors = [];

// Example usage: Adding a new vinyl record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $genre = $_POST['genre'];
    $release_year = $_POST['release_year'];
    $label = $_POST['label'];
    $catalog_number = $_POST['catalog_number'];
    $format = $_POST['format'];
    $speed = $_POST['speed'];
    $condition = $_POST['condition'];
    $purchase_date = $_POST['purchase_date'];
    $purchase_price = $_POST['purchase_price'];
    $notes = $_POST['notes'];
    $purchase_link = $_POST['purchase_link'] ?? null;
    $audio_file_url = $_POST['audio_file_url'] ?? null;
    $bpm = $_POST['bpm'] ?? null;

    // Server-side validation for purchase_price
    if (!preg_match('/^\d+(\.\d{1,2})?$/', $purchase_price)) {
        $errors[] = "Please enter a valid purchase price (e.g., 24.95).";
    } else {
        // Convert the input to a float for the database
        $purchase_price = floatval($purchase_price);
    }

    // Define the upload directory within the 'records' directory
    $upload_dir = '../public/uploads/';

    // Ensure the directory exists, create it if not
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);  // Create the directory if it doesn't exist
    }

    $front_image_path = null;
    $back_image_path = null;

    // Handle front image upload
    if (!empty($_FILES['front_image']['name'])) {
        $front_image_filename = basename($_FILES['front_image']['name']);
        $front_image_path = $upload_dir . $front_image_filename;
        move_uploaded_file($_FILES['front_image']['tmp_name'], $front_image_path);
    }

    // Handle back image upload
    if (!empty($_FILES['back_image']['name'])) {
        $back_image_filename = basename($_FILES['back_image']['name']);
        $back_image_path = $upload_dir . $back_image_filename;
        move_uploaded_file($_FILES['back_image']['tmp_name'], $back_image_path);
    }

    // Proceed only if there are no validation errors
    if (empty($errors)) {
        // Call the function to add the record with image paths, purchase link, and audio file URL
        if (addVinylRecord($title, $artist, $genre, $release_year, $label, $catalog_number, $format, $speed, $condition, $purchase_date, $purchase_price, $notes, $front_image_path, $back_image_path, $purchase_link, $audio_file_url, $bpm)) {
            $success_message = "Record added successfully!";
        } else {
            $errors[] = "Error adding record.";
        }
    }
}

include('../templates/layouts/header.php');
?>

    <div class="container py-4">
        <div class="row">
            <div class="col-12">

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (!empty($success_message)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success_message; ?>
                    </div>
                <?php endif; ?>

                <h1 class="mb-4">My Vinyl Records Collection</h1>
                <section class="border p-4 mb-4">
                    <form method="POST" action="record-add.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title<span class="required">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" required>
                        </div>

                        <div class="form-group">
                            <label for="artist">Artist</label>
                            <input type="text" class="form-control" id="artist" name="artist" placeholder="Artist" required>
                        </div>

                        <div class="form-group">
                            <label for="genre">Genre</label>
                            <input type="text" class="form-control" id="genre" name="genre" placeholder="Genre">
                        </div>

                        <div class="form-group">
                            <label for="release_year">Release Year</label>
                            <input type="number" class="form-control" id="release_year" name="release_year" placeholder="Release Year">
                        </div>

                        <div class="form-group">
                            <label for="bpm">Beats Per Minute</label>
                            <input type="number" class="form-control" id="bpm" name="bpm" placeholder="BPM">
                        </div>

                        <div class="form-group">
                            <label for="label">Label</label>
                            <input type="text" class="form-control" id="label" name="label" placeholder="Label">
                        </div>

                        <div class="form-group">
                            <label for="catalog_number">Catalog Number</label>
                            <input type="text" class="form-control" id="catalog_number" name="catalog_number" placeholder="Catalog Number">
                        </div>

                        <div class="form-group">
                            <label for="format">Format</label>
                            <select class="form-control" id="format" name="format">
                                <option value="12&quot;">12"</option>
                                <option value="10&quot;">10"</option>
                                <option value="7&quot;">7"</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="speed">Speed</label>
                            <select class="form-control" id="speed" name="speed">
                                <option value="33 1/3 RPM">33 1/3 RPM</option>
                                <option value="45 RPM">45 RPM</option>
                                <option value="78 RPM">78 RPM</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="condition">Condition</label>
                            <select class="form-control" id="condition" name="condition">
                                <option value="Mint">Mint</option>
                                <option value="Near Mint">Near Mint</option>
                                <option value="Very Good">Very Good</option>
                                <option value="Good">Good</option>
                                <option value="Fair">Fair</option>
                                <option value="Poor">Poor</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="purchase_date">Purchase Date</label>
                            <input type="date" class="form-control" id="purchase_date" name="purchase_date">
                        </div>

                        <div class="form-group">
                            <label for="purchase_price">Purchase Price</label>
                            <input type="text" class="form-control" id="purchase_price" name="purchase_price" placeholder="Purchase Price" pattern="^\d+(\.\d{1,2})?$" title="Please enter a valid price (e.g., 24.95)" required>
                        </div>

                        <div class="form-group">
                            <label for="purchase_link">Purchase Link</label>
                            <input type="url" class="form-control" id="purchase_link" name="purchase_link" placeholder="Enter URL (optional)">
                        </div>

                        <div class="form-group">
                            <label for="purchase_link">Audio File URL</label>
                            <input type="url" name="audio_file_url" placeholder="Audio File URL">
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" placeholder="Notes"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="front_image">Front Image</label>
                            <input type="file" class="form-control" id="front_image" name="front_image" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label for="back_image">Back Image</label>
                            <input type="file" class="form-control" id="back_image" name="back_image" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">Add Record</button>
                    </form>
                </section>
            </div>
        </div>
    </div>

<?php include('../templates/layouts/footer.php'); ?>