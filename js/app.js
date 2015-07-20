$('#nav-menu-icon').click(function(){
  $(this).toggleClass('open');
  $('.main-navigation').stop(true).slideToggle("fast");
});

$('.carousel-wrapper').slick({
    autoplay: true,
    mobileFirst: true,
    dots: true
    // arrows:false
});

