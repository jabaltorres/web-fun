<?php
  $block_headline = "Colors";
  $block_subheading = "Colors Subheading";
  $block_custom_class = "colors";
?>

<section class="<?php echo $block_custom_class; ?>">

    <?php include( INCL_PATH . '/block-headline.php' ); ?>

    <div class="row">
        <div class="col-12 col-sm-3 bg-primary p-4">
            <span>Primary</span>
        </div>
        <div class="col-12 col-sm-3 bg-secondary p-4">
            <span>Secondary</span>
        </div>
        <div class="col-12 col-sm-3 bg-success p-4">
            <span>Success</span>
        </div>
        <div class="col-12 col-sm-3 bg-danger p-4">
            <span>Danger</span>
        </div>
        <div class="col-12 col-sm-3 bg-warning p-4">
            <span>Warning</span>
        </div>
        <div class="col-12 col-sm-3 bg-info p-4">
            <span>Info</span>
        </div>
        <div class="col-12 col-sm-3 bg-light p-4">
            <span>Light</span>
        </div>
        <div class="col-12 col-sm-3 bg-dark p-4">
            <span>Dark</span>
        </div>
    </div>

</section>