<?php
    require_once '../private/initialize.php';
    // this is for <title>
    $title = "Heroes";

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

  </section>
</div>


<div class="paragraph--type--hero has-bg-image homepage-hero">
    <img src="/dist/images/pf-changs-1.png" style="display: none;">
    <div class="hero-background-image bg-5">
        <div class="container">
            <div class="row content-wrapper">
                <div class="col-12 col-lg-6">
                    <h1 class="hero-headline font-weight-normal">Everybody plans. We make planning easy.</h1>
                    <div class="hero-body">
                        <p class="lead font-sans-serif">Adaptive Insights Business Planning Cloud &mdash; a powerful new generation of business planning software for finance and beyond.</p>
                        <a href="#" class="btn btn-secondary text-uppercase font-weight-bold">see what's possible</a>
                    </div>
                </div>
            </div>
            <span class="img-caption text-white font-sans-serif d-none d-lg-inline small">P.F. Chang's runs on Adaptive Insights</span>
        </div>
    </div>
</div>

<div class="paragraph-section bg-primary    py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-10 offset-lg-1 mb-3 pb-md-3 text-center">
                <h2 class="mb-3 text-center font-weight-normal">Software for people who plan</h2>
                <p class="">At Adaptive Insights we make planning easy. That's why we built the world's first business planning cloud–so you can make smarter decisions faster. Get business agility in a fast-moving&nbsp;world.</p>
            </div>
            <div class="aiForPlanning col-12 col-md-7 mb-3 mb-lg-0">
                <h3 class="m-b white px-md-2">Adaptive Insights for Finance</h3>
                <div class="px-md-2">
                    <p class="mb-1">Traditional financial planning is too hard and too slow for today's agile businesses. For active planning, you need a solution that's easy, powerful, and fast. Adaptive Insights for Finance is business planning software that provides everything you need to enable an active financial planning process. Easy to use and accessible from anywhere, our modeling and reporting software empowers you and your team to do your best work and better manage your business.</p>
                    <a class="pl-0 font-weight-bold btn btn-link btn-lg text-white font-size-md" href="/adaptive-insights-for-finance">Plan Smarter <i class="fas fa-chevron-right fa-xs"></i></a>
                </div>
            </div>
            <div class="aiForSales col-12 col-md-5">
                <h3 class="m-b white px-md-2">Adaptive Insights for Sales</h3>
                <div class="px-md-2">
                    <p class="mb-1">Build rep capacity plans to meet topline bookings targets. Optimally deploy quota and set up balanced territories so that all your reps are successful. Collaborate on what-if scenarios and make decisions with real data in real time. And get a single source of truth by linking your sales and financial plans.</p>
                    <a class="pl-0 font-weight-bold btn btn-link btn-lg text-white font-size-md" href="/adaptive-insights-for-finance">Drive Sales Productivity <i class="fas fa-chevron-right fa-xs"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="paragraph-section paragraph--type--quote bg-light mb-5 py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2 paragraph-copy">
                <blockquote class="blockquote text-center">
                    <p>With Adaptive Insights, we achieved a better budget process at a fraction of the cost compared to the millions of dollars and years of investment spent maintaining the on-premise solution.</p>
                    <footer class="blockquote-footer"><span class="author font-weight-bold">Mark Powers</span>, <cite title="Source Title">Senior Finance Manager, Boston Scientific</cite></footer>
                </blockquote>
            </div>
        </div>
    </div>
</div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');?>