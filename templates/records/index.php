<?php
// Ensure these variables are defined
$settingsManager = $settingsManager ?? null;
$htmlHelper = $htmlHelper ?? null;
$searchTerm = $searchTerm ?? '';
$records = $records ?? [];
$loggedIn = $loggedIn ?? false;

// Check if htmlHelper and settingsManager are not null
if ($htmlHelper === null || $settingsManager === null) {
    throw new \Exception("Required helpers are not initialized.");
}

error_log("Template variables:");
error_log("records: " . print_r($records, true));
error_log("searchTerm: " . ($searchTerm ?? 'null'));
error_log("loggedIn: " . ($loggedIn ? 'true' : 'false'));

// Include header
include(ROOT_PATH . '/templates/shared/header.php');
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
                       value="<?= $htmlHelper->escape($searchTerm) ?>">
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
// Include footer
include(ROOT_PATH . '/templates/shared/footer.php');
?>