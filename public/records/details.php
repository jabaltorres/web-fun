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
    $loggedIn = $sessionHelper->isLoggedIn();
    
    // Get record ID from query string
    $recordId = $requestHelper->get('id');
    
    if (!$recordId) {
        throw new Exception("Record ID not provided");
    }
    
    // Get the record using RecordService
    $record = $recordService->findById((int)$recordId);
    
    if (!$record) {
        throw new Exception("Record not found");
    }
    
    // Include the header with access to all services
    include(ROOT_PATH . '/templates/layouts/header.php');
} catch (Exception $e) {
    error_log("Error in record details: " . $e->getMessage());
    $sessionHelper->setMessage("Error: " . $e->getMessage());
    $urlHelper->redirect('../index.php');
}
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
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4"><?= $htmlHelper->escape($record->getTitle()) ?></h1>
        </div>

        <div id="record-img-audio" class="col-12 col-lg-6">
            <?php if ($record->getFrontImage()): ?>
                <img class="record-img record-img-front" 
                     src="<?= $urlHelper->urlFor('/uploads/' . basename($record->getFrontImage())) ?>" 
                     alt="Front of Record">
                <p>Front Image</p>
            <?php else: ?>
                <img class="record-img record-img-front" 
                     src="<?= $urlHelper->urlFor('/assets/images/vinyl-record.png') ?>" 
                     alt="Placeholder Record Image">
                <p>Placeholder Image</p>
            <?php endif; ?>

            <?php if ($record->getBackImage()): ?>
                <img class="record-img record-img-front" 
                     src="<?= $urlHelper->urlFor('/uploads/' . basename($record->getBackImage())) ?>" 
                     alt="Back of Record">
                <p>Back Image</p>
            <?php endif; ?>

            <?php if ($record->getAudioFileUrl()): ?>
                <div class="mb-4">
                    <audio class="audio-player" controls loop>
                        <source src="<?= $htmlHelper->escape($record->getAudioFileUrl()) ?>" type="audio/mp3">
                    </audio>
                </div>
            <?php endif; ?>

            <?php if ($record->getPurchaseLink()): ?>
                <div class="d-lg-none mb-4 mb-lg-0">
                    <a href="<?= $htmlHelper->escape($record->getPurchaseLink()) ?>" 
                       target="_blank" 
                       class="btn btn-primary">Purchase</a>
                </div>
            <?php endif; ?>

            <div class="col-12 actions mb-5">
                <a class="btn btn-outline-info font-weight-bold" 
                   href="<?= $urlHelper->urlFor('/index.php') ?>">&laquo; Back to List</a>
                <?php if ($loggedIn) : ?>
                    <a class="btn btn-warning" 
                       href="<?= $urlHelper->urlFor('/records/edit.php?id=' . $record->getId()) ?>">Edit Record</a>
                    <a class="btn btn-danger" 
                       href="<?= $urlHelper->urlFor('/records/delete.php?id=' . $record->getId()) ?>">Delete Record</a>
                <?php endif; ?>
            </div>
        </div>

        <div id="record-details" class="col-12 col-lg-6">
            <p class="h3"><strong>Title:</strong> <?= $htmlHelper->escape($record->getTitle()) ?></p>
            <p class="h4"><strong>Artist:</strong> <?= $htmlHelper->escape($record->getArtist()) ?></p>

            <div class="details mb-4">
                <?php if ($record->getGenre()): ?>
                    <div><strong>Genre:</strong> <?= $htmlHelper->escape($record->getGenre()) ?></div>
                <?php endif; ?>

                <?php if ($record->getReleaseYear()): ?>
                    <div><strong>Release Year:</strong> <?= $record->getReleaseYear() ?></div>
                <?php endif; ?>

                <?php if ($record->getLabel()): ?>
                    <div><strong>Label:</strong> <?= $htmlHelper->escape($record->getLabel()) ?></div>
                <?php endif; ?>

                <?php if ($record->getCatalogNumber()): ?>
                    <div><strong>Catalog Number:</strong> <?= $htmlHelper->escape($record->getCatalogNumber()) ?></div>
                <?php endif; ?>

                <?php if ($record->getFormat()): ?>
                    <div><strong>Format:</strong> <?= $htmlHelper->escape($record->getFormat()) ?></div>
                <?php endif; ?>

                <?php if ($record->getSpeed()): ?>
                    <div><strong>Speed:</strong> <?= $htmlHelper->escape($record->getSpeed()) ?></div>
                <?php endif; ?>

                <?php if ($record->getBpm()): ?>
                    <div><strong>Beats Per Minute:</strong> <?= $record->getBpm() ?></div>
                <?php endif; ?>

                <?php if ($record->getCondition()): ?>
                    <div><strong>Condition:</strong> <?= $htmlHelper->escape($record->getCondition()) ?></div>
                <?php endif; ?>

                <?php if ($record->getPurchaseDate()): ?>
                    <div><strong>Purchase Date:</strong> <?= $htmlHelper->escape($record->getPurchaseDate()) ?></div>
                <?php endif; ?>

                <?php if ($record->getPurchasePrice()): ?>
                    <div><strong>Purchase Price:</strong> $<?= number_format($record->getPurchasePrice(), 2) ?></div>
                <?php endif; ?>

                <?php if ($record->getNotes()): ?>
                    <p><strong>Notes:</strong> <?= $htmlHelper->escape($record->getNotes()) ?></p>
                <?php endif; ?>
            </div>

            <?php if ($record->getPurchaseLink()): ?>
                <div>
                    <a href="<?= $htmlHelper->escape($record->getPurchaseLink()) ?>" 
                       target="_blank" 
                       class="btn btn-primary">Purchase</a>
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
            audioPlayer.addEventListener('play', function () {
                recordImage.classList.add('rotate');
            });

            audioPlayer.addEventListener('pause', function () {
                recordImage.classList.remove('rotate');
            });

            audioPlayer.addEventListener('ended', function () {
                recordImage.classList.remove('rotate');
            });
        }
    });
</script>

<?php include(ROOT_PATH . '/templates/layouts/footer.php'); ?> 