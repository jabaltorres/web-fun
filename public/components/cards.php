<?php
	$block_headline = "Cards";
	$block_subheading = "Example of cards used by the theme";
	$block_custom_id = "cards";
	$block_custom_class = "cards";
?>

<section id="<?php echo $block_custom_id; ?>" class="component <?php echo $block_custom_class; ?>">

	<?php include(SHARED_PATH . '/block-headline.php'); ?>

	<div class="row">
		<div class="col-12 col-lg-4">
			<div class="card p-4 mb-4">
				<h3 class="h4">Font Awesome Icon</h3>
				<div class="text-center p-4">
					<i class="fas fa-thumbs-up"></i>
				</div>
				<p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone.</p>
			</div>
		</div>
		<div class="col-12 col-lg-4">
			<div class="card p-4 mb-4 bg-primary text-white">
				<h3 class="h4">Font Awesome Icon</h3>
				<div class="text-center p-4">
					<i class="fas fa-thumbs-up"></i>
				</div>
				<p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone.</p>
			</div>
		</div>
		<div class="col-12 col-lg-4">
			<div class="card p-4 mb-4 bg-secondary">
				<h3 class="h4">Font Awesome Icon</h3>
				<div class="text-center p-4">
					<i class="fas fa-thumbs-up"></i>
				</div>
				<p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone.</p>
			</div>
		</div>
	</div>

</section>