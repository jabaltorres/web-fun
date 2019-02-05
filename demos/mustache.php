<?php
  require_once '../config.php';

  $title = "Mustache Page"; 
  // this is for <title>

  $page_title = "This is the mustache page";
  // This is for breadcrumbs if I want a custom title other than the default

  $page_subheading = "Welcome to the mustache"; 
  // This is the subheading

  $custom_class = "mustache-page"; 
  //custom CSS for this page only

  include_once(INCLUDES_PATH . '/site-header.php');
?>


  <div class="container <?php echo $custom_class; ?>">
  
  <?php 
    include_once(INCLUDES_PATH . '/masthead.php');
    include_once(INCLUDES_PATH . '/navigation.php');
  ?>


  <section class="mustache">
    <hgroup>
      <h1>Mustache Playground</h1>
      <h2>Sub headline</h2>
    </hgroup>
    <p>Insert web mustache here</p>

    <!-- The js for this is in the app.js file -->
    <div id="color-wrapper"></div>

    <script id="colors-template" type="x-tmpl-mustache">

      {{#colors}}
        <div class="jt-colors col col-xs-4" style= "background-color: {{rgba}};">
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
  
  <section id="jt-type">
    <hgroup>
      <h1>Typography</h1>
      <h2>Sub headline</h2>
    </hgroup>
    <div class="row">
      <div class="column column-8 font-pairing-example">
        <h3>I am Mr. Roboto</h3>
        <h4>Cool Type Pairing</h4>
      </div>
    </div>
    <div class="row">
      <div class="column column-1">
        <span>Heading 1</span>
      </div>
      <div class="column column-7">
        <h1>This is a very large header.</h1>
      </div>
    </div>
    <div class="row">
      <div class="column column-1">
        <span>Heading 2</span>
      </div>
      <div class="column column-7">
        <h2>This is a large header.</h2>
      </div>
    </div>
    <div class="row">
      <div class="column column-1">
        <span>Heading 3</span>
      </div>
      <div class="column column-7">
        <h3>This is a medium header.</h3>
      </div>
    </div>
    <div class="row">
      <div class="column column-1">
        <span>Heading 4</span>
      </div>
      <div class="column column-7">
        <h4>This is a moderate header.</h4>
      </div>
    </div>
    <div class="row">
      <div class="column column-1">
        <span>Heading 5</span>
      </div>
      <div class="column column-7">
        <h5>This is a small header.</h5>
      </div>
    </div>
    <div class="row">
      <div class="column column-1">
        <span>Heading 6</span>
      </div>
      <div class="column column-7">
        <h6>This is a timy header.</h6>
      </div>
    </div>
  </section>

<?php include_once(INCLUDES_PATH . '/site-footer.php');?>