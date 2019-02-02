(function($) {
  $(document).ready(function () {
    function responsive_resize(){
      var current_width = $(window).width();
      var test_width = 768;
      if (current_width > test_width){
        $('.partners, .expanded').addClass("is-large").removeClass("is-small");
      }
      else if (current_width < test_width){
        $('.partners, .expanded').addClass("is-small").removeClass("is-large");
      }
    }

    function wrap_featured_partners(){
      var divs = $(".featured-partners .partner");
      for (var i = 0; i < divs.length; i+=3) {
        divs.slice(i, i+3).wrapAll("<div class='row'></div>");
      }  
    }
    function wrap_partners(){
      var divs = $(".partners .partner");
      for (var i = 0; i < divs.length; i+=4) {
        divs.slice(i, i+4).wrapAll("<div class='row'></div>");
      }  
    }

    function move_form_item(){
      $(".form-item-distance-postal-code").insertAfter( $(".form-item-distance-search-units") );
    }

    $(function() {
      responsive_resize();
      // wrap_featured_partners();
      // wrap_partners();
      // move_form_item();
    });

    // On user resize, run responsive_resize();
    $(window).resize(function(){
      responsive_resize();
    });

    $('.partners .learn-more').on('click', function(event){
      event.preventDefault();
      var textWrap = $(this).parents('.card').children('.wrapper.text');
      var partnersSection = $(this).parents('.partners');
      var partnerCard = $(this).parents('.partner');
      var theRow = $(this).parents('.row')[0];

      $('.partner').not(partnerCard).removeClass('active');
      partnerCard.toggleClass('active');

      // conditional for mobile
      if ($('.partners').hasClass("is-small")){
        $('html, body').animate({ scrollTop: partnerCard.offset().top }, 300);
        $('.expanded').remove();
        textWrap.clone().insertAfter(theRow).wrap( '<div class="expanded is-small"></div>' );
      }

      if ( partnersSection.hasClass( "is-large" ) ) {
        $('.expanded').remove();
        textWrap.clone().insertAfter(theRow).wrap( '<div class="expanded"></div>' );

        // toggle to close `.expanded`
        if (!$(partnerCard).hasClass("active")){
          $('.expanded').remove();
        }
      }
    });

    // close button clicked
    // $(document).click(function(event) {
    //   var close = $(event.target);
    //   console.log(event.target);
    //   if ( close.hasClass('fa-times') ){
    //     $('.partner').removeClass('active');
    //     $('.expanded').remove();
    //     if ( partnersSection.hasClass( "is-small" ) ) {
    //       textWrap.toggleClass('visible');
    //     }
    //   }
    // });

    $(document).on("click", ".close-x", function(){
      // console.log("clicked");
      var textWrap = $(this).parents('.card').children('.wrapper.text');
      var partnersSection = $(this).parents('.partners');
      $('.partner').removeClass('active');
      $('.expanded').remove();
      if ( partnersSection.hasClass( "is-small" ) ) {
        textWrap.toggleClass('visible');
      }
    });

    // this rewraps the partners in .row after ajax call
    $( document ).ajaxComplete(function() {
      // console.log("ajaxComplete");
      wrap_partners();
    });
  });
})(jQuery);