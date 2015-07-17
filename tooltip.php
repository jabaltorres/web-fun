<?php include 'includes/head.php';?>
  <div class="container">
  <?php include 'includes/masthead.php';?>
  <?php include 'includes/navigation.php';?>

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
  </section>

  <div class="example-container">
    <a href="http://google.com" id="link" title="Link to google" class="tease">Google Link</a>
    <img src="http://placehold.it/640x360&text=16:9" alt="Image Title">
    <img src="http://placehold.it/640x360&text=16:9" alt="Image Title">
    <img src="http://placehold.it/640x360&text=16:9" alt="Image Title">
    <img src="http://placehold.it/640x360&text=16:9" alt="Image Title">
    <img src="http://placehold.it/640x360&text=16:9" alt="Image Title">
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

// var link = document.getElementById('link');
// console.log(link.title);
// console.log(link.className);

    var AddBorder = {
      init: function(){
        // give every image a class name
        var links = document.getElementsByTagName('img');
        var i = 0;
        var doSomething = function () {
          if (i < links.length) {
            links[i].className = "border";
            ++i;
            setTimeout(doSomething, 250);
          }
        };
        // This says wait half a second before doing something
        setTimeout(doSomething, 500);
      }, 
    };
    AddBorder.init();
  </script>

<?php include 'includes/feet.php';?>