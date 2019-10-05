<?php
    $block_headline = "Colors";
    $block_subheading = "Example of colors used by the theme";
    $block_custom_id = "colors";
    $block_custom_class = "colors";
?>

<section id="<?php echo $block_custom_id; ?>" class="component <?php echo $block_custom_class; ?>">

    <?php include(INCL_PATH . '/block-headline.php'); ?>

    <div class="row">
        <div class="col-12 col-sm-3 bg-primary p-4">
            <span class="d-block text-center text-white">Primary</span>
        </div>
        <div class="col-12 col-sm-3 bg-secondary p-4">
            <span class="d-block text-center">Secondary</span>
        </div>
        <div class="col-12 col-sm-3 bg-success p-4">
            <span class="d-block text-center">Success</span>
        </div>
        <div class="col-12 col-sm-3 bg-danger p-4">
            <span class="d-block text-center">Danger</span>
        </div>
        <div class="col-12 col-sm-3 bg-warning p-4">
            <span class="d-block text-center">Warning</span>
        </div>
        <div class="col-12 col-sm-3 bg-info p-4">
            <span class="d-block text-center">Info</span>
        </div>
        <div class="col-12 col-sm-3 bg-light p-4">
            <span class="d-block text-center">Light</span>
        </div>
        <div class="col-12 col-sm-3 bg-dark p-4">
            <span class="d-block text-center text-white">Dark</span>
        </div>
    </div>

</section>