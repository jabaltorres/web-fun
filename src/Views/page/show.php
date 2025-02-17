<?php
/**
 * @var array{
 *   page: ?array,
 *   subject: ?array,
 *   subject_id: string,
 *   page_id: ?int,
 *   loggedIn: bool,
 *   visible: bool,
 *   isPreview: bool
 * } $viewData
 */
?>

<?php include(__DIR__ . '/../templates/header.php'); ?>

<?php if ($viewData['isPreview']): ?>
    <?php $app['pageService']->show_preview_alert(); ?>
<?php endif; ?>

<div id="main" class="py-4">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <?php include(__DIR__ . '/../templates/nav_public.php'); ?>
      </div>

      <div class="col-md-9">
        <div class="page-content">
          <?php if (isset($viewData['page'])): ?>
              <?php
              $allowed_tags = '<div><img><h1><h2><p><br><strong><em><ul><li><a><pre>';
              echo strip_tags($viewData['page']['content'], $allowed_tags);
              ?>
          <?php else: ?>
              <?php include(__DIR__ . '/../partials/home/static_homepage.php'); ?>
          <?php endif; ?>
        </div>

        <?php if ($viewData['loggedIn'] && $viewData['page_id']): ?>
            <a class="action btn btn-info mt-4" 
               href="<?php echo url_for('/staff/pages/edit.php?id=' . h(urlencode((string)$viewData['page_id']))); ?>">
                Edit Page
            </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include(__DIR__ . '/../templates/footer.php'); ?>