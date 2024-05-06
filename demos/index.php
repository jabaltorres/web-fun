<?php
require_once '../private/initialize.php';

$title = "Demo Index";
// this is for <title>

$page_heading = 'Demo Page Heading';
$page_subheading = "List of WIP demos";

$custom_class = "demo-page";
//custom CSS for this page only

include_once(INCLUDES_PATH . '/site-header.php');
?>

<?php

// Page Header
$page_demo_header = new LoremElement("h1");
$page_demo_header->setAttribute("id", "page-heading");
$page_demo_header->setAttribute("class", "h4 mb-2");
$page_demo_header->setContent("Demos Page");

// Page Sub Header
$page_demo_subheader = new LoremElement("h3");
$page_demo_subheader->setAttribute("id", "page-subheading");
$page_demo_subheader->setAttribute("class", "h5 mb-0");
$page_demo_subheader->setContent("This is where I will list all of my demos");

// Links to demo pages
$page_demo_links = [
    ['id' => '1', 'visible' => '1', 'demo_page' => 'Contacts', 'page_url' =>  '/public/contacts/index.php'],
    ['id' => '2', 'visible' => '1', 'demo_page' => 'Admin Area', 'page_url' =>  '/public/staff/admins/'],
    ['id' => '3', 'visible' => '1', 'demo_page' => 'Globe Bank', 'page_url' =>  '/public/index.php'],
    ['id' => '4', 'visible' => '1', 'demo_page' => 'Audio', 'page_url' => 'audio-player.php'],
    ['id' => '5', 'visible' => '1', 'demo_page' => 'Flipper', 'page_url' => 'flipper.php'],
    ['id' => '6', 'visible' => '1', 'demo_page' => 'JavaScript', 'page_url' => 'javascript/index.php'],
    ['id' => '7', 'visible' => '1', 'demo_page' => 'Heroes', 'page_url' => 'heroes.php'],
    ['id' => '8', 'visible' => '1', 'demo_page' => 'JS Objects', 'page_url' => 'js-objects.php'],
    ['id' => '9', 'visible' => '1', 'demo_page' => 'Host Info', 'page_url' => 'host-info.php'],
    ['id' => '10', 'visible' => '1', 'demo_page' => 'Lorem Ipsum', 'page_url' => 'lorem-ipsum.php'],
    ['id' => '11', 'visible' => '1', 'demo_page' => 'Mustache.js', 'page_url' => 'mustache.php'],
    ['id' => '12', 'visible' => '1', 'demo_page' => 'Forms', 'page_url' => 'forms/forms.php'],
    ['id' => '13', 'visible' => '1', 'demo_page' => 'Scratch', 'page_url' => 'scratch.php'],
];
?>

<div class="container <?php echo $custom_class; ?>">
  
    <?php
	    include_once(INCLUDES_PATH . '/masthead.php');
	    include_once(INCLUDES_PATH . '/navigation.php');
    ?>


    <section>
        <?php
        // Description: An example of using the LoremCard class
        $lorem_card = new LoremCard(['id' => 'box', 'classes' => 'card p-4 mb-4', 'content' => 'This is a test of the LoremCard class.', 'dark_mode' => false]);
        echo $lorem_card->render();
        ?>
    </section>

    <section>
        <?php
            // Page Header
            echo $page_demo_header->render();

            // Page Sub Header
            echo $page_demo_subheader->render();
        ?>
    </section>

    <section>
        <ul class="menu list-unstyled">
            <?php
            foreach ($page_demo_links as $page_demo_link) {
                if ($page_demo_link['visible'] == '1') {
                    echo '<li><a href="'. h($page_demo_link['page_url']) . '">' . h($page_demo_link['demo_page']) . '</a></li>';
                }
            }
            ?>
        </ul>
    </section>

</div><!-- end .container -->

<?php include_once(INCLUDES_PATH . '/site-footer.php'); ?>