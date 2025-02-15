<?php
declare(strict_types=1);

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../../config/bootstrap.php');

try {
    // Extract all required services
    $urlHelper = $app['urlHelper'];
    $htmlHelper = $app['htmlHelper'];
    $sessionHelper = $app['sessionHelper'];
    $requestHelper = $app['requestHelper'];
    $settingsManager = $app['settingsManager'];
    $userManager = $app['userManager'];
    $recordService = $app['recordService'];
    $config = $app['config'];
    
    // Check user status
    if (!$sessionHelper->isLoggedIn()) {
        $sessionHelper->setMessage('Please login to add records');
        $urlHelper->redirect('../index.php');
    }

    // Initialize error array
    $errors = [];

    if ($requestHelper->isPost()) {
        // Get form data
        $formData = [
            'title' => $requestHelper->post('title'),
            'artist' => $requestHelper->post('artist'),
            'genre' => $requestHelper->post('genre'),
            'release_year' => $requestHelper->post('release_year'),
            'label' => $requestHelper->post('label'),
            'catalog_number' => $requestHelper->post('catalog_number'),
            'format' => $requestHelper->post('format'),
            'speed' => $requestHelper->post('speed'),
            'condition' => $requestHelper->post('condition'),
            'purchase_date' => $requestHelper->post('purchase_date'),
            'purchase_price' => $requestHelper->post('purchase_price'),
            'notes' => $requestHelper->post('notes'),
            'purchase_link' => $requestHelper->post('purchase_link'),
            'audio_file_url' => $requestHelper->post('audio_file_url'),
            'bpm' => $requestHelper->post('bpm')
        ];

        // Define the upload directory
        $uploadDir = ROOT_PATH . '/public/uploads/';

        // Ensure the directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Handle file uploads
        $formData['front_image'] = null;
        $formData['back_image'] = null;

        if (!empty($_FILES['front_image']['name'])) {
            $frontImageFilename = time() . '_' . basename($_FILES['front_image']['name']);
            $formData['front_image'] = 'uploads/' . $frontImageFilename;
            move_uploaded_file($_FILES['front_image']['tmp_name'], $uploadDir . $frontImageFilename);
        }

        if (!empty($_FILES['back_image']['name'])) {
            $backImageFilename = time() . '_' . basename($_FILES['back_image']['name']);
            $formData['back_image'] = 'uploads/' . $backImageFilename;
            move_uploaded_file($_FILES['back_image']['tmp_name'], $uploadDir . $backImageFilename);
        }

        try {
            $record = $recordService->create($formData);
            $sessionHelper->setMessage('Record added successfully!');
            $urlHelper->redirect('../index.php');
        } catch (Exception $e) {
            $errors[] = "Error adding record: " . $e->getMessage();
        }
    }

    // Include the header with access to all services
    include(ROOT_PATH . '/templates/layouts/header.php');
} catch (Exception $e) {
    error_log("Error in add record: " . $e->getMessage());
    $sessionHelper->setMessage("Error: " . $e->getMessage());
    $urlHelper->redirect('../index.php');
}
?>

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= $htmlHelper->escape($error) ?></li>
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
                        <a href="<?= $urlHelper->urlFor('/index.php') ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>

<?php include(ROOT_PATH . '/templates/layouts/footer.php'); ?> 