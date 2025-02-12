<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../src/initialize.php');


    if(is_post_request()) {
      // Form was submitted
      $language = $_POST['language'] ?? 'Any';
      $expire = time() + 60*60*24*365;
      setcookie('language', $language, $expire);

    } else {
      // Read the stored value (if any)
      $language = $_COOKIE['language'] ?? 'None';
    }

include('../../templates/layouts/header.php');

?>

<div id="main">

  <div id="page" class="container py-5">

    <div id="content">
      <h1>Set Language Preference</h1>

      <p>The currently selected language is: <?php echo $language; ?></p>

      <form action="<?php echo url_for('/demos/language.php'); ?>" method="post">

        <select name="language">
          <?php
            $language_choices = ['Any', 'English', 'Spanish', 'French', 'German'];
            foreach($language_choices as $language_choice) {
              echo "<option value=\"{$language_choice}\"";
              if($language == $language_choice) {
                echo " selected";
              }
              echo ">{$language_choice}</option>";
            }
          ?>
        </select><br />
        <br />
        <input type="submit" value="Set Preference" />
      </form>
    </div>

  </div>

</div>

<?php include('../../templates/layouts/footer.php'); ?>
