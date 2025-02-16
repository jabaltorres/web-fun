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
        $sessionHelper->setMessage('Please login to edit records');
        $urlHelper->redirect('../index.php');
    }

    $recordId = $requestHelper->get('id');
    if (!$recordId) {
        throw new Exception("Record ID not provided");
    }

    // Get existing record
    $record = $recordService->findById((int)$recordId);
    if (!$record) {
        throw new Exception("Record not found");
    }

    if ($requestHelper->isPost()) {
        // Handle file uploads
        $uploadDir = ROOT_PATH . '/public/uploads/';
        
        // Ensure upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $frontImagePath = $requestHelper->post('existing_front_image');
        $backImagePath = $requestHelper->post('existing_back_image');

        if (!empty($_FILES['front_image']['name'])) {
            $frontImageFilename = time() . '_' . basename($_FILES['front_image']['name']);
            $frontImagePath = 'uploads/' . $frontImageFilename;
            move_uploaded_file($_FILES['front_image']['tmp_name'], $uploadDir . $frontImageFilename);
        }

        if (!empty($_FILES['back_image']['name'])) {
            $backImageFilename = time() . '_' . basename($_FILES['back_image']['name']);
            $backImagePath = 'uploads/' . $backImageFilename;
            move_uploaded_file($_FILES['back_image']['tmp_name'], $uploadDir . $backImageFilename);
        }

        // Update record
        $recordService->update((int)$recordId, [
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
            'front_image' => $frontImagePath,
            'back_image' => $backImagePath,
            'purchase_link' => $requestHelper->post('purchase_link'),
            'audio_file_url' => $requestHelper->post('audio_file_url'),
            'bpm' => $requestHelper->post('bpm')
        ]);

        $sessionHelper->setMessage('Record updated successfully!');
        $urlHelper->redirect('details.php?id=' . $recordId);
    }

    // Include the header with access to all services
    include(ROOT_PATH . '/templates/shared/header.php');
} catch (Exception $e) {
    error_log("Error in edit record: " . $e->getMessage());
    $sessionHelper->setMessage("Error: " . $e->getMessage());
    $urlHelper->redirect('../index.php');
}
?>

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Edit Vinyl Record: <?= $htmlHelper->escape($record->getTitle()) ?> by <?= $htmlHelper->escape($record->getArtist()) ?></h1>

            <form method="POST" action="edit.php?id=<?= $record->getId() ?>" enctype="multipart/form-data">
                <div class="actions mb-4">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a class="btn btn-info" href="<?= $urlHelper->urlFor('/records/details.php?id=' . $record->getId()) ?>">View Record</a>
                </div>

                <div class="form-group">
                    <label for="title">Title <span class="required">*</span></label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= $htmlHelper->escape($record->getTitle()) ?>" required>
                </div>

                <div class="form-group">
                    <label for="artist">Artist <span class="required">*</span></label>
                    <input type="text" class="form-control" id="artist" name="artist" value="<?= $htmlHelper->escape($record->getArtist()) ?>" required>
                </div>

                <div class="form-group">
                    <label for="genre">Genre</label>
                    <input type="text" class="form-control" id="genre" name="genre" value="<?= $htmlHelper->escape($record->getGenre()) ?>">
                </div>

                <div class="form-group">
                    <label for="release_year">Release Year</label>
                    <input type="number" class="form-control" id="release_year" name="release_year" value="<?= $record->getReleaseYear(); ?>">
                </div>

                <div class="form-group">
                    <label for="label">Label</label>
                    <input type="text" class="form-control" id="label" name="label" value="<?= $htmlHelper->escape($record->getLabel()) ?>">
                </div>

                <div class="form-group">
                    <label for="catalog_number">Catalog Number</label>
                    <input type="text" class="form-control" id="catalog_number" name="catalog_number" value="<?= $htmlHelper->escape($record->getCatalogNumber()) ?>">
                </div>

                <div class="form-group">
                    <label for="format">Format</label>
                    <select class="form-control" id="format" name="format">
                        <option value="12&quot;" <?= ($record->getFormat() == '12"') ? 'selected' : ''; ?>>12"</option>
                        <option value="10&quot;" <?= ($record->getFormat() == '10"') ? 'selected' : ''; ?>>10"</option>
                        <option value="7&quot;" <?= ($record->getFormat() == '7"') ? 'selected' : ''; ?>>7"</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="speed">Speed</label>
                    <select class="form-control" id="speed" name="speed">
                        <option value="33 1/3 RPM" <?= ($record->getSpeed() == '33 1/3 RPM') ? 'selected' : ''; ?>>33 1/3 RPM</option>
                        <option value="45 RPM" <?= ($record->getSpeed() == '45 RPM') ? 'selected' : ''; ?>>45 RPM</option>
                        <option value="78 RPM" <?= ($record->getSpeed() == '78 RPM') ? 'selected' : ''; ?>>78 RPM</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="condition">Condition</label>
                    <select class="form-control" id="condition" name="condition">
                        <option value="Mint" <?= ($record->getCondition() == 'Mint') ? 'selected' : ''; ?>>Mint</option>
                        <option value="Near Mint" <?= ($record->getCondition() == 'Near Mint') ? 'selected' : ''; ?>>Near Mint</option>
                        <option value="Very Good" <?= ($record->getCondition() == 'Very Good') ? 'selected' : ''; ?>>Very Good</option>
                        <option value="Good" <?= ($record->getCondition() == 'Good') ? 'selected' : ''; ?>>Good</option>
                        <option value="Fair" <?= ($record->getCondition() == 'Fair') ? 'selected' : ''; ?>>Fair</option>
                        <option value="Poor" <?= ($record->getCondition() == 'Poor') ? 'selected' : ''; ?>>Poor</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="purchase_date">Purchase Date</label>
                    <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="<?= $record->getPurchaseDate(); ?>">
                </div>

                <div class="form-group">
                    <label for="purchase_price">Purchase Price</label>
                    <input type="text" class="form-control" id="purchase_price" name="purchase_price" value="<?= $record->getPurchasePrice(); ?>">
                </div>

                <div class="form-group">
                    <label for="bpm">Beats Per Minute</label>
                    <input type="number" class="form-control" id="bpm" name="bpm" value="<?= $record->getBpm(); ?>">
                </div>

                <div class="form-group">
                    <label for="purchase_link">Purchase Link</label>
                    <input type="url" class="form-control" id="purchase_link" name="purchase_link" value="<?= $htmlHelper->escape($record->getPurchaseLink()); ?>" placeholder="Enter URL (optional)">
                </div>

                <div class="form-group">
                    <label for="audio_file_url">Audio File URL</label>
                    <input type="url" class="form-control" id="audio_file_url" name="audio_file_url" value="<?= $htmlHelper->escape($record->getAudioFileUrl()); ?>" placeholder="Enter URL (optional)">
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea class="form-control" id="notes" name="notes"><?= $htmlHelper->escape($record->getNotes()); ?></textarea>
                </div>

                <!-- Front Image -->
                <div class="form-group">
                    <label for="front_image">Front Image</label>
                    <input type="file" class="form-control" id="front_image" name="front_image" accept="image/*">
                    <?php if ($record->getFrontImage()): ?>
                        <p>Current Front Image: 
                            <img src="<?= $urlHelper->urlFor('/uploads/' . basename($record->getFrontImage())) ?>" 
                                 alt="Front Image" 
                                 style="max-width: 100px;">
                        </p>
                        <input type="hidden" name="existing_front_image" value="<?= $htmlHelper->escape($record->getFrontImage()) ?>">
                    <?php endif; ?>
                </div>

                <!-- Back Image -->
                <div class="form-group">
                    <label for="back_image">Back Image</label>
                    <input type="file" class="form-control" id="back_image" name="back_image" accept="image/*">
                    <?php if ($record->getBackImage()): ?>
                        <p>Current Back Image: 
                            <img src="<?= $urlHelper->urlFor('/uploads/' . basename($record->getBackImage())) ?>" 
                                 alt="Back Image" 
                                 style="max-width: 100px;">
                        </p>
                        <input type="hidden" name="existing_back_image" value="<?= $htmlHelper->escape($record->getBackImage()) ?>">
                    <?php endif; ?>
                </div>

                <div class="actions">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a class="btn btn-info" href="<?= $urlHelper->urlFor('/records/details.php?id=' . $record->getId()) ?>">View Record</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include(ROOT_PATH . '/templates/shared/footer.php'); ?> 