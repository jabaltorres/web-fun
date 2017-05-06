<?
  $title = "Icons Page"; 
  // this is for <title>

  $page_title = "This is the icons page";
  // This is for breadcrumbs if I want a custom title other than the default

  $page_subheading = "Welcome to the Icons page"; 
  // This is the subheading

  $custom_class = "icons-page"; 
  //custom CSS for this page only

  // Preliminaries
  include_once('../config.php');  
  include_once(INCLUDES_PATH . '/head.php');
?>
  <div class="container <?php echo $custom_class; ?>">
    <?php
      include_once(INCLUDES_PATH . '/masthead.php');
      include_once(INCLUDES_PATH . '/navigation.php');
      include_once(INCLUDES_PATH . '/headline-page.php');
    ?>

    <section>
      <h3>SVG Icon - Regular</h3>
      <ul class="svg-icon-list">
        <li><span class="icon analyst-report"></span></li>
        <li><span class="icon balance-sheet"></span></li>
        <li><span class="icon best-practices"></span></li>
        <li><span class="icon blog-post"></span></li>
        <li><span class="icon brochure"></span></li>
        <li><span class="icon building-1"></span></li>
        <li><span class="icon calendar-2"></span></li>
        <li><span class="icon calendar-4"></span></li>
        <li><span class="icon capital-management"></span></li>
        <li><span class="icon collaborative"></span></li>
        <li><span class="icon comprehensive"></span></li>
        <li><span class="icon continuous"></span></li>
        <li><span class="icon customer-story"></span></li>
        <li><span class="icon datasheet"></span></li>
        <li><span class="icon demo"></span></li>
        <li><span class="icon disability-insurance"></span></li>
        <li><span class="icon donut"></span></li>
        <li><span class="icon easy"></span></li>
        <li><span class="icon ebook"></span></li>
        <li><span class="icon expense-management"></span></li>
        <li><span class="icon fast"></span></li>
        <li><span class="icon financial-close"></span></li>
        <li><span class="icon generic-money-bill"></span></li>
        <li><span class="icon hand-and-coins"></span></li>
        <li><span class="icon healthcare"></span></li>
        <li><span class="icon idea"></span></li>
        <li><span class="icon in-person-event"></span></li>
        <li><span class="icon infographic"></span></li>
        <li><span class="icon news"></span></li>
        <li><span class="icon powerful"></span></li>
        <li><span class="icon revenue-management"></span></li>
        <li><span class="icon video"></span></li>
        <li><span class="icon webcast"></span></li>
        <li><span class="icon webinar"></span></li>
        <li><span class="icon whitepaper"></span></li>
        <li><span class="icon workforce-management"></span></li>
      </ul>

      <h3>SVG Icon - Small</h3>
      <ul class="svg-icon-list">
        <li><span class="icon analyst-report-sm"></span></li>
        <li><span class="icon balance-sheet-sm"></span></li>
        <li><span class="icon best-practices-sm"></span></li>
        <li><span class="icon blog-post-sm"></span></li>
        <li><span class="icon brochure-sm"></span></li>
        <li><span class="icon building-1-sm"></span></li>
        <li><span class="icon calendar-2-sm"></span></li>
        <li><span class="icon calendar-4-sm"></span></li>
        <li><span class="icon capital-management-sm"></span></li>
        <li><span class="icon collaborative-sm"></span></li>
        <li><span class="icon comprehensive-sm"></span></li>
        <li><span class="icon continuous-sm"></span></li>
        <li><span class="icon customer-story-sm"></span></li>
        <li><span class="icon datasheet-sm"></span></li>
        <li><span class="icon demo-sm"></span></li>
        <li><span class="icon disability-insurance-sm"></span></li>
        <li><span class="icon donut-sm"></span></li>
        <li><span class="icon easy-sm"></span></li>
        <li><span class="icon ebook-sm"></span></li>
        <li><span class="icon expense-management-sm"></span></li>
        <li><span class="icon fast-sm"></span></li>
        <li><span class="icon financial-close-sm"></span></li>
        <li><span class="icon generic-money-bill-sm"></span></li>
        <li><span class="icon hand-and-coins-sm"></span></li>
        <li><span class="icon healthcare-sm"></span></li>
        <li><span class="icon idea-sm"></span></li>
        <li><span class="icon in-person-event-sm"></span></li>
        <li><span class="icon infographic-sm"></span></li>
        <li><span class="icon news-sm"></span></li>
        <li><span class="icon powerful-sm"></span></li>
        <li><span class="icon revenue-management-sm"></span></li>
        <li><span class="icon video-sm"></span></li>
        <li><span class="icon webcast-sm"></span></li>
        <li><span class="icon webinar-sm"></span></li>
        <li><span class="icon whitepaper-sm"></span></li>
        <li><span class="icon workforce-management-sm"></span></li>
      </ul>
    </section>
  </div><!-- end .container -->

<?php include_once(INCLUDES_PATH . '/footer.php');?>