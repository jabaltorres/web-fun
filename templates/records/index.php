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

include(ROOT_PATH . '/templates/shared/header.php');
include(ROOT_PATH . '/templates/components/hero.php'); 
include(ROOT_PATH . '/templates/components/record_table.php');
include(ROOT_PATH . '/templates/shared/footer.php'); 
?>