<?php
  $block_headline = "Buttons";
  $block_subheading = "Buttons Subheading";
  $block_custom_class = "buttons-section";
?>

<section class="<?php echo $block_custom_class; ?>">

  <?php include(INCL_PATH . '/block-headline.php'); ?>
  
  <button class="btn btn-primary">Click Me</button>
  <button class="btn btn-primary">Click Me</button>
  <button class="btn btn-primary">Click Me</button>
  <button class="btn btn-primary">Click Me</button>
  <button class="btn btn-primary">Click Me</button>

</section>