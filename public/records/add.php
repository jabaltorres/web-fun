<?php
declare(strict_types=1);

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../../config/bootstrap.php');

use Fivetwofive\KrateCMS\Services\UserManager;
use Fivetwofive\KrateCMS\Services\RecordService;
use Fivetwofive\KrateCMS\Core\Helpers\RequestHelper;
use Fivetwofive\KrateCMS\Core\Helpers\HtmlHelper;
use Fivetwofive\KrateCMS\Core\Helpers\UrlHelper;
use Fivetwofive\KrateCMS\Core\Helpers\SessionHelper;

try {
    // Get dependencies from app container
    $db = $app['db'];
    $settingsManager = $app['settingsManager'];
    $recordService = $app['recordService'];
    $userManager = $app['userManager'];
    
    // Check user status
    if (!SessionHelper::isLoggedIn()) {
        header('Location: ../index.php?message=' . urlencode('Please login to add records'));
        exit;
    }

    // Initialize error array
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = RequestHelper::post('title');
        $artist = RequestHelper::post('artist');
        $genre = RequestHelper::post('genre');
        $release_year = RequestHelper::post('release_year');
        $label = RequestHelper::post('label');
        $catalog_number = RequestHelper::post('catalog_number');
        $format = RequestHelper::post('format');
        $speed = RequestHelper::post('speed');
        $condition = RequestHelper::post('condition');
        $purchase_date = RequestHelper::post('purchase_date');
        $purchase_price = RequestHelper::post('purchase_price');
        $notes = RequestHelper::post('notes');
        $purchase_link = RequestHelper::post('purchase_link');
        $audio_file_url = RequestHelper::post('audio_file_url');
        $bpm = RequestHelper::post('bpm');

        // Define the upload directory
        $upload_dir = __DIR__ . '/../../public/uploads/';

        // Ensure the directory exists
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Handle file uploads
        $front_image_path = null;
        $back_image_path = null;

        if (!empty($_FILES['front_image']['name'])) {
            $front_image_filename = time() . '_' . basename($_FILES['front_image']['name']);
            $front_image_path = 'uploads/' . $front_image_filename;
            move_uploaded_file($_FILES['front_image']['tmp_name'], $upload_dir . $front_image_filename);
        }

        if (!empty($_FILES['back_image']['name'])) {
            $back_image_filename = time() . '_' . basename($_FILES['back_image']['name']);
            $back_image_path = 'uploads/' . $back_image_filename;
            move_uploaded_file($_FILES['back_image']['tmp_name'], $upload_dir . $back_image_filename);
        }

        try {
            $record = $recordService->create([
                'title' => $title,
                'artist' => $artist,
                'genre' => $genre,
                'release_year' => $release_year,
                'label' => $label,
                'catalog_number' => $catalog_number,
                'format' => $format,
                'speed' => $speed,
                'condition' => $condition,
                'purchase_date' => $purchase_date,
                'purchase_price' => $purchase_price,
                'notes' => $notes,
                'front_image' => $front_image_path,
                'back_image' => $back_image_path,
                'purchase_link' => $purchase_link,
                'audio_file_url' => $audio_file_url,
                'bpm' => $bpm
            ]);

            header('Location: ../index.php?message=' . urlencode('Record added successfully!'));
            exit;
        } catch (Exception $e) {
            $errors[] = "Error adding record: " . $e->getMessage();
        }
    }

} catch (Exception $e) {
    error_log("Error in add record: " . $e->getMessage());
    $errors[] = "An error occurred while processing your request.";
}

include(__DIR__ . '/../../templates/layouts/header.php');
?>

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= HtmlHelper::escape($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <h1 class="mb-4">Add New Vinyl Record</h1>
            <section class="border p-4 mb-4">
                <form method="POST" action="add.php" enctype="multipart/form-data">
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
                        <label for="audio_file_url">Audio File URL</label>
                        <input type="url" class="form-control" id="audio_file_url" name="audio_file_url" placeholder="Audio File URL">
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

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add Record</button>
                        <a href="<?= UrlHelper::generate('/index.php'); ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../../templates/layouts/footer.php'); ?> 