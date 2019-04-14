$(document).ready(function () {

    console.log("This is runnings");

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

    // Using Mustache
    if ($("#color-wrapper").length){
        $.getJSON('../data/data.json', function(data) {
            var colorTemplate = $('#colors-template').html();
            var colorHtml = Mustache.to_html(colorTemplate, data);
            $('#color-wrapper').html(colorHtml);
            console.log("The color HTML: ", data.colors[1].name);
        });
    }

  // The example of this code is on mustache.php page
  if ($("#image-wrapper").length){
    // Using Reg Ajax
    console.log(" div with id of color-wrapper is indeed present");
    $.ajax({
      url: '../data/list.json',
      dataType: 'json',
      type: 'get',
      cache: false,
      success: function(data){
        $(data.articles).each(function(index,value){
          var $articleImage = "<img class=\"image\" src=\"" + value.imgUrl + "\">";
          var $photoCredit = "<p class=\"photoCredit\">Photo Credit: " + value.photoCredit + "</p>";
          var $articleTitle = "<h2 class=\"title\">" + value.title + "</h2>";
          var $articleAuthor = "<p class=\"author\">By: " + value.author + "</p>";
          var $articleDate = "<p class=\"date\">" + value.date + "</p>";
          var $articleSummary = "<p class=\"summary\">" + value.summary + "</p>";

          var totalArticle = "<article id=" + value.id + " class=\"article\"><span>" +
              $articleImage +
              $photoCredit +
              $articleTitle +
              $articleAuthor +
              $articleDate +
              $articleSummary + "</span></article>";
          
          // console.log("The value", value);
          // console.log(index);

          setTimeout(function(){
            console.log("the number", index);
            // $(totalArticle).appendTo("#image-wrapper").fadeIn(200);
            $(totalArticle).appendTo("#image-wrapper").fadeIn(200);
          }, 200 * index);
        });
      },
      statusCode: {
        404: function() {
          console.log("page not found");
        }
      }
    });  
  }


  var pathname = window.location.pathname;
  var location = window.location;
  var host = window.location.host;
  var origin = window.location.origin;

  console.log('the pathname: ', pathname);
  console.log('the location: ', location);
  console.log('the host: ', host);
  console.log('the origin: ', origin);


  // This is displayed on the `/demos/host-info.php` page
  if ($("#host-info").length){
    $("<div>Pathname: " + pathname + "</div>").appendTo("#host-info");
    $("<div>Location: " + location + "</div>").appendTo("#host-info");
    $("<div>Host: " + host + "</div>").appendTo("#host-info");
    $("<div>Origin: " + origin + "</div>").appendTo("#host-info");
  }


  // The bit of code is being used on http://localhost:3000/demos/js-objects.php
  var jToolTip = $(".jToolTip");

  var pTag = document.createElement("p");
  var innerSpan = document.createElement("span");
  pTag.className = "info p-4";
  pTag.innerHTML = "Window scroll top: ";
  pTag.appendChild(innerSpan);

  jToolTip.append(pTag);

  $(document).on('scroll', function(){
      // update jToolTip
      var scrollTop = $(window).scrollTop().toFixed(2);
      $(".info span").text(scrollTop + "px");

  });









    // Dynamic sidebar on components page
    if ($('.lorem-sidebar').length){
        $('.article-list-wrapper').append('<ul id="rendered-sections-list" class="mb-0"></ul>');

        $( ".component" ).each(function( index ) {
            var theText = $(this).find('.block-headline').text();
            var theId = $(this).attr('id');
            // var theSbt = $(this).parent().data('sidebarText');


            // if (theSbt){
            //     if (!$(this).parent().hasClass('article-list-item')){
            //         $("#rendered-sections-list").append('<li><a href="#'+theId+'" class="ancestor">'  + theSbt + '</a></li>');
            //     } else {
            //         $("#rendered-sections-list").append('<li><a href="#'+theId+'">'  + theSbt + '</a></li>');
            //     }
            // }

            $("#rendered-sections-list").append('<li class="mb-2"><a href="#'+theId+'">'  + theText + '</a></li>');
        });

        $('.article-list-wrapper').append('<div id="scroll-to-top">Scroll To Top</div>');

    }




// calculating some values
    var header_height = $('.main-header').outerHeight(),
        dls_menu = $('.main-navigation').outerHeight(),
        scroll_top_icon = $('#scroll-to-top'),
        nav = $('.lorem-sidebar'),
        sections = $('.components'),
        // sipt = parseInt($('.site-inner').css('padding-top'), 10),
        combined_height = header_height + dls_menu;


    // Scroll to top function 1/2
    $(window).scroll(function(){
        var $scrollTop = $(window).scrollTop();

        if( $scrollTop > header_height ){
            scroll_top_icon.fadeIn();
        } else {
            scroll_top_icon.fadeOut();
        }

        // if( $scrollTop > combined_height ){
        //     nav.addClass( 'sticky-sidebar' );
        // } else {
        //     nav.removeClass( 'sticky-sidebar' );
        // }
    });

    $(window).scroll(function () {
        var cur_pos = $(this).scrollTop();

        sections.each(function() {
            var top = $(this).offset().top,
                bottom = top + $(this).outerHeight();

            if (cur_pos >= top && cur_pos <= bottom) {
                nav.find('a').removeClass('active-nav');
                // nav.find('a').classList.add('active-nav');
                sections.removeClass('active-nav');

                $(this).addClass('active-nav');
                nav.find('a[href="#'+$(this).attr('id')+'"]').addClass('active-nav');
            }
            if (cur_pos < combined_height) {
                nav.find('a').removeClass('active-nav');
            }

        });

        $('.component').each(function(){
            var top = $(this).offset().top,
                bottom = top + $(this).outerHeight();
            if (cur_pos >= top && cur_pos <= bottom) {
                nav.find('a').removeClass('active-nav');
                sections.removeClass('active-nav');

                $(this).addClass('active-nav');
                nav.find('a[href="#'+$(this).attr('id')+'"]').addClass('active-nav');
            }
            if (cur_pos < combined_height) {
                nav.find('a').removeClass('active-nav');
            }
        });

    });

    // Scroll to top function 2/2
    scroll_top_icon.click(function(){
        var body = $("html, body");
        body.animate({scrollTop:0}, '500', 'swing');
    });

    // - Smooth scroll sidebar

    $('li a').on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var $el = $(this),
            id = $el.attr('href');

        $('html, body').animate({
            scrollTop: $(id).offset().top + 1
        }, 500);

        console.log('The ID: ' + id);

        return false;
    });
});


(function($) {
    'use strict';

    // This is being used on the heros demo pages
    $(document).ready(function() {

        if ($('.paragraph--type--hero-jt').length) {

            var sameSize = function () {
                var elHeight = $(".hero-background-image-alt").height();
                $(".paragraph--type--hero-jt").height(elHeight);
            };

            $(window).on('resize', function() {
                sameSize();
            });

            sameSize();

        }

    });

})(jQuery);