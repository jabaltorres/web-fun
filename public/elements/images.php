<?php
  $block_headline = "Images";
  $block_subheading = "Example of images used by the theme";
  $block_custom_id = "images";
  $block_custom_class = "images";
?>

<section id="<?php echo $block_custom_id; ?>" class="component <?php echo $block_custom_class; ?>">

    <?php include('../../templates/components/block_headline.php'); ?>

    <div class="row">
        <div class="col-12 col-md-6">
            <h3>1:1</h3>
            <img src="<?php echo url_for('/assets/images/placeholder/placeholder-1x1.png'); ?>">
        </div>
        <div class="col-12 col-md-6">
            <h3>4:3</h3>
            <img src="<?php echo url_for('/assets/images/placeholder/placeholder-4x3.png'); ?>">
        </div>
        <div class="col-12 col-md-6">
            <h3>16:9</h3>
            <img src="<?php echo url_for('/assets/images/placeholder/placeholder-16x9.png'); ?>">
        </div>
        <div class="col-12 col-md-6">
            <h3>16:5</h3>
            <img src="<?php echo url_for('/assets/images/placeholder/placeholder-16x5.png'); ?>">
        </div>
    </div>

</section>