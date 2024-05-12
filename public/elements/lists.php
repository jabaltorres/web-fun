<?php
    $block_headline = "Lists";
    $block_subheading = "Examples of Lists";
    $block_custom_id = "lists";
    $block_custom_class = "lists-section";
?>

<section id="<?php echo $block_custom_id; ?>" class="component <?php echo $block_custom_class; ?>">

    <?php include(INCLUDES_PATH . '/block-headline.php'); ?>

    <div class="row">
        <div class="col-12 col-md-4">
            <h4>Unordered List</h4>
            <ul>
                <li>Unordered List Item 1</li>
                <li>Unordered List Item 2</li>
                <li>Unordered List Item 3</li>
                <li>Unordered List Item 4</li>
                <li>Unordered List Item 5</li>
            </ul>
        </div>
        <div class="col-12 col-md-4">
            <h4>Ordered List</h4>
            <ol>
                <li>Ordered List Item 1</li>
                <li>Ordered List Item 2</li>
                <li>Ordered List Item 3</li>
                <li>Ordered List Item 4</li>
                <li>Ordered List Item 5</li>
            </ol>
        </div>
        <div class="col-12 col-md-4">
            <h4>Definition List</h4>
            <dl>
                <dt>Description Term Item 1</dt>
                <dd>Description Description Item 1</dd>
                <dt>Description Term Item 2</dt>
                <dd>Description Description Item 2</dd>
            </dl>
        </div>
    </div>

</section>