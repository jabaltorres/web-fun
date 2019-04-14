<?php
  $block_headline = "BG Test";
  $block_subheading = "BG Test Subheading";
  $block_custom_class = "bg-test";
?>

<section class="<?php echo $block_custom_class; ?>">

    <?php include( INCL_PATH . '/block-headline.php' ); ?>

    <article class="bg-primary mb-4">
        <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad animi atque incidunt laboriosam, nisi placeat possimus quas quasi quidem quo quod ratione repellat reprehenderit repudiandae sed sit soluta. Consequatur, quisquam.</p>
    </article>

    <article class="bg-secondary mb-4">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad animi atque incidunt laboriosam, nisi placeat possimus quas quasi quidem quo quod ratione repellat reprehenderit repudiandae sed sit soluta. Consequatur, quisquam.</p>
    </article>

    <article class="bg-light mb-4">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad animi atque incidunt laboriosam, nisi placeat possimus quas quasi quidem quo quod ratione repellat reprehenderit repudiandae sed sit soluta. Consequatur, quisquam.</p>
    </article>

    <article class="bg-dark mb-4">
        <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad animi atque incidunt laboriosam, nisi placeat possimus quas quasi quidem quo quod ratione repellat reprehenderit repudiandae sed sit soluta. Consequatur, quisquam.</p>
    </article>
</section>