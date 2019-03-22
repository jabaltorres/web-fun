<?php
    require_once '../private/initialize.php';
    // this is for <title>
    $title = "Lorem Ipsum";

    // This is for breadcrumbs if I want a custom title other than the default
    $page_title = "Lorem ipsum playground";

    // This is the subheading
    $page_subheading = "Make your own bacon ipsum";

    //custom CSS for this page only
    $custom_class = "page-lorem-ipsum";

    include_once(INCLUDES_PATH . '/site-header.php');
?>

<div class="container <?php echo $custom_class; ?>">

  <?php include_once(INCLUDES_PATH . '/masthead.php');?>
  <?php include_once(INCLUDES_PATH . '/navigation.php');?>

  <section>

    <header>
      <h1 class="h2"><?php echo $title; ?></h1>
      <h2 class="h3"><?php echo $page_subheading; ?></h2>
    </header>

    <article>
      <h3><a href="https://www.lipsum.com/" target="_blank">Lorem Ipsum</a></h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sed enim neque. Ut quis euismod sapien. Nulla placerat, elit sit amet consectetur molestie, turpis velit cursus libero, id mattis est tortor vel nibh. Morbi placerat sed risus sed dignissim. Sed quis molestie sem. Pellentesque molestie fringilla augue ut porta. Quisque suscipit turpis quis leo tempor ultricies. Nulla urna tortor, maximus nec maximus a, varius ut ex. Vestibulum rutrum egestas risus eget viverra. Integer aliquam purus eu tortor maximus placerat. Maecenas enim nulla, commodo vitae porttitor vel, cursus eget arcu. Cras posuere mi eu lacus rutrum, ut scelerisque odio luctus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus rhoncus nunc eu magna aliquam, ac elementum leo aliquet.</p>  
    </article>
    
    <article>
      <h3><a href="https://baconipsum.com/?paras=5&type=all-meat&start-with-lorem=1" target="_blank">Bacon Ipsum</a></h3>
      <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone. Strip steak chuck prosciutto capicola fatback, swine bacon spare ribs hamburger bresaola. Porchetta shank turducken, rump biltong hamburger drumstick jowl burgdoggen chuck bresaola.</p>  
    </article>

    <article>
      <h3><a href="https://hipsum.co/?paras=5&type=hipster-centric&start-with-lorem=1" target="_blank">Hipster Ipsum</a></h3>
      <p>Hot chicken locavore actually helvetica. Intelligentsia bicycle rights yuccie, readymade green juice waistcoat farm-to-table literally. Bitters knausgaard schlitz photo booth tumeric artisan. Yr gastropub whatever hexagon, cardigan disrupt tote bag iPhone aesthetic actually health goth trust fund artisan tousled lumbersexual. Normcore vape viral next level. Tattooed deep v everyday carry polaroid. Heirloom retro godard enamel pin.</p>  
    </article>

    <article>
      <h3><a href="http://officeipsum.com/index.php" target="_blank">Office Ipsum</a></h3>
      <p>Where do we stand on the latest client ask forcing function shoot me an email and wiggle room, but knowledge process outsourcing nor we've got to manage that low hanging fruit can you ballpark the cost per unit for me. Curate can we align on lunch orders. Future-proof that jerk from finance really threw me under the bus, so value prop or blue sky thinking goalposts. Are there any leftovers in the kitchen?</p>  
    </article>
  
  </section>
</div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');?>