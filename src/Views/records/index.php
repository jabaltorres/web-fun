<?php
declare(strict_types=1);

// Ensure these variables are defined
$settingsManager = $settingsManager ?? null;
$htmlHelper = $htmlHelper ?? null;
$records = $records ?? [];
$loggedIn = $loggedIn ?? false;

// Check if htmlHelper and settingsManager are not null
if ($htmlHelper === null || $settingsManager === null) {
    throw new \Exception("Required helpers are not initialized.");
}

error_log("Template variables:");
error_log("records: " . print_r($records, true));
error_log("loggedIn: " . ($loggedIn ? 'true' : 'false'));

include(ROOT_PATH . '/src/Views/templates/header.php');
include(ROOT_PATH . '/src/Views/records/hero.php');
include(ROOT_PATH . '/src/Views/records/record_table.php');
include(ROOT_PATH . '/src/Views/templates/footer.php');