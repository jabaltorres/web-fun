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
    // Get dependencies from app container
    $db = $app['db'];
    $settingsManager = $app['settingsManager'];
    $recordService = $app['recordService'];
    $userManager = $app['userManager'];
    
    // Check user status
    $loggedIn = SessionHelper::isLoggedIn();
    $isAdmin = SessionHelper::getCurrentUserId() ? $userManager->isAdmin(SessionHelper::getCurrentUserId()) : false;
    
    // Get the search term from the query string if provided
    $searchTerm = RequestHelper::get('search');
    
    // Get all records using the service
    $records = $recordService->findAll($searchTerm);
    
    // Check if there's a message in the query string
    $message = SessionHelper::getAndClearMessage();
    
} catch (Exception $e) {
    error_log("Error in index page: " . $e->getMessage());
    echo "Error: " . $e->getMessage();
    $error = "An error occurred while loading the page.";
}

try {
    $headerPath = __DIR__ . '/../templates/layouts/header.php';
    if (!file_exists($headerPath)) {
        throw new Exception("Header template not found at: $headerPath");
    }
    include($headerPath);
} catch (Exception $e) {
    echo "Error in header: " . $e->getMessage();
}
?>
    <div class="hero">
        <div class="jumbotron jumbotron-fluid px-4">
            <div class="container text-center">
                <?php 
                try {
                    echo "<h1 class='display-4'>" . HtmlHelper::escape($settingsManager->getSetting('site_name')) . "</h1>";
                    echo "<p class='lead'>" . HtmlHelper::escape($settingsManager->getSetting('site_tagline')) . "</p>";
                } catch (Exception $e) {
                    echo "Error in settings: " . $e->getMessage();
                }
                ?>

                <!-- Search Form -->
                <form class="form-inline d-block mx-auto" action="index.php" method="GET">
                    <input type="text" name="search" class="form-control mr-2 mb-2 mb-md-0" placeholder="Search by Title or Artist" value="<?= HtmlHelper::escape($searchTerm ?? ''); ?>">
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
                    <a class="btn btn-primary mb-4" href="<?= UrlHelper::generate('records/add.php'); ?>">Add New Record</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">

                <!-- Display the success message if it exists -->
                <?php if ($message): ?>
                    <div class="alert alert-success" role="alert">
                        <?= HtmlHelper::escape($message); ?>
                    </div>
                <?php endif; ?>

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
                                        <a href="<?= UrlHelper::generate('/records/details.php?id=' . $record->getId()); ?>">
                                            <?= HtmlHelper::escape($record->getTitle()); ?>
                                        </a>
                                    </td>
                                    <td><?= HtmlHelper::escape($record->getArtist()); ?></td>
                                    <td><?= $record->getReleaseYear(); ?></td>
                                    <td>
                                        <a href="<?= UrlHelper::generate('/records/details.php?id=' . $record->getId()); ?>" class="btn btn-info btn-sm">View Details</a>
                                        <?php if ($loggedIn): ?>
                                            <a href="<?= UrlHelper::generate('/records/edit.php?id=' . $record->getId()); ?>" class="btn btn-secondary btn-sm ml-1 mr-2">Edit Details</a>
                                            <a href="<?= UrlHelper::generate('/records/delete.php?id=' . $record->getId()); ?>" class="btn btn-danger btn-sm">Delete Record</a>
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
    include('../templates/layouts/footer.php');
} catch (Exception $e) {
    echo "Error in footer: " . $e->getMessage();
}
?>