<?php
// Ensure these variables are passed in
global $htmlHelper, $settingsManager;
$searchTerm = $searchTerm ?? '';

$siteName = $htmlHelper->escape($settingsManager->getSetting('site_name'));
$siteTagline = $htmlHelper->escape($settingsManager->getSetting('site_tagline'));
?>

<div class="hero">
    <div class="jumbotron jumbotron-fluid px-4">
        <div class="container text-center">
            <h1 class='display-4'><?= $siteName ?></h1>
            <p class='lead'><?= $siteTagline ?></p>

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
