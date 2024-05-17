<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../private/initialize.php');

    $title = "Demo Index";
    $page_heading = 'Demo Page Heading';
    $page_subheading = "List of WIP demos";
    $custom_class = "demo-page";
    include_once(INCLUDES_PATH . '/site-header.php');

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
        ['id' => 'crate-cms', 'visible' => '1', 'demo_page' => 'KrateCMS', 'page_url' =>  '/index.php'],
        ['id' => 'contacts', 'visible' => '1', 'demo_page' => 'Contacts', 'page_url' =>  '/contacts/index.php'],
        ['id' => 'users', 'visible' => '1', 'demo_page' => 'Users', 'page_url' =>  '/users/index.php'],
        ['id' => 'staff', 'visible' => '1', 'demo_page' => 'Staff', 'page_url' =>  '/staff/'],
        ['id' => 'admin-area', 'visible' => '1', 'demo_page' => 'Staff / Admin', 'page_url' =>  '/staff/admins/'],
        ['id' => 'audio', 'visible' => '1', 'demo_page' => 'Audio', 'page_url' => 'audio-player.php'],
        ['id' => 'flipper', 'visible' => '1', 'demo_page' => 'Flipper', 'page_url' => 'flipper.php'],
        ['id' => 'javascript', 'visible' => '1', 'demo_page' => 'JavaScript', 'page_url' => 'javascript/index.php'],
        ['id' => 'heroes', 'visible' => '1', 'demo_page' => 'Heroes', 'page_url' => 'heroes.php'],
        ['id' => 'js-objects', 'visible' => '1', 'demo_page' => 'JS Objects', 'page_url' => 'js-objects.php'],
        ['id' => 'host-info', 'visible' => '1', 'demo_page' => 'Host Info', 'page_url' => 'host-info.php'],
        ['id' => 'lorem-ipsum', 'visible' => '1', 'demo_page' => 'Lorem Ipsum', 'page_url' => 'lorem-ipsum.php'],
        ['id' => 'mustache-js', 'visible' => '1', 'demo_page' => 'Mustache.js', 'page_url' => 'mustache.php'],
        ['id' => 'forms', 'visible' => '1', 'demo_page' => 'Forms', 'page_url' => 'forms/forms.php'],
        ['id' => 'scratch', 'visible' => '1', 'demo_page' => 'Scratch', 'page_url' => 'scratch.php'],
    ];
?>

<?php
    include_once(INCLUDES_PATH . '/navigation.php');
?>

<div class="container <?php echo $custom_class; ?>">
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
                    echo '<li><a id="link-'.  h($page_demo_link['id']) .'" href="'. h($page_demo_link['page_url']) . '">' . h($page_demo_link['demo_page']) . '</a></li>';
                }
            }
            ?>
        </ul>
    </section>

</div><!-- end .container -->

<?php include_once(SHARED_PATH . '/site-footer.php'); ?>