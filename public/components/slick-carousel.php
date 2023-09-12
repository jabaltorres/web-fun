<?php

// Path: public/components/slick-carousel.php
$block_custom_id = "slick-carousel";
$block_custom_class = "slick-carousel";

// Description: a multi-dimensional array of header elements
$header_block_content = array(
    array(
        'content' => 'Carousel',
        'class' => 'header-title h3 block-headline',
        'id' => 'carousel-title',
    ),
    array(
        'content' => 'This is a carousel',
        'class' => 'header-subtitle h5',
    ),
    array(
        'content' => 'Description',
        'class' => 'header-description h6',
    ),
);

?>


<section id="<?php echo $block_custom_id; ?>" class="component <?php echo $block_custom_class; ?>">

    <?php lorem_print_header_block($header_block_content); ?>

    <!-- start .carousel-->
    <div class="carousel">
        <div class="carousel-wrapper">
            <div class="carousel-slide">
                <img src="<?php echo url_for('/images/placeholder-16-x-9.png'); ?>">
                <div class="blurb">
                    <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni recusandae veritatis molestias in repudiandae praesentium.</span>
                </div>
            </div>
            <div class="carousel-slide">
                <img src="<?php echo url_for('/images/placeholder-16-x-9.png'); ?>">
                <div class="blurb">
                    <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni recusandae veritatis molestias in repudiandae praesentium.</span>
                </div>
            </div>
            <div class="carousel-slide">
                <img src="<?php echo url_for('/images/placeholder-16-x-9.png'); ?>">
                <div class="blurb">
                    <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Magni recusandae veritatis molestias in repudiandae praesentium.</span>
                </div>
            </div>
        </div>
    </div>
    <!-- end .carousel-->
</section>