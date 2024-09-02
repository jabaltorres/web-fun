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


    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="<?php echo url_for('/assets/images/placeholder/placeholder-16x9.png'); ?>">
            </div>
            <div class="carousel-item">
                <img src="<?php echo url_for('/assets/images/placeholder/placeholder-16x9.png'); ?>">
            </div>
            <div class="carousel-item">
                <img src="<?php echo url_for('/assets/images/placeholder/placeholder-16x9.png'); ?>">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</section>