$(document).ready(function () {

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

  var pathname = window.location.pathname;
  var location = window.location;
  var host = window.location.host;
  var origin = window.location.origin;

  console.log('the pathname: ', pathname);
  console.log('the location: ', location);
  console.log('the host: ', host);
  console.log('the origin: ', origin);
  
  if ($("#jt-images").length){
    // Using Mustache
    $.getJSON('data/data.json', function(data) {
      var colorTemplate = $('#colors-template').html();
      var colorHtml = Mustache.to_html(colorTemplate, data);
      $('#color-wrapper').html(colorHtml);
      console.log("The color HTML: ", data.colors[1].name);
    });
  }
  
  if ($("#color-wrapper").length){
    // Using Reg Ajax
    console.log("color wrapper is indeed present");
    $.ajax({
      url: 'data/list.json',
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
          console.log("page not found")
        }
      }
    });  
  }

  // $('section').each(function(){
  //   //$(this).css("border", "solid thick yellow");
  //   var closeBtn = $('<span class="close-btn">Close This</span>');
  //   $(this).prepend(closeBtn);
  // });
});