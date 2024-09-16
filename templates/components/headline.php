<?php
if (!isset($page_heading)) {
    $page_heading = 'Default Page Heading';
}
if (!isset($page_subheading)) {
    $page_subheading = 'Default Page Subheading';
}
?>

<div class="page-headline bg-light p-5 mb-4">
    <h3 class="page-title"><?php echo $page_heading; ?></h3>
    <h4 class="page-subheading"><?php echo $page_subheading; ?></h4>
</div>