(function($){
    $(document).ready(function () {

        // $('#nav-menu-icon').click(function(){
        //     $(this).toggleClass('open');
        //     $('.main-navigation').stop(true).slideToggle("fast");
        // });

        $('.carousel-wrapper').slick({
            autoplay: true,
            mobileFirst: true,
            dots: true
            // arrows:false
        });

        // Using Mustache
        if ($("#color-wrapper").length){
            $.getJSON('/data/data.json', function(data) {
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
                url: '/data/list.json',
                dataType: 'json',
                type: 'get',
                cache: false,
                success: function(data){
                    $(data.articles).each(function(index,value){
                        var $articleImage = "<img class=\"image\" src=\"" + value.imgUrl + "\">";
                        var $photoCredit = "<p class=\"photoCredit\">Photo Credit: " + value.photoCredit + "</p>";
                        var $articvaritle = "<h2 class=\"title\">" + value.title + "</h2>";
                        var $articleAuthor = "<p class=\"author\">By: " + value.author + "</p>";
                        var $articleDate = "<p class=\"date\">" + value.date + "</p>";
                        var $articleSummary = "<p class=\"summary\">" + value.summary + "</p>";

                        var totalArticle = "<article id=" + value.id + " class=\"article\"><span>" +
                            $articleImage +
                            $photoCredit +
                            $articvaritle +
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
                        console.log("page not found, player");
                    }
                }
            });
        }

        // The bit of code is being used on http://localhost:3000/demos/js-objects.php
        const jToolTip = $(".jToolTip");
        const pTag = document.createElement("p");
        const innerSpan = document.createElement("span");

        // create a variable that sets the initial scroll top value
        var initScrollTopValue = 0;

        pTag.className = "info p-4";
        pTag.innerHTML = "Window scroll top: ";
        pTag.innerHTML = `Window scroll top: <span>${initScrollTopValue}</span>`;
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

            $( ".component" ).each(function() {
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

                $("#rendered-sections-list").append('<li class="mb-2"><a href="#'+theId+'" class="sidebar-nav">'  + theText + '</a></li>');
            });

            $('.article-list-wrapper').append('<div id="scroll-to-top">Scroll To Top</div>');

        }

        // calculating some values
        var header_height = $('.main-header').outerHeight(),
            dls_menu = $('.main-navigation').outerHeight(),
            scroll_top_icon = $('#scroll-to-top'),
            nav = $('.lorem-sidebar'),
            sections = $('.component'),
            // sipt = parseInt($('.site-inner').css('padding-top'), 10),
            combined_height = header_height + dls_menu;


        // Scroll to top function 1/2
        $(window).scroll(function(){
            var $scrollTop = $(window).scrollTop();

            if ( $scrollTop > header_height ){
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

            // $('.component').each(function(){
            //     var top = $(this).offset().top,
            //         bottom = top + $(this).outerHeight();
            //     if (cur_pos >= top && cur_pos <= bottom) {
            //         nav.find('a').removeClass('active-nav');
            //         sections.removeClass('active-nav');
            //
            //         $(this).addClass('active-nav');
            //         nav.find('a[href="#'+$(this).attr('id')+'"]').addClass('active-nav');
            //     }
            //     if (cur_pos < combined_height) {
            //         nav.find('a').removeClass('active-nav');
            //     }
            // });

        });

        // Scroll to top function 2/2
        scroll_top_icon.click(function(){
            var body = $("html, body");
            body.animate({scrollTop:0}, '500', 'swing');
        });

        // - Smooth scroll sidebar

        $('.sidebar-nav').on('click', function (e) {
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
})(jQuery);

(function($) {
    // 'use strict';

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

(function($) {
    // 'use strict';

    // Comment
    $(document).ready(function() {

        if ( $('.javascript-page').length ) {

            // Vidyard Test

            let vidyardVideos = {
                video1: {
                    uuid: "Rh2oJsa3HDj1hVPfKDCdeg",
                    hash: "#reports-demo",
                    name: "Reports Demo",
                    text: "<p>The best movie ever.<\/p>"
                },
                video2: {
                    uuid: "APxTNIXtBL6SoluRC_N2dQ",
                    hash: "#sheets-demo",
                    name: "Sheets Demo",
                    text: "<p>The second best movie ever.<\/p><p>The second best movie ever.</p>"
                },
                video3: {
                    uuid: "OxCDlNlSTZ2ZuT4xfUHKtQ",
                    hash: "#dashboards-demo",
                    name: "Dashboards Demo",
                    text: "<p>The third best movie ever.<\/p>"
                },
                video4: {
                    uuid: "5jgoBXkZCujmc_q02qj-eQ",
                    hash: "#financial-planning-demo-sales",
                    name: "Financial Planning Demo: Sales",
                    text: "<p>The fourth best movie ever.<\/p>"
                },
                video5: {
                    uuid: "X7Xhgmr_mXla9giD6Vlb5A",
                    hash: "#captital-management-demo",
                    name: "Capital Management Demo",
                    text: "<p>The fifth best movie ever.<\/p>"
                },
                video6: {
                    uuid: "48hjkrhSGAwiJ4c2_uA3oQ",
                    hash: "#profitability-analysis-demo",
                    name: "Profitability Analysis Demo",
                    text: "<p>The sixth best movie ever.<\/p>"
                },
                video7: {
                    uuid: "Q3hlMwq93Y157_RxYjtkcQ",
                    hash: "#financial-close-demo",
                    name: "Financial Close Demo",
                    text: "<p>The seventh best movie ever.<\/p>"
                }
            };

            for(var key in vidyardVideos) {
                if (vidyardVideos.hasOwnProperty(key)) {
                    var video = vidyardVideos[key];
                    console.log("Key: " + key);
                    console.log("Text: " + vidyardVideos[key].text);
                    console.log("Video UUID: " + video.uuid);
                    console.log("Hash: " + video.hash);
                    // console.log(Object.getOwnPropertyNames(vidyardVideos));
                }
            }


            // Get header height and use it to set the margin top for another element
            // var header_height = $('.main-header').outerHeight();
            // console.log(header_height);
            // $(".main-navigation").css("margin-top", header_height);


            // using gist as a temporary bandaid
            // This is used on the JS Fun page
            // https://jabaltorres.com/wp-content/themes/jt-altitude-pro/jt-data.json
            $.getJSON('https://gist.githubusercontent.com/capitalJT/1c7e9304cfb86ffa857c8081b6752366/raw/d2f9a86cc4f550c398c79a4733216cb1938045f9/jt-data.json', function(data) {
                var items = [];
                $.each(data, function(idx, obj){
                    $.each(obj, function(key, value){

                        // check for external link
                        var aTarget = null;
                        if (value.extLink == true){
                            aTarget = 'target="_blank"';
                        } else {
                            aTarget = "";
                        }

                        // var clientName = value.client;
                        var description = value.description;
                        var role = value.role;
                        // var imgSrc = value.imgSrc;
                        // var linkHref = value.linkHref;

                        var output = "<li><div class='text mb-3'><div>" + description +"</div><span class=\"role\">"+ role +"</span></div></li>";

                        items.push( output );

                    });
                });

                $( "<ul/>", { "class": "thumbnail-list", html: items }).appendTo( ".js-append-something" );
            });


            // $('#menu-primary-nav a').on('click',function (e) {
            //     e.preventDefault();
            //     var target = this.hash;
            //     $target = $(target);
            //     $('html, body').stop().animate({
            //         'scrollTop':  $target.offset().top //no need of parseInt here
            //     }, 900, 'swing', function () {
            //         window.location.hash = target;
            //     });
            //     console.log(target);
            // });


            /**
             * Add two numbers together
             * @param num1
             * @param num2
             * @returns {number}
             */
            const add = (num1, num2) => {
                return num1 + num2;
            };

            let result = add(12,23);
            console.log('two numbers added together: ' + result);


            // Array example
            let numbers = [9,5,7,9,11,4,3,2,17];

            // Map example
            // const mapResult = numbers.map(function(item, index, array){
            //     console.log("The index: " + index);
            //     console.log(`This is the array: ${array}`);
            //     return item * 2;
            // });
            // console.log("The map result: " + mapResult);

            // ForEach example
            numbers.forEach(function(element, index){
                let double = element * 2;
                console.log(`The index: ${index}, and the doubled value: ${double}`);

                if (double === 10){
                    console.log("Bingo Jango!");
                }

                if ($('.js-playground').length){
                    $('.entry-content ul').append('<li>' + element + '<\/li>');
                }
            });


            const jtCreateInput = function() {
                var x = document.createElement("INPUT");
                x.setAttribute("id", "jt-text-input");
                x.setAttribute("type", "text");
                // x.setAttribute("value", "Feed me");
                x.setAttribute("placeholder", "Enter your value here");
                x.setAttribute("style", "color:red; border: 1px solid blue; display: block;");

                if ($('.js-playground').length){
                    $('.entry-content').append(x);
                }
            };

            const addElement = function() {
                // create a new div element
                var newDiv = document.createElement("div");
                newDiv.setAttribute('id', 'new-div');
                newDiv.setAttribute('class', 'new-class');

                // and give it some content
                var newContent = document.createTextNode("Hi there, and greetings!");

                // add the text node to the newly created div
                newDiv.appendChild(newContent);

                // add the newly created element and its content into the DOM
                // var currentDiv = document.getElementById("div1");
                if ($('.js-playground').length) {
                    $('.entry-content').append(newDiv);
                }
            };

            addElement();
            jtCreateInput();


            // What to do when enter key is pressed
            $("#jt-text-input").on("keydown",function search(e) {
                if (e.key === "Enter") {
                    var thisVal = $(this).val();
                    console.log( 'This value: ' + thisVal );

                    var newDiv = document.getElementById('new-div');
                    newDiv.innerHTML = thisVal;
                    newDiv.style.cssText = 'padding: 12px; border: solid thin ' + thisVal + ';';
                }

                console.log("What is this: " + $(this).css());
            });

            // function getWidth() {
            // 	var jtInput = document.getElementById('jt-text-input').offsetWidth;
            // 	console.log( "Result of the getWidth function: " + jtInput + "px");
            // }
            //
            // getWidth();

            // document.getElementById('jt-text-input').setAttribute("style", "color:red; border: 1px solid blue;");

            // Closures Example
            const doSomeMath = function(a,b){
                // var a = 12;
                // var b = 32;
                let c = 3;

                function multiply(){
                    var result = a * b / c;
                    return result;
                }

                console.log("Some math was done");
                return multiply;
            };

            var theResult = doSomeMath(12,3);

            console.log( 'This is the result of the doSomeMath function: ' + theResult() );


            /* Every time the window is scrolled ... */
            $(window).scroll( function(){

                /* Check the location of each desired element */
                $('.hide-me').each( function(){

                    var bottom_of_object = $(this).position().top + $(this).outerHeight();
                    var bottom_of_window = $(window).scrollTop() + $(window).height();

                    /* If the object is compvarely visible in the window, fade it in */
                    if( bottom_of_window > bottom_of_object ){
                        $(this).animate({'opacity':'1'},1000);
                    }
                });

            });


            // $(window).scroll(function(){
            // 	var stickyElement = $('#custom_html-2'),
            //        stickytop = stickyElement.offset().top,
            // 		scroll = $(window).scrollTop();
            //
            //    var bottom = $('#categories-2').offset().top + $('#categories-2').outerHeight(true);
            //
            // 	if (scroll >= bottom) {
            //        stickyElement.addClass('fixed-widget');
            // 	} else {
            //        stickyElement.removeClass('fixed-widget');
            // 	}
            // });


        }

    });

})(jQuery);

// Note: functions can only return one value
const checkAge = function(age) {

    // check if age is a type of number
    if (typeof age !== "number") {
        console.log("You did not enter a number");
        return false;
    }

    let ageMessage;
    let ageGroup;
    if (age > 35) {
        ageMessage = "Dang, you are a wise old man!";
        ageGroup = "senior";
    } else {
        ageMessage = "Hey, young man@!";
        ageGroup = "adult";
    }
    console.log(ageMessage);
    return ageGroup;
};

/**
 * @description This function will return the full name
 * @param firstName
 * @param lastName
 * @returns {string}
 */
const myFullName = function(firstName, lastName) {
    let fullName = firstName + " " + lastName;
    // console.log("The full name: " + fullName);
    return fullName;
};

// IIFE
(function(){
    checkAge(12);
    myFullName("Jabals", "Torres");
})();