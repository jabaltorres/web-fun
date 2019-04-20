<?php
	$block_headline = "Jumbotron";
	$block_subheading = "Example of Jumbotron used by the theme";
	$block_custom_id = "jumbotron-block";
	$block_custom_class = "jumbotron-block";
?>

<section id="<?php echo $block_custom_id; ?>" class="component <?php echo $block_custom_class; ?>">

	<?php include( INCL_PATH . '/block-headline.php' ); ?>

    <div class="jumbotron">
        <h1 class="display-4">Hello, world!</h1>
        <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        <hr class="my-4">
        <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
        </p>
    </div>

</section>