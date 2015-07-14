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



var Avil = Avil || {};
Avil.PopUp = (function() {
   var popUpContainer = document.getElementById('pop-up');

   popUpContainer.addEventListener("click", function(){
    this.style.display = "none";
   });
});

Avil.PopUp();