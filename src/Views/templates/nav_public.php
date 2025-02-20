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

$page_id = $viewData['page_id'] ?? '';
$subject_id = $viewData['subject_id'] ?? '';
$visible = $viewData['visible'] ?? false;
$subjects = $app['subjectService']->findAllSubjects();
?>

<div class="sidebar">
  <ul class="list-group subjects">
    <?php foreach($subjects as $subject) { ?>
      <?php 
      // Debug subject comparison
      echo "<!-- Comparing subject {$subject['id']} with current subject_id {$subject_id} -->";
      $is_current_subject = ((string)$subject['id'] === (string)$subject_id);
      ?>
      <li class="list-group-item <?php if($is_current_subject) { echo 'selected'; } ?>">
        <a href="<?php echo url_for('/page.php?subject_id=' . h(urlencode((string)$subject['id']))); ?>">
          <?php echo h($subject['menu_name']); ?>
        </a>

        <?php if($is_current_subject) { ?>
          <?php 
          // Convert visibility to integer (1 for visible, 0 for hidden)
          $visibilityValue = $visible ? 1 : 0;
          $nav_pages_result = $app['pageService']->findPagesBySubjectId(
              (int)$subject['id'], 
              ['visible' => $visibilityValue]
          ); 
          $nav_pages = $nav_pages_result->fetch_all(MYSQLI_ASSOC);
          
          // Debugging
          if (empty($nav_pages)) {
              echo "<!-- No pages found for subject {$subject['id']} -->";
          } else {
              echo "<!-- Found " . count($nav_pages) . " pages for subject {$subject['id']} -->";
          }
          
          // Debug SQL query
          echo "<!-- Visibility setting: " . ($visible ? 'true' : 'false') . " -->";
          ?>
          <ul class="pages">
            <?php foreach($nav_pages as $nav_page) { ?>
              <li class="<?php if($nav_page['id'] == $page_id) { echo 'selected'; } ?>">
                <a href="<?php echo url_for('/page.php?id=' . h(urlencode((string)$nav_page['id']))); ?>">
                  <?php echo h($nav_page['menu_name']); ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        <?php } ?>

      </li>
    <?php } ?>
  </ul>
</div>
