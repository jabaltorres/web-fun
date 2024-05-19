<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');
    // this is for <title>
    $title = "Lorem Ipsum";

    // This is for breadcrumbs if I want a custom title other than the default
    $page_title = "Lorem ipsum playground";

    // This is the subheading
    $page_subheading = "Make your own ipsum";

    //custom CSS for this page only
    $custom_class = "page-lorem-ipsum";

    include_once(SHARED_PATH . '/site_header.php');
?>

<?php include_once(SHARED_PATH . '/navigation.php');?>

<div class="container <?php echo $custom_class; ?>">
    <section>

        <header>
          <h1 class="h2"><?php echo $title; ?></h1>
          <h2 class="h3"><?php echo $page_subheading; ?></h2>
        </header>

        <div id="accordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Lorem Ipsum
                        </button>
                    </h5>
                </div>

                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sed enim neque. Ut quis euismod sapien. Nulla placerat, elit sit amet consectetur molestie, turpis velit cursus libero, id mattis est tortor vel nibh. Morbi placerat sed risus sed dignissim. Sed quis molestie sem. Pellentesque molestie fringilla augue ut porta. Quisque suscipit turpis quis leo tempor ultricies. Nulla urna tortor, maximus nec maximus a, varius ut ex. Vestibulum rutrum egestas risus eget viverra. Integer aliquam purus eu tortor maximus placerat. Maecenas enim nulla, commodo vitae porttitor vel, cursus eget arcu. Cras posuere mi eu lacus rutrum, ut scelerisque odio luctus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus rhoncus nunc eu magna aliquam, ac elementum leo aliquet.</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Bacon Ipsum
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <p>Bacon ipsum dolor amet turducken jowl flank strip steak pork shank. Picanha chuck shank flank shoulder pancetta ham hock turducken venison tenderloin t-bone. Strip steak chuck prosciutto capicola fatback, swine bacon spare ribs hamburger bresaola. Porchetta shank turducken, rump biltong hamburger drumstick jowl burgdoggen chuck bresaola.</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Hipster Ipsum
                        </button>
                    </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <p>Hot chicken locavore actually helvetica. Intelligentsia bicycle rights yuccie, readymade green juice waistcoat farm-to-table literally. Bitters knausgaard schlitz photo booth tumeric artisan. Yr gastropub whatever hexagon, cardigan disrupt tote bag iPhone aesthetic actually health goth trust fund artisan tousled lumbersexual. Normcore vape viral next level. Tattooed deep v everyday carry polaroid. Heirloom retro godard enamel pin.</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingFour">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Office Ipsum
                        </button>
                    </h5>
                </div>
                <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                    <div class="card-body">
                        <p>Where do we stand on the latest client ask forcing function shoot me an email and wiggle room, but knowledge process outsourcing nor we've got to manage that low hanging fruit can you ballpark the cost per unit for me. Curate can we align on lunch orders. Future-proof that jerk from finance really threw me under the bus, so value prop or blue sky thinking goalposts. Are there any leftovers in the kitchen?</p>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

<?php include_once(SHARED_PATH . '/site_footer.php');?>