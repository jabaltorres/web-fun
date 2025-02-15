<?php
declare(strict_types=1); // Enable strict typing

// Require initialization file
// require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

$app = require_once(__DIR__ . '/../config/bootstrap.php');
$page = isset($_GET['id']) ? $app['pageService']->findPageById((int) $_GET['id']) : null;

// Constants
const DEFAULT_PAGE_ID = 1; // Ensure this is an integer

// Check if user is logged in
$loggedIn = isset($_SESSION['user_id']);

// Check if previewing
$visible = !$app['pageService']->is_preview();

// Get the page id and cast it to an integer
$page_id = (int) ($_GET['id'] ?? $_GET['subject_id'] ?? DEFAULT_PAGE_ID);

// Debugging: Check the type and value of $page_id
if (!is_int($page_id)) {
    throw new \Exception("Page ID must be an integer. Given: " . gettype($page_id));
}

if (isset($_GET['id'])) {
    // Fetch the page by ID
    $page = $app['pageService']->findPageById($page_id, ['visible' => $visible]);
    if (!$page) {
        // Redirect if the page is not found
        redirect_to(url_for('/page.php'));
    }
    $subject_id = $page['subject_id'];
    // Fetch the subject by ID
    $subject = $app['pageService']->findSubjectById($subject_id, ['visible' => $visible]);
    if (!$subject) {
        // Redirect if the subject is not found
        redirect_to(url_for('/page.php'));
    }
} elseif (isset($_GET['subject_id'])) {
    // Fetch the subject by subject ID
    $subject_id = $_GET['subject_id'];
    $subject = $app['pageService']->findSubjectById($subject_id, ['visible' => $visible]);
    if (!$subject) {
        // Redirect if the subject is not found
        redirect_to(url_for('/page.php'));
    }
    // Fetch pages associated with the subject
    $page_set = $app['pageService']->findPagesBySubjectId($subject_id, ['visible' => $visible]);
    $page = mysqli_fetch_assoc($page_set); // first page
    mysqli_free_result($page_set);
    if (!$page) {
        // Redirect if no pages are found for the subject
        redirect_to(url_for('/page.php'));
    }
    $page_id = $page['id'];
} 

?>

<?php include('../templates/shared/header.php'); ?>

<?php
    // If previewing, show an alert
    if ($app['pageService']->is_preview()) {
        $app['pageService']->show_preview_alert();
    }
?>

<div id="main" class="py-4">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <?php include('../templates/components/nav_public.php'); ?>
      </div>

      <div class="col-md-9 ">
        <div class="page-content">
          <?php
          if (isset($page)) {
              // show the page from the database
              $allowed_tags = '<div><img><h1><h2><p><br><strong><em><ul><li><a><pre>';
              echo strip_tags($page['content'], $allowed_tags);
          } else {
              include('../templates/pages/static_homepage.php');
          }
          ?>
        </div><!-- end .page-content -->
          <?php
          if ($loggedIn) {
              echo '<a class="action btn btn-info mt-4" href="' . url_for('/staff/pages/edit.php?id=' . h(urlencode((string)$page_id))) . '">Edit Page</a>';
          }
          ?>
      </div><!-- end .col-md-9 -->
    </div>
  </div>
</div>

<?php include('../templates/shared/footer.php'); ?>
