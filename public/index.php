<?php
// Require initialization file
require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

// Check if user is logged in
$loggedIn = isset($_SESSION['user_id']);


$preview = false;
if (isset($_GET['preview'])) {
    // previewing should require admin to be logged in
    $preview = $_GET['preview'] == 'true' ? true : false;
}
$visible = !$preview;

if (isset($_GET['id'])) {
    $page_id = $_GET['id'];
    $page = find_page_by_id($page_id, ['visible' => $visible]);
    if (!$page) {
        redirect_to(url_for('/index.php'));
    }
    $subject_id = $page['subject_id'];
    $subject = find_subject_by_id($subject_id, ['visible' => $visible]);
    if (!$subject) {
        redirect_to(url_for('/index.php'));
    }
} elseif (isset($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];
    $subject = find_subject_by_id($subject_id, ['visible' => $visible]);
    if (!$subject) {
        redirect_to(url_for('/index.php'));
    }
    $page_set = find_pages_by_subject_id($subject_id, ['visible' => $visible]);
    $page = mysqli_fetch_assoc($page_set); // first page
    mysqli_free_result($page_set);
    if (!$page) {
        redirect_to(url_for('/index.php'));
    }
    $page_id = $page['id'];
} else {
    // nothing selected; show the homepage
}

?>

<?php include('../templates/layout/header.php'); ?>

<div id="main" class="homepage py-4">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
          <?php include('../templates/components/nav_public.php'); ?>
      </div>
      <div class="col-md-9 ">
        <section class="user-content">
            <?php if ($loggedIn): ?>
              <p class="mb-0">Welcome, <?= htmlspecialchars($_SESSION['first_name']); ?>! Here is the exclusive content for logged-in users.</p>
            <?php else: ?>
              <p class="mb-0">Please <a href="users/login.php">log in</a> to view this section.</p>
            <?php endif; ?>
        </section>

        <div class="page">
            <?php
            if (isset($page)) {
                // show the page from the database
                $allowed_tags = '<div><img><h1><h2><p><br><strong><em><ul><li><a>';
                echo strip_tags($page['content'], $allowed_tags);
            } else {
                include('../templates/pages/static_homepage.php');
            }
            ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('../templates/layout/footer.php'); ?>
