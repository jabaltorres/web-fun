<?php
    $block_headline = "Background Colors";
    $block_subheading = "Example of Background colors";
    $block_custom_id = "bg-test";
    $block_custom_class = "bg-test";
?>

<section id="<?php echo $block_custom_id; ?>" class="component <?php echo $block_custom_class; ?>">

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