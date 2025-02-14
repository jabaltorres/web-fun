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
        header('Location: ../index.php?message=' . urlencode('Please login to delete records'));
        exit;
    }

    $record_id = RequestHelper::get('id');
    if (!$record_id) {
        throw new Exception("Record ID not provided");
    }

    // Get the record
    $record = $recordService->findById((int)$record_id);
    if (!$record) {
        throw new Exception("Record not found");
    }

    // Handle deletion
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $recordService->delete((int)$record_id);
        SessionHelper::setMessage('Record deleted successfully');
        header('Location: ../index.php');
        exit;
    }

} catch (Exception $e) {
    error_log("Error in delete record: " . $e->getMessage());
    SessionHelper::setMessage("Error: " . $e->getMessage());
    header('Location: ../index.php');
    exit;
}

include(__DIR__ . '/../../templates/layouts/header.php');
?>

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Delete Vinyl Record: <?= HtmlHelper::escape($record->getTitle()); ?> by <?= HtmlHelper::escape($record->getArtist()); ?></h1>

            <p>Are you sure you want to delete the following record?</p>

            <ul>
                <li><strong>Title:</strong> <?= HtmlHelper::escape($record->getTitle()); ?></li>
                <li><strong>Artist:</strong> <?= HtmlHelper::escape($record->getArtist()); ?></li>
                <li><strong>Genre:</strong> <?= HtmlHelper::escape($record->getGenre()); ?></li>
                <li><strong>Release Year:</strong> <?= $record->getReleaseYear(); ?></li>
                <li><strong>Label:</strong> <?= HtmlHelper::escape($record->getLabel()); ?></li>
                <li><strong>Catalog Number:</strong> <?= HtmlHelper::escape($record->getCatalogNumber()); ?></li>
                <li><strong>Format:</strong> <?= HtmlHelper::escape($record->getFormat()); ?></li>
                <li><strong>Speed:</strong> <?= HtmlHelper::escape($record->getSpeed()); ?></li>
                <li><strong>Condition:</strong> <?= HtmlHelper::escape($record->getCondition()); ?></li>
                <li><strong>Purchase Date:</strong> <?= HtmlHelper::escape($record->getPurchaseDate()); ?></li>
                <li><strong>Purchase Price:</strong> $<?= number_format($record->getPurchasePrice(), 2); ?></li>
                <li><strong>Notes:</strong> <?= HtmlHelper::escape($record->getNotes()); ?></li>
                
                <?php if ($record->getFrontImage()): ?>
                    <li><strong>Front Image:</strong> <img src="<?= UrlHelper::generate('/uploads/' . basename($record->getFrontImage())); ?>" alt="Front Image" style="max-width: 100px;"></li>
                <?php endif; ?>
                
                <?php if ($record->getBackImage()): ?>
                    <li><strong>Back Image:</strong> <img src="<?= UrlHelper::generate('/uploads/' . basename($record->getBackImage())); ?>" alt="Back Image" style="max-width: 100px;"></li>
                <?php endif; ?>
            </ul>

            <form method="POST" action="delete.php?id=<?= $record->getId(); ?>">
                <button type="submit" class="btn btn-danger">Delete Record</button>
                <a href="<?= UrlHelper::generate('/records/edit.php?id=' . $record->getId()); ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php include(__DIR__ . '/../../templates/layouts/footer.php'); ?> 