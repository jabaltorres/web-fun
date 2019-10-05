<?php
  $block_headline = "Images";
  $block_subheading = "Example of images used by the theme";
  $block_custom_id = "images";
  $block_custom_class = "images";
?>

<section id="<?php echo $block_custom_id; ?>" class="component <?php echo $block_custom_class; ?>">

    <?php include(INCL_PATH . '/block-headline.php'); ?>

    <div class="row">
        <div class="col-12 col-md-6">
            <h3>1:1</h3>
            <img src="http://placehold.it/300x300">
        </div>
        <div class="col-12 col-md-6">
            <h3>4:3</h3>
            <img src="http://placehold.it/400x300">
        </div>
        <div class="col-12 col-md-6">
            <h3>16:9</h3>
            <img src="http://placehold.it/640x360">
        </div>
        <div class="col-12 col-md-6">
            <h3>16:5</h3>
            <img src="http://placehold.it/3200x1000">
        </div>
    </div>

</section>