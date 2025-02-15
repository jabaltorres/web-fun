<?php
declare(strict_types=1);

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../config/bootstrap.php');

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
    $isAdmin = $sessionHelper->getCurrentUserId() ? 
        $userManager->isAdmin($sessionHelper->getCurrentUserId()) : 
        false;
    
    // Get the search term from the query string if provided
    $searchTerm = $requestHelper->get('search');
    
    // Get all records using the service
    $records = $recordService->findAll($searchTerm);
    
    // Include the header with access to all services
    include(ROOT_PATH . '/templates/layouts/header.php');
} catch (Exception $e) {
    error_log("Error in index page: " . $e->getMessage());
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<div class="hero">
    <div class="jumbotron jumbotron-fluid px-4">
        <div class="container text-center">
            <h1 class='display-4'><?= $htmlHelper->escape($settingsManager->getSetting('site_name')) ?></h1>
            <p class='lead'><?= $htmlHelper->escape($settingsManager->getSetting('site_tagline')) ?></p>

            <!-- Search Form -->
            <form class="form-inline d-block mx-auto" action="index.php" method="GET">
                <input type="text" 
                       name="search" 
                       class="form-control mr-2 mb-2 mb-md-0" 
                       placeholder="Search by Title or Artist" 
                       value="<?= $htmlHelper->escape($searchTerm ?? '') ?>">
                <button type="submit" class="btn btn-primary">Search</button>
                <a href="index.php" class="btn btn-outline-secondary ml-2">Clear</a>
            </form>
        </div>
    </div>
</div>

<div class="container py-4 border mb-5">
    <div class="row">
        <div class="col-12 col-md-6">
            <h2>All Vinyl Records</h2>
        </div>

        <div class="col-12 col-md-6">
            <div class="action text-right">
                <a class="btn btn-primary mb-4" href="<?= $urlHelper->urlFor('records/add.php') ?>">Add New Record</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <section class="record-table">
                <?php if (!empty($records)): ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Artist</th>
                                <th>Release Year</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($records as $record): ?>
                                <tr>
                                    <td>
                                        <a href="<?= $urlHelper->urlFor('/records/details.php?id=' . $record->getId()) ?>">
                                            <?= $htmlHelper->escape($record->getTitle()) ?>
                                        </a>
                                    </td>
                                    <td><?= $htmlHelper->escape($record->getArtist()) ?></td>
                                    <td><?= $record->getReleaseYear() ?></td>
                                    <td>
                                        <a href="<?= $urlHelper->urlFor('/records/details.php?id=' . $record->getId()) ?>" 
                                           class="btn btn-info btn-sm">View Details</a>
                                        <?php if ($loggedIn): ?>
                                            <a href="<?= $urlHelper->urlFor('/records/edit.php?id=' . $record->getId()) ?>" 
                                               class="btn btn-secondary btn-sm ml-1 mr-2">Edit Details</a>
                                            <a href="<?= $urlHelper->urlFor('/records/delete.php?id=' . $record->getId()) ?>" 
                                               class="btn btn-danger btn-sm">Delete Record</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No records found.</p>
                <?php endif; ?>
            </section>
        </div>
    </div>
</div>

<?php
try {
    include(ROOT_PATH . '/templates/layouts/footer.php');
} catch (Exception $e) {
    error_log("Error in footer: " . $e->getMessage());
    echo "Error loading footer: " . $e->getMessage();
}
?>