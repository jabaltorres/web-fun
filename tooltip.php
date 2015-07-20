<?php include 'includes/head.php';?>
  <div class="container">
  <?php include 'includes/masthead.php';?>
  <?php include 'includes/navigation.php';?>

  <?php // include 'includes/aivl-pop-up.php'; ?>


  <section class="js-fun">
    <hgroup>
      <h1>Tooltip</h1>
      <h2>What's up mother fucker!</h2>
    </hgroup>

    <div>
      <h2>James T. Kirk</h2>
      <p><a class="federation" title="Read more about James T. Kirk at Wikipedia, the free encyclopedia." href="http://en.wikipedia.org/wiki/James_T._Kirk">James Tiberius Kirk</a>
        (2233 - 2293/2371), played by William Shatner, is the leading character in the
        original Star Trek TV series and the films based on it. Captain Kirk commanded
        the starship <span class="ship">Enterprise</span>
        (<a class="federation" title="Read more about the USS Enterprise (NCC-1701) at Wikipedia, the free encyclopedia." href="http://en.wikipedia.org/wiki/USS_Enterprise_%28NCC-1701%29">NCC-1701</a>
        and later
        <a class="federation" title="Read more about the USS Enterprise (NCC-1701-A) at Wikipedia, the free encyclopedia." href="http://en.wikipedia.org/wiki/USS_Enterprise_%28NCC-1701-A%29">NCC-1701-A</a>).</p>
      <p>Kirk's adventures and tactics are legendary in the Alpha and Beta Quadrants
        and continue to be cited well into the 24th century. He had a relaxed and
        confident style of command, but didn't suffer fools gladly. As Captain Benjamin
        Sisko said later about the iconic commander, he had "quite the reputation as a
        ladies' man". Kirk's record with Starfleet's Department of Temporal
        Investigations was unrivaled, with seventeen infractions. He ordered the
        <span class="ship">Enterprise</span> into multiple blatant violations of the
        Prime Directive.</p>
    </div> 
    <button id="action-button">Button  </button>
  </section>

  <div id="wrapper" class="example-container">
    <img class="slide" src="images/janky-carousel-img/placholder-1.png" alt="Image 1">
    <img class="slide" src="images/janky-carousel-img/placholder-2.png" alt="Image 2">
    <img class="slide" src="images/janky-carousel-img/placholder-3.png" alt="Image 3">
    <img class="slide" src="images/janky-carousel-img/placholder-4.png" alt="Image 4">
    <img class="slide" src="images/janky-carousel-img/placholder-5.png" alt="Image 5">
  </div>

  <script>
    var Tooltips = {
      init: function(){

        // wrap links in spans
        // setup even listeners
        // run showTip in response to mouseover events
        // run hideTip in response to mouseout events
        // run showTip in response to focus evens
        // run hideTip in response to blur evens
      },
      showTip: function(){
        // insert rich tooltip after the link
      },
      hideTip: function(){
        // remove rich tooltips after the link
      }
    };
    Tooltips.init();

    var AddBorder = {
      init: function(){

        // for (i = 0; i < links.length; i++){
        //   links[i].className = "border";
        // }

        var links = document.getElementsByTagName('img');
        var wrapper = document.getElementById('wrapper')
        var wrapperHeight = wrapper.offsetHeight;
        var imageHeight = links[0].offsetHeight;

        wrapper.style.height = "" + imageHeight + "px";

        AddBorder.makeActive();

        var actionBtn = document.getElementById('action-button');
        actionBtn.addEventListener("click", AddBorder.moveImage);

        AddBorder.autom8();
      },
      makeActive: function(){
        var firstImage = wrapper.firstElementChild;
        firstImage.classList.add("active");
      },
      moveImage: function(){

        var firstImage = wrapper.firstElementChild;
        var nextImage = firstImage.nextElementSibling.classList.add("active");

        firstImage.parentNode.appendChild(firstImage);
        setTimeout(firstImage.classList.remove("active"),1000);
      },
      autom8: function(){
        var links = document.getElementsByTagName('img');
        var i = 0;
        var callback = function () {
          if (i < links.length) {
            AddBorder.moveImage();
            ++i;
            setTimeout(callback, 1000);
          }
        };
        setTimeout(callback, 1000);

        // var callback = function () {
        //   var links = document.getElementsByTagName('img');
        //   for (var i = 0; i < links.length; i++){
        //     console.log([i])
        //     setTimeout(AddBorder.moveImage, 1000);
        //   }
        // };
        // setTimeout(callback, 1000);
      }
    };
    AddBorder.init();
  </script>

<?php include 'includes/feet.php';?>