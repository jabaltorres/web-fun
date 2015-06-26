<?php include 'includes/head.php';?>
<div class="container">
  <?php include 'includes/masthead.php';?>
  <section>
    <hgroup>
      <h1>FORMS</h1>
      <h2>Sub headline</h2>
    </hgroup>
    <article>
      
      <p>I think it would be a good idea to make this a journal style web project. Type out my crazy thoughts and treat them as issues that need to be resolved. Gotta remember to take it one step at a time. That's the only way that I'm going to see progress here</p>
      <p>This should be my project that I blog about. I should keep track of updates and changes</p>
      
      <form method="post" action="acknowledge.php">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name">


        <label for="email">Email:</label>
        <input type="email" name="email" id="email">


        <label for="comments">Comments:</label>
        <textarea name="comments" id="comments"></textarea>

        <input type="submit" name="send" value="Send Message" class="button">
      </form>

      <ul>
        <li>Site needs to be mobile friendly</li>
        <li>Needs to load really fast</li>
        <li>It should make this like a style tile.</li>
        <li>Integration with a database.</li>
        <li>This site should combine the best of all of my projects</li>
      </ul>

      <button class="btn-med warning">Primary Button</button>
      <button class="btn-med success">Secondary Button</button>
      <button class="btn-med info">Secondary Button</button>
      <footer>
        <span>This is the footer</span>
      </footer>
    </article>
  </section>

<?php include 'includes/feet.php';?>