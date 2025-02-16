<?php
declare(strict_types=1);

// Load bootstrap and get application container
$app = require_once(__DIR__ . '/../../config/bootstrap.php');

use Fivetwofive\KrateCMS\Models\LoremElement;
use Fivetwofive\KrateCMS\Models\LoremCard;

try {
    // Extract required services
    $urlHelper = $app['urlHelper'];
    $htmlHelper = $app['htmlHelper'];
    $sessionHelper = $app['sessionHelper'];
    $settingsManager = $app['settingsManager'];
    $userManager = $app['userManager'];
    $config = $app['config'];

    $title = "Demo Index";
    $pageHeading = 'Demo Page Heading';
    $pageSubheading = "List of WIP demos";
    $customClass = "demo-page";

    // Page Header
    $pageDemoHeader = new LoremElement("h1");
    $pageDemoHeader->setAttribute("id", "page-heading");
    $pageDemoHeader->setAttribute("class", "h4 mb-2");
    $pageDemoHeader->setContent("Demos Page");

    // Page Sub Header
    $pageDemoSubheader = new LoremElement("h3");
    $pageDemoSubheader->setAttribute("id", "page-subheading");
    $pageDemoSubheader->setAttribute("class", "h5 mb-0");
    $pageDemoSubheader->setContent("This is where I will list all of my demos");

    // Links to demo pages
    $pageDemoLinks = [
        ['id' => 'bpm-counter', 'visible' => '1', 'demo_page' => 'BPM Counter', 'page_url' => 'sandbox/bpm-counter.php'],
        ['id' => 'audio', 'visible' => '1', 'demo_page' => 'Audio Player', 'page_url' => 'sandbox/audio-player.php'],
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

    $technologyLinks = [
        ['name' => 'CSS', 'url' => 'sandbox/css/index.php', 'icon' => 'fa-brands fa-css3-alt'],
        ['name' => 'JavaScript', 'url' => 'sandbox/javascript/index.php', 'icon' => 'fa-brands fa-js'],
        ['name' => 'PHP', 'url' => 'sandbox/php/index.php', 'icon' => 'fa-brands fa-php'],
    ];

    // Include the header with access to all services
    include(ROOT_PATH . '/templates/layouts/header.php');
} catch (Exception $e) {
    error_log("Sandbox Error: " . $e->getMessage());
    $sessionHelper->setMessage("An error occurred: " . $e->getMessage());
    $urlHelper->redirect('/index.php');
}
?>

<div class="container <?= $htmlHelper->escape($customClass) ?>">
    <section class="my-4">
        <?php
        // Description: An example of using the LoremCard class
        $loremCard = new LoremCard([
            'id' => 'box', 
            'classes' => 'card p-4', 
            'content' => 'This is a test of the LoremCard class.', 
            'dark_mode' => false
        ]);
        echo $loremCard->render();
        ?>
    </section>

    <section class="mb-4">
        <?php
            echo $pageDemoHeader->render();
            echo $pageDemoSubheader->render();
        ?>
    </section>
    
    <section class="grouping mb-5">
        <h3 class="mb-3">Grouping</h3>
        <p class="mb-4">This is a grouping of demo pages</p>
        <div class="row">
            <?php foreach ($technologyLinks as $link): ?>
                <div class="col-12 col-md-4 mb-3">
                    <div class="card h-100 p-4 hover-shadow">
                        <div class="d-flex align-items-center justify-content-center">
                            <a href="<?= $urlHelper->urlFor($link['url']) ?>" class="text-decoration-none">
                                <i class="<?= $htmlHelper->escape($link['icon']) ?> me-2"></i>
                                <?= $htmlHelper->escape($link['name']) ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="mb-5">
        <div class="row">
            <?php foreach ($pageDemoLinks as $demoLink): ?>
                <?php if ($demoLink['visible'] === '1'): ?>
                    <div class="col-12 col-md-3 mb-4">
                        <div class="card h-100">
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <a id="link-<?= $htmlHelper->escape($demoLink['id']) ?>"
                                   href="<?= $urlHelper->urlFor($demoLink['page_url']) ?>"
                                   class="text-decoration-none">
                                    <?= $htmlHelper->escape($demoLink['demo_page']) ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </section>
</div>

<?php include(ROOT_PATH . '/templates/layouts/footer.php'); ?>