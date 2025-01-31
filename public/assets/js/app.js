(function($) {
  $(document).ready(function() {
    // Initialize carousel
    $('.carousel-wrapper').slick({
      autoplay: true,
      mobileFirst: true,
      dots: true
    });

    // Load colors using Mustache
    if ($("#color-wrapper").length) {
      $.getJSON('/data/data.json', function(data) {
        const colorTemplate = $('#colors-template').html();
        const colorHtml = Mustache.to_html(colorTemplate, data);
        $('#color-wrapper').html(colorHtml);
        console.log("The color HTML: ", data.colors[1].name);
      });
    }

    // Load articles using AJAX
    if ($("#image-wrapper").length) {
      console.log("Div with id of color-wrapper is present");
      $.ajax({
        url: '/data/list.json',
        dataType: 'json',
        type: 'get',
        cache: false,
        success: function(data) {
          $(data.articles).each((index, value) => {
            const totalArticle = `
              <article id="${value.id}" class="article">
                <span>
                  <img class="image" src="${value.imgUrl}">
                  <p class="photoCredit">Photo Credit: ${value.photoCredit}</p>
                  <h2 class="title">${value.title}</h2>
                  <p class="author">By: ${value.author}</p>
                  <p class="date">${value.date}</p>
                  <p class="summary">${value.summary}</p>
                </span>
              </article>`;
            setTimeout(() => {
              $(totalArticle).appendTo("#image-wrapper").fadeIn(200);
            }, 200 * index);
          });
        },
        statusCode: {
          404: function() {
            console.log("Page not found");
          }
        }
      });
    }

    // Tooltip for scroll position
    const jToolTip = $(".jToolTip");
    const pTag = $('<p class="info p-4">Window scroll top: <span>0</span></p>');
    jToolTip.append(pTag);

    $(document).on('scroll', () => {
      const scrollTop = $(window).scrollTop().toFixed(2);
      $(".info span").text(`${scrollTop}px`);
    });

    // Scroll to top functionality
    const scrollTopIcon = $('#scroll-to-top');
    $(window).scroll(() => {
      const scrollTop = $(window).scrollTop();
      scrollTop > $('.main-header').outerHeight() ? scrollTopIcon.fadeIn() : scrollTopIcon.fadeOut();
    });

    scrollTopIcon.click(() => {
      $("html, body").animate({ scrollTop: 0 }, 500, 'swing');
    });

    // Smooth scroll for sidebar
    $('.sidebar-nav').on('click', function(e) {
      e.preventDefault();
      const id = $(this).attr('href');
      $('html, body').animate({ scrollTop: $(id).offset().top + 1 }, 500);
      console.log('The ID: ' + id);
    });
  });
})(jQuery);

// Hero demo page functionality
(function($) {
  $(document).ready(function() {
    if ($('.paragraph--type--hero-jt').length) {
      const sameSize = () => {
        const elHeight = $(".hero-background-image-alt").height();
        $(".paragraph--type--hero-jt").height(elHeight);
      };

      $(window).on('resize', sameSize);
      sameSize();
    }
  });
})(jQuery);

// JavaScript page functionality
(function($) {
  $(document).ready(function() {
    if ($('.javascript-page').length) {
      const vidyardVideos = {
        video1: { uuid: "Rh2oJsa3HDj1hVPfKDCdeg", hash: "#reports-demo", name: "Reports Demo", text: "<p>The best movie ever.</p>" },
        video2: { uuid: "APxTNIXtBL6SoluRC_N2dQ", hash: "#sheets-demo", name: "Sheets Demo", text: "<p>The second best movie ever.</p>" },
        video3: { uuid: "OxCDlNlSTZ2ZuT4xfUHKtQ", hash: "#dashboards-demo", name: "Dashboards Demo", text: "<p>The third best movie ever.</p>" },
        video4: { uuid: "5jgoBXkZCujmc_q02qj-eQ", hash: "#financial-planning-demo-sales", name: "Financial Planning Demo: Sales", text: "<p>The fourth best movie ever.</p>" },
        video5: { uuid: "X7Xhgmr_mXla9giD6Vlb5A", hash: "#captital-management-demo", name: "Capital Management Demo", text: "<p>The fifth best movie ever.</p>" },
        video6: { uuid: "48hjkrhSGAwiJ4c2_uA3oQ", hash: "#profitability-analysis-demo", name: "Profitability Analysis Demo", text: "<p>The sixth best movie ever.</p>" },
        video7: { uuid: "Q3hlMwq93Y157_RxYjtkcQ", hash: "#financial-close-demo", name: "Financial Close Demo", text: "<p>The seventh best movie ever.</p>" }
      };

      for (const key in vidyardVideos) {
        if (vidyardVideos.hasOwnProperty(key)) {
          const video = vidyardVideos[key];
          console.log(`Key: ${key}, Text: ${video.text}, Video UUID: ${video.uuid}, Hash: ${video.hash}`);
        }
      }

      // Fetch data from external source
      $.getJSON('https://gist.githubusercontent.com/jabaltorres/1c7e9304cfb86ffa857c8081b6752366/raw/d2f9a86cc4f550c398c79a4733216cb1938045f9/jt-data.json', function(data) {
        const items = data.map(obj => `<li><div class='text mb-3'><div>${obj.description}</div><span class="role">${obj.role}</span></div></li>`);
        $("<ul/>", { "class": "thumbnail-list", html: items }).appendTo(".js-append-something");
      });

      // Add two numbers
      const add = (num1, num2) => num1 + num2;
      console.log('Two numbers added together: ' + add(12, 23));

      // Array example
      const numbers = [9, 5, 7, 9, 11, 4, 3, 2, 17];
      numbers.forEach((element, index) => {
        const double = element * 2;
        console.log(`The index: ${index}, and the doubled value: ${double}`);
        if (double === 10) {
          console.log("Bingo Jango!");
        }
        if ($('.js-playground').length) {
          $('.entry-content ul').append('<li>' + element + '</li>');
        }
      });

      // Create input and new element
      const createInput = () => {
        const input = $('<input>', {
          id: "jt-text-input",
          type: "text",
          placeholder: "Enter your value here",
          css: { color: 'red', border: '1px solid blue', display: 'block' }
        });
        if ($('.js-playground').length) {
          $('.entry-content').append(input);
        }
      };

      const addElement = () => {
        const newDiv = $('<div>', { id: 'new-div', class: 'new-class', text: "Hi there, and greetings!" });
        if ($('.js-playground').length) {
          $('.entry-content').append(newDiv);
        }
      };

      addElement();
      createInput();

      // Handle enter key press
      $("#jt-text-input").on("keydown", function(e) {
        if (e.key === "Enter") {
          const thisVal = $(this).val();
          console.log('This value: ' + thisVal);
          $('#new-div').css({ padding: '12px', border: `solid thin ${thisVal}` }).text(thisVal);
        }
      });

      // Closures example
      const doSomeMath = (a, b) => {
        const c = 3;
        return () => a * b / c;
      };

      const theResult = doSomeMath(12, 3);
      console.log('This is the result of the doSomeMath function: ' + theResult());

      // Fade in elements on scroll
      $(window).scroll(() => {
        $('.hide-me').each(function() {
          const bottomOfObject = $(this).position().top + $(this).outerHeight();
          const bottomOfWindow = $(window).scrollTop() + $(window).height();
          if (bottomOfWindow > bottomOfObject) {
            $(this).animate({ 'opacity': '1' }, 1000);
          }
        });
      });
    }
  });
})(jQuery);