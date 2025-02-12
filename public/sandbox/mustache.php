<?php
declare(strict_types=1);

require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');

$title = "Mustache Page";
// this is for <title>

$page_title = "This is the mustache page";
// This is for breadcrumbs if I want a custom title other than the default

$page_subheading = "Welcome to the mustache";
// This is the subheading

$custom_class = "mustache-page";
//custom CSS for this page only

include('../../templates/layouts/header.php');
?>
<div class="container py-5 <?= htmlspecialchars($custom_class); ?>">

  <section class="mustache">
    <hgroup>
      <h1>Mustache Playground</h1>
      <h2>Sub headline</h2>
    </hgroup>
    <p>These colors were pulled from <a href="https://flatuicolors.com/palette/es" target="_blank">Flatuicolors</a></p>
    <p>The data is coming from <code>data/data.json</code></p>

    <!-- JavaScript functionality for this page is implemented in the app.js file -->
    <div id="color-wrapper" class="row"></div>

    <script id="colors-template" type="x-tmpl-mustache">
      {{#colors}}
        <div class="jt-colors col col-sm-3" style="background-color: {{rgba}};">
          <span>{{name}}</span>
          <span>{{hex}}</span>
          <span>{{rgba}}</span>
        </div>
      {{/colors}}
    </script>
  </section>

  <section id="jt-images">
    <hgroup>
      <h1>Mustache Playground</h1>
      <h2>Sub headline</h2>
    </hgroup>
    <div id="image-wrapper"></div>
  </section>

</div>
<?php include('../../templates/layouts/footer.php'); ?>