<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../private/initialize.php');
    // this is for <title>
    $title = "Heroes";

    // This is for breadcrumbs if I want a custom title other than the default
    $page_title = "Lorem ipsum playground";

    // This is the subheading
    $page_subheading = "Make your own bacon ipsum";

    //custom CSS for this page only
    $custom_class = "page-lorem-ipsum";

    include_once(SHARED_PATH . '/site_header.php');
?>

<div class="container <?php echo $custom_class; ?>">
  <?php include_once(SHARED_PATH . '/navigation.php');?>

  <section>

    <header>
      <h1 class="h2"><?php echo $title; ?></h1>
      <h2 class="h3"><?php echo $page_subheading; ?></h2>
    </header>

    <article>
      <h3><a href="https://www.lipsum.com/" target="_blank">Lorem Ipsum</a></h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sed enim neque. Ut quis euismod sapien. Nulla placerat, elit sit amet consectetur molestie, turpis velit cursus libero, id mattis est tortor vel nibh. Morbi placerat sed risus sed dignissim. Sed quis molestie sem. Pellentesque molestie fringilla augue ut porta. Quisque suscipit turpis quis leo tempor ultricies. Nulla urna tortor, maximus nec maximus a, varius ut ex. Vestibulum rutrum egestas risus eget viverra. Integer aliquam purus eu tortor maximus placerat. Maecenas enim nulla, commodo vitae porttitor vel, cursus eget arcu. Cras posuere mi eu lacus rutrum, ut scelerisque odio luctus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus rhoncus nunc eu magna aliquam, ac elementum leo aliquet.</p>  
    </article>

  </section>
</div>


<div class="paragraph--type--hero mb-4 has-bg-image">
    <img src="../public/images/PF_Changs-0066-F_preview.jpeg" style="display: none;">
    <div class="hero-background-image bg-1 py-5">
        <div class="container">
            <div class="row content-wrapper">
                <div class="col-12 col-md-10">
                    <h1 class="hero-headline">Easy, Powerful, and Fast Business Planning Software</h1>
                    <div class="hero-body">
                        <p class="lead">Save time, build trust, and improve your team's performance with planning software built for agile&nbsp;businesses.</p>
                        <a href="#" class="btn btn-secondary text-uppercase">see what's possible</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="paragraph--type--hero mb-4 has-bg-image">
    <img src="../public/images/PF_Changs-0066-F_preview.jpeg" style="display: none;">
    <div class="hero-background-image bg-2">
        <div class="container">
            <div class="row content-wrapper">
                <div class="col-12 col-md-6">
                    <h1 class="hero-headline">Easy, Powerful, and Fast Business Planning Software</h1>
                    <div class="hero-body">
                        <p class="lead">Save time, build trust, and improve your team's performance with planning software built for agile&nbsp;businesses.</p>
                        <a href="#" class="btn btn-secondary text-uppercase font-weight-bold">see what's possible</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="paragraph--type--hero mb-4 has-bg-image">
    <img src="../public/images/PF_Changs-0066-F_preview.jpeg" style="display: none;">
    <div class="hero-background-image bg-3">
        <div class="container">
            <div class="row content-wrapper">
                <div class="col-12 col-lg-6">
                    <h1 class="hero-headline">Easy, Powerful, and Fast Business Planning Software</h1>
                    <div class="hero-body">
                        <p class="lead">Save time, build trust, and improve your team's performance with planning software built for agile&nbsp;businesses.</p>
                        <a href="#" class="btn btn-secondary text-uppercase font-weight-bold">see what's possible</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="paragraph--type--hero mb-4 has-bg-image">
    <img src="../public/images/PF_Changs-0066-F_preview-cropped-transparency.png" style="display: none;">
    <div class="hero-background-image bg-4">
        <div class="container">
            <div class="row content-wrapper">
                <div class="col-12 col-lg-6">
                    <h1 class="hero-headline">Easy, Powerful, and Fast Business Planning Software</h1>
                    <div class="hero-body">
                        <p class="lead">Save time, build trust, and improve your team's performance with planning software built for agile&nbsp;businesses.</p>
                        <a href="#" class="btn btn-secondary text-uppercase font-weight-bold">see what's possible</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="paragraph--type--hero mb-4 has-bg-image">
    <img src="../public/images/PF_Changs-0066-F_preview-cropped-transparency.png" style="display: none;">
    <div class="hero-background-image bg-5">
        <div class="container">
            <div class="row content-wrapper">
                <div class="col-12 col-lg-6">
                    <h1 class="hero-headline">Easy, Powerful, and Fast Business Planning Software</h1>
                    <div class="hero-body">
                        <p class="lead">Save time, build trust, and improve your team's performance with planning software built for agile&nbsp;businesses.</p>
                        <a href="#" class="btn btn-secondary text-uppercase font-weight-bold">see what's possible</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once(SHARED_PATH . '/site-footer.php');?>