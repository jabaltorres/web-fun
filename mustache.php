<?php include 'includes/head.php';?>
  <div class="container">
  
  <?php 
    include 'includes/masthead.php';
    include 'includes/navigation.php';
  ?>


  <section class="mustache">
    <hgroup>
      <h1>Mustache Playground</h1>
      <h2>Sub headline</h2>
    </hgroup>
    <p>Insert web mustache here</p>

    <div id="color-wrapper"></div>
    <script id="colors-template" type="x-tmpl-mustache">
      {{#colors}}
        <div class="jt-colors" style= "background-color: {{rgba}};">
          <span>{{name}}</span>
          <span>{{hex}}</span>
          <span>{{rgba}}</span>
        </div>
      {{/colors}}
    </script>
  </section>

  <section id="jt-images">
    <header>
      <h1>Images</h1>
      <span>This is an example section</span>
      <div id="image-wrapper"></div>
    </header>
  </section>
  
<?php include 'includes/feet.php';?>