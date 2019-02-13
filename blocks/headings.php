<?php
  $block_headline = "Headings";
  $block_subheading = "Headings Subheading";
  $block_custom_class = "headings-section";
?>

<section class="<?php echo $block_custom_class; ?>">

    <?php include( INCL_PATH . '/block-headline.php' ); ?>

    <div class="row">
        <div class="col-sm-2">
            <span>Heading 1</span>
        </div>

        <div class="col-sm-10">
            <h1>This is a very large header.</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <span>Heading 2</span>
        </div>
        <div class="col-sm-10">
            <h2>This is a large header.</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <span>Heading 3</span>
        </div>
        <div class="col-sm-10">
            <h3>This is a medium header.</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <span>Heading 4</span>
        </div>
        <div class="col-sm-10">
            <h4>This is a moderate header.</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <span>Heading 5</span>
        </div>
        <div class="col-sm-10">
            <h5>This is a small header.</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <span>Heading 6</span>
        </div>
        <div class="col-sm-10">
            <h6>This is a timy header.</h6>
        </div>
    </div>

</section>