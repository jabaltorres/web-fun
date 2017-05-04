<?php include 'includes/head.php';?>

<div class="container">
  <?php include 'includes/masthead.php';?>
  <?php include 'includes/navigation.php';?>
  <section class="forms">
    <hgroup>
      <h1>Forms</h1>
      <h2>Sub headline</h2>
    </hgroup>
    <p>This is an example of a contact form</p>
    <form method="post" action="acknowledge.php">
      <label for="name">Name:</label>
      <input type="text" name="name" id="name">


      <label for="email">Email:</label>
      <input type="email" name="email" id="email">


      <label for="comments">Comments:</label>
      <textarea name="comments" id="comments"></textarea>

      <input type="submit" name="send" value="Send Message" class="btn">
    </form>
  </section>

<?php include 'includes/feet.php';?>