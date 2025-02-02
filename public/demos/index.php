<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

    use Fivetwofive\KrateCMS\LoremElement;
    use Fivetwofive\KrateCMS\LoremCard;
    use Fivetwofive\KrateCMS\UserManager;

    $title = "Demo Index";
    $page_heading = 'Demo Page Heading';
    $page_subheading = "List of WIP demos";
    $custom_class = "demo-page";

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
        ['id' => 'bpm-counter', 'visible' => '1', 'demo_page' => 'BPM Counter', 'page_url' => 'bpm-counter.php'],
        ['id' => 'audio', 'visible' => '1', 'demo_page' => 'Audio Player', 'page_url' => 'audio-player.php'],
        ['id' => 'flipper', 'visible' => '1', 'demo_page' => 'Flipper', 'page_url' => 'flipper.php'],
        ['id' => 'javascript', 'visible' => '1', 'demo_page' => 'JavaScript', 'page_url' => 'javascript/index.php'],
        ['id' => 'heroes', 'visible' => '1', 'demo_page' => 'Heroes', 'page_url' => 'heroes.php'],
        ['id' => 'js-objects', 'visible' => '1', 'demo_page' => 'JS Objects', 'page_url' => 'js-objects.php'],
        ['id' => 'language', 'visible' => '1', 'demo_page' => 'Language', 'page_url' => 'language.php'],
        ['id' => 'host-info', 'visible' => '1', 'demo_page' => 'Host Info', 'page_url' => 'host-info.php'],
        ['id' => 'lorem-ipsum', 'visible' => '1', 'demo_page' => 'Lorem Ipsum', 'page_url' => 'lorem-ipsum.php'],
        ['id' => 'mustache-js', 'visible' => '1', 'demo_page' => 'Mustache.js', 'page_url' => 'mustache.php'],
        ['id' => 'forms', 'visible' => '1', 'demo_page' => 'Forms', 'page_url' => 'forms/index.php'],
        ['id' => 'simple', 'visible' => '1', 'demo_page' => 'Simple PHP', 'page_url' => 'simple.php'],
    ];

    try {
        $userManager = new UserManager($db);
    } catch (Exception $e) {
        // Handle exception
    }
?>

<?php
    include('../../templates/layout/header.php');
?>

<div class="container <?php echo $custom_class; ?>">
    <section class="my-4">
        <?php
        // Description: An example of using the LoremCard class
        $lorem_card = new LoremCard(['id' => 'box', 'classes' => 'card p-4', 'content' => 'This is a test of the LoremCard class.', 'dark_mode' => false]);
        echo $lorem_card->render();
        ?>
    </section>

    <section class="mb-4">
        <?php
            echo $page_demo_header->render();
            echo $page_demo_subheader->render();
        ?>
    </section>
    
    <section class="grouping mb-5">
        <h3 class="mb-3">Grouping</h3>
        <p class="mb-4">This is a grouping of demo pages</p>
        <div class="row">
            <?php
            $technology_links = [
                ['name' => 'CSS', 'url' => 'css/index.php', 'icon' => 'fa-brands fa-css3-alt'],
                ['name' => 'JavaScript', 'url' => 'javascript/index.php', 'icon' => 'fa-brands fa-js'],
                ['name' => 'PHP', 'url' => 'php/index.php', 'icon' => 'fa-brands fa-php'],
            ];

            foreach ($technology_links as $link): ?>
                <div class="col-12 col-md-4 mb-3">
                    <div class="card h-100 p-4 hover-shadow">
                        <div class="d-flex align-items-center justify-content-center">
                            <a href="<?= h($link['url']) ?>" class="text-decoration-none">
                                <i class="<?= $link['icon'] ?> me-2"></i>
                                <?= h($link['name']) ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="mb-5">
        <div class="row">
            <?php foreach ($page_demo_links as $demo_link): ?>
                <?php if ($demo_link['visible'] === '1'): ?>
                    <div class="col-12 col-md-3 mb-4">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <a 
                                    id="link-<?= h($demo_link['id']) ?>"
                                    href="<?= h($demo_link['page_url']) ?>"
                                    class="text-decoration-none"
                                >
                                    <?= h($demo_link['demo_page']) ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>

</div><!-- end .container -->

<?php include('../../templates/layout/footer.php'); ?>