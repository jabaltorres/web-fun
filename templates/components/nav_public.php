<?php
  // Default values to prevent errors
  $page_id = $page_id ?? '';
  $subject_id = $subject_id ?? '';
  $visible = !$app['pageService']->is_preview();
  $subjects = $app['pageService']->findAllSubjects();
?>

<div class="sidebar">
  <ul class="list-group subjects">
    <?php foreach($subjects as $subject) { ?>
      <li class="list-group-item <?php if($subject['id'] == $subject_id) { echo 'selected'; } ?>">
        <a href="<?php echo url_for('/page.php?subject_id=' . h(urlencode((string)$subject['id']))); ?>">
          <?php echo h($subject['menu_name']); ?>
        </a>

        <?php if($subject['id'] == $subject_id) { ?>
          <?php 
          $nav_pages = $app['pageService']->findPagesBySubjectId($subject['id'], ['visible' => $visible]); 
          ?>
          <ul class="pages">
            <?php foreach($nav_pages as $nav_page) { ?>
              <li class="<?php if($nav_page['id'] == $page_id) { echo 'selected'; } ?>">
                <a href="<?php echo url_for('page.php?id=' . h(urlencode((string)$nav_page['id']))); ?>">
                  <?php echo h($nav_page['menu_name']); ?>
                </a>
              </li>
            <?php } ?>
          </ul>
        <?php } ?>

      </li>
    <?php } // foreach $subjects ?>
  </ul>
</div>
