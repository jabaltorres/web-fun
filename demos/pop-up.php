<?php include 'includes/head.php';?>
  <div class="container">
  
  <?php 
    include '../includes/masthead.php';
    include '../includes/navigation.php';
    include '../includes/aivl-pop-up.php'; 
  ?>


  <section class="js-fun">
    <hgroup>
      <h1>JS Playground</h1>
      <h2>Sub headline</h2>
    </hgroup>
    <p>Insert web fun here</p>

    <?php echo $_SERVER['DOCUMENT_ROOT']; ?>

    <ul>
      <li class=""><a href="tooltip.php">Tooltip</a></li>
    </ul>

    <div>
      <h2>Link Test</h2>
      <a href="#" class="text-link">This is a test</a>
    </div>
  </section>
<?php include './includes/feet.php';?>