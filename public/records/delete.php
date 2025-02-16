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
        $sessionHelper->setMessage('Please login to delete records');
        $urlHelper->redirect('../index.php');
    }

    $recordId = $requestHelper->get('id');
    if (!$recordId) {
        throw new Exception("Record ID not provided");
    }

    // Get the record
    $record = $recordService->findById((int)$recordId);
    if (!$record) {
        throw new Exception("Record not found");
    }

    // Handle deletion
    if ($requestHelper->isPost()) {
        $recordService->delete((int)$recordId);
        $sessionHelper->setMessage('Record deleted successfully');
        $urlHelper->redirect('../index.php');
    }

    // Include the header with access to all services
    include(ROOT_PATH . '/templates/shared/header.php');
} catch (Exception $e) {
    error_log("Error in delete record: " . $e->getMessage());
    $sessionHelper->setMessage("Error: " . $e->getMessage());
    $urlHelper->redirect('../index.php');
}
?>

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Delete Vinyl Record: <?= $htmlHelper->escape($record->getTitle()) ?> by <?= $htmlHelper->escape($record->getArtist()) ?></h1>

            <p>Are you sure you want to delete the following record?</p>

            <ul>
                <li><strong>Title:</strong> <?= $htmlHelper->escape($record->getTitle()) ?></li>
                <li><strong>Artist:</strong> <?= $htmlHelper->escape($record->getArtist()) ?></li>
                <li><strong>Genre:</strong> <?= $htmlHelper->escape($record->getGenre()) ?></li>
                <li><strong>Release Year:</strong> <?= $record->getReleaseYear() ?></li>
                <li><strong>Label:</strong> <?= $htmlHelper->escape($record->getLabel()) ?></li>
                <li><strong>Catalog Number:</strong> <?= $htmlHelper->escape($record->getCatalogNumber()) ?></li>
                <li><strong>Format:</strong> <?= $htmlHelper->escape($record->getFormat()) ?></li>
                <li><strong>Speed:</strong> <?= $htmlHelper->escape($record->getSpeed()) ?></li>
                <li><strong>Condition:</strong> <?= $htmlHelper->escape($record->getCondition()) ?></li>
                <li><strong>Purchase Date:</strong> <?= $htmlHelper->escape($record->getPurchaseDate()) ?></li>
                <li><strong>Purchase Price:</strong> $<?= number_format($record->getPurchasePrice(), 2) ?></li>
                <li><strong>Notes:</strong> <?= $htmlHelper->escape($record->getNotes()) ?></li>
                
                <?php if ($record->getFrontImage()): ?>
                    <li><strong>Front Image:</strong> 
                        <img src="<?= $urlHelper->urlFor('/uploads/' . basename($record->getFrontImage())) ?>" 
                             alt="Front Image" 
                             style="max-width: 100px;">
                    </li>
                <?php endif; ?>
                
                <?php if ($record->getBackImage()): ?>
                    <li><strong>Back Image:</strong> 
                        <img src="<?= $urlHelper->urlFor('/uploads/' . basename($record->getBackImage())) ?>" 
                             alt="Back Image" 
                             style="max-width: 100px;">
                    </li>
                <?php endif; ?>
            </ul>

            <form method="POST" action="delete.php?id=<?= $record->getId() ?>">
                <button type="submit" class="btn btn-danger">Delete Record</button>
                <a href="<?= $urlHelper->urlFor('/records/edit.php?id=' . $record->getId()) ?>" 
                   class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php include(ROOT_PATH . '/templates/shared/footer.php'); ?> 