<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/../private/initialize.php');

$title = "JS Fun";
$page_heading = "Javascript playground";
$page_subheading = "Scripting Sandbox";
$custom_class = "javascript-page mb-4";

include_once(SHARED_PATH . '/site-header.php');
include(SHARED_PATH . '/navigation.php');
?>

<div class="container <?php echo $custom_class; ?>">

    <?php include('incl/pop-up.php'); ?>

  <section class="js-fun">
    <p class="lead">This page includes pop up functionality</p>

      <?php include_once(SHARED_PATH . '/headline-page.php'); ?>
  </section>

  <section class="js-playground">

      <?php timeOfDayGreeting(); ?>

    <div class="entry-content">
      This is rendered content.
        <?php
        /**
         * This is just a comment to remind me that content gets rendered here
         */
        ?>
      <ul></ul>
    </div>
  </section>

  <section class="js-append-something">
    <h3>This is from the getJSON function in apps.js</h3>
  </section>

  <section>
    <article>
      <h3>Test embedding a GitHub gist</h3>
      <p>Check out my bash profile gist</p>
      <script src="https://gist.github.com/capitalJT/04c8300224c319dc1ccb.js"></script>
    </article>
  </section>

</div>

<?php include_once(SHARED_PATH . '/site-footer.php'); ?>
