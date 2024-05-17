<?php
    $block_headline = "Labels";
    $block_subheading = "Examples of Labels";
    $block_custom_id = "labels";
    $block_custom_class = "labels-section";
?>

<section id="<?php echo $block_custom_id; ?>" class="component <?php echo $block_custom_class; ?>">

    <?php include(SHARED_PATH . '/block-headline.php'); ?>

    <div class="row">
        <div class="col-12">
            <span class="label small p-1 d-inline-block bg-primary text-white">Label BG-Primary</span>
            <span class="label small p-1 d-inline-block bg-secondary">Label BG-Secondary</span>
            <span class="label small p-1 d-inline-block bg-success">Label BG-Success</span>
            <span class="label small p-1 d-inline-block bg-danger">Label BG-Danger</span>
            <span class="label small p-1 d-inline-block bg-warning">Label BG-Warning</span>
            <span class="label small p-1 d-inline-block bg-info">Label BG-Info</span>
            <span class="label small p-1 d-inline-block bg-light">Label BG-Light</span>
            <span class="label small p-1 d-inline-block bg-dark text-white">Label BG-Dark</span>
            <span class="label small p-1 d-inline-block bg-white">Label BG-White</span>
        </div>

    </div>

</section>