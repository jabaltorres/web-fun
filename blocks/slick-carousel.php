<?php 
  $block_headline = "Slick Carousel";
  $block_subheading = "Mic check 1, 2";
  $block_custom_class = "slick-carousel";
?>

<section class="<?php echo $block_custom_class; ?>">

  <?php include 'incl/block-heading.php'; ?>
  
  <p>This is a nice Slick Carousel</p>

  <div class="carousel">
    <div class="carousel-wrapper">
      <div class="carousel-slide">
        <img src="images/placeholder-16-x-9.png">
        <div class="blurb">
          <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni recusandae veritatis molestias in repudiandae praesentium.</span>
        </div>
      </div>
      <div class="carousel-slide">
        <img src="images/placeholder-16-x-9.png">
        <div class="blurb">
          <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni recusandae veritatis molestias in repudiandae praesentium.</span>
        </div>
      </div>
      <div class="carousel-slide">
        <img src="images/placeholder-16-x-9.png">
        <div class="blurb">
          <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni recusandae veritatis molestias in repudiandae praesentium.</span>
        </div>
      </div>
    </div>    
  </div><!-- end .carousel-->
</section>