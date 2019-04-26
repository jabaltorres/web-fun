<?php 
    $block_headline = "Nav Bar";
    $block_subheading = "Nav Bar Subheading";
    $block_custom_id = "nav-bar-example";
    $block_custom_class = "nav-bar-example";
?>

<section id="<?php echo $block_custom_id; ?>" class="component <?php echo $block_custom_class; ?>">

    <?php include( INCL_PATH . '/block-headline.php' ); ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Lorem</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link" href="<?php echo $url; ?>/index.php" alt="" title="Home Link" target="">Home</a>
                <a class="nav-link" href="<?php echo $url; ?>/public/style.php" alt="" title="" target="">Style</a>
                <a class="nav-link" href="<?php echo $url; ?>/public/elements.php" alt="" title="" target="">Elements</a>
                <a class="nav-link" href="<?php echo $url; ?>/public/components.php" alt="" title="" target="">Components</a>
                <a class="nav-link" href="<?php echo $url; ?>/demos/index.php" alt="" title="" target="">Demos</a>
            </div>
        </div>
    </nav>
</section>