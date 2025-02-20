<?php
// Ensure these variables are passed in
if (!isset($records, $urlHelper, $htmlHelper, $loggedIn)) {
    throw new \Exception("Required variables are not initialized.");
}
?>

<div class="container record-table-container py-4 mb-5">
    <div class="row">
        <div class="col-12 col-md-6">
            <h2>All Vinyl Records</h2>
        </div>

        <?php if ($loggedIn): ?>
          <div class="col-12 col-md-6">
              <div class="action text-right">
                  <a class="btn btn-primary mb-4" href="<?= $urlHelper->urlFor('records/add.php') ?>">Add New Record</a>
              </div>
          </div>
        <?php endif; ?>
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