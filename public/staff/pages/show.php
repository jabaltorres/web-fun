<?php declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// require_once('../../../src/initialize.php');
$app = require_once(__DIR__ . '/../../../config/bootstrap.php');

// UrlHelper
$urlHelper = $app['urlHelper'];

// Get the page id from the URL and cast it to an integer
$id = (int) ($_GET['id'] ?? 0); // Default to 0 if not set

if ($id === 0) {
    // Handle the case where the ID is not valid
    echo '<p>Invalid page ID.</p>';
    exit; // Stop further execution
}

// Fetch the page by ID
$page = $app['pageService']->findPageById($id); // Pass the integer $id

//subject
$subject = $app['subjectService']->findSubjectById($page['subject_id']);

if (!$page) {
    echo '<p>Page not found.</p>';
} else {
    // Debugging: Check the content
    // var_dump($page['content']); // Check what is being retrieved
    // echo '<div>' . htmlspecialchars($page['content']) . '</div>'; // Display the content safely
}

?>

<?php $page_title = 'Show Page'; ?>
<?php include('../../../src/Views/templates/header.php'); ?>

<div id="content" class="container">
    <div class="row">
        <div class="col-12">
            <a class="btn btn-outline-info my-4 font-weight-bold" href="<?php echo url_for('/staff/pages/index.php'); ?>">&laquo; Back to List</a>

            <div class="page show">

                <h1>Page: <?php echo h($page['menu_name']); ?></h1>

                <div class="actions mb-4">
                    <?php $encodedId = $urlHelper->u((string)$page['id']); // Cast to string before encoding ?>
                    <a class="action btn btn-primary" href="<?php echo url_for('/page.php?id=' . h($encodedId) . '&preview=true'); ?>">Preview</a>
                    <a class="action btn btn-secondary" href="<?php echo url_for('/staff/pages/edit.php?id=' . h($encodedId) . '&preview=true'); ?>">Edit</a>
                </div>

                <div class="attributes">
                    <?php $subject = $app['subjectService']->findSubjectById($page['subject_id']); ?>
                    <dl>
                        <dt>Subject</dt>
                        <dd><?php echo h((string)$subject['menu_name']); ?></dd>
                    </dl>
                    <dl>
                        <dt>Menu Name</dt>
                        <dd><?php echo h((string)$page['menu_name']); ?></dd>
                    </dl>
                    <dl>
                        <dt>Position</dt>
                        <dd><?php echo h((string)$page['position']); ?></dd>
                    </dl>
                    <dl>
                        <dt>Visible</dt>
                        <dd><?php echo h((string)$page['visible']); ?></dd>
                    </dl>
                    <dl>
                        <dt>Content</dt>
                        <dd><?php echo h($page['content']); ?></dd>
                    </dl>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include('../../../src/Views/templates/footer.php'); ?>
