<?php
  $block_headline = "Typography";
  $block_subheading = "Typography Usage Examples";
  $block_custom_id = "typography-section";
  $block_custom_class = "typography-section";
?>

<section id="<?php echo $block_custom_id; ?>" class="component <?php echo $block_custom_class; ?>">

    <?php include( INCL_PATH . '/block-headline.php' ); ?>

    <div class="row mb-3">
        <div class="col-sm-2">
            <span>Heading 1</span>
        </div>

        <div class="col-sm-10">
            <h1>This is a very large header.</h1>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-2">
            <span>Heading 2</span>
        </div>
        <div class="col-sm-10">
            <h2>This is a large header.</h2>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-2">
            <span>Heading 3</span>
        </div>
        <div class="col-sm-10">
            <h3>This is a medium header.</h3>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-2">
            <span>Heading 4</span>
        </div>
        <div class="col-sm-10">
            <h4>This is a moderate header.</h4>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-2">
            <span>Heading 5</span>
        </div>
        <div class="col-sm-10">
            <h5>This is a small header.</h5>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-2">
            <span>Heading 6</span>
        </div>
        <div class="col-sm-10">
            <h6>This is a timy header.</h6>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-2">
            <span>Lead</span>
        </div>
        <div class="col-sm-10">
            <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis est in officia officiis optio qui repellat ullam voluptates! Aliquam optio quam rem suscipit temporibus! Amet, eius fugit! A ullam, voluptate?</p>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-2">
            <span>Paragraphs</span>
        </div>
        <div class="col-sm-10">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis est in officia officiis optio qui repellat ullam voluptates! Aliquam optio quam rem suscipit temporibus! Amet, eius fugit! A ullam, voluptate?</p>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-2">
            <span>Small</span>
        </div>
        <div class="col-sm-10">
            <p class="small">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis est in officia officiis optio qui repellat ullam voluptates! Aliquam optio quam rem suscipit temporibus! Amet, eius fugit! A ullam, voluptate?</p>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-2">
            <span>Blockquote</span>
        </div>
        <div class="col-sm-10">
            <blockquote class="blockquote">
                <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
            </blockquote>
        </div>
    </div>

</section>