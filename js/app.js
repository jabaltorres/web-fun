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





var Aivl = {
  init: function(){

    var popUpContainer = document.getElementById('pop-up');

    if ( popUpContainer ){
      popUpContainer.addEventListener("click", Aivl.hidePopUp);
    }
  },
  hidePopUp: function(){
    this.style.display = "none";
  }
};
Aivl.init();