<?php include 'includes/head.php';?>
<div class="container">
  <?php include 'includes/masthead.php';?>
  <?php include 'includes/navigation.php';?>
  <?php include 'includes/email-db-nav.php';?>
  <section id="form-section">
    <h2>Add Email</h2>
    <?php
      if (isset($_POST['submit'])) {
        $first_name = $_POST['firstname'];
        $last_name = $_POST['lastname'];
        $email = $_POST['email'];
        $output_form = 'no';

        if (empty($first_name) || empty($last_name) || empty($email)) {
          // We know at least one of the input fields is blank 
          echo 'Please fill out all of the email information.<br />';
          $output_form = 'yes';
        }
      }
      else {
        $output_form = 'yes';
      }

      if (!empty($first_name) && !empty($last_name) && !empty($email)) {
        $dbc = mysqli_connect('localhost', 'root', 'root', 'email_db')
          or die('Error connecting to MySQL server.');

        $query = "INSERT INTO email_list (first_name, last_name, email)  VALUES ('$first_name', '$last_name', '$email')";
        mysqli_query($dbc, $query)
          or die ('Data not inserted.');

        echo 'Customer added. </br>';
        echo '<a href="db-test.php">Home</a>';

        mysqli_close($dbc);
      }

      if ($output_form == 'yes') {
    ?>

      <form id="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="firstname">First name:</label>
        <input type="text" id="firstname" name="firstname" /><br />
        <label for="lastname">Last name:</label>
        <input type="text" id="lastname" name="lastname" /><br />
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" /><br />
        <input type="submit" name="submit" value="Submit" id="button" />
      </form>
      <script>
        // var button = document.getElementById('button');

        // function valid8(){
        //   var emailVal = document.getElementById('email').value;
          
        //   if(emailVal != "1"){
        //     alert("bullshit");
        //     event.preventDefault();
        //   }
        // };

        // button.addEventListener("click", function(){
        //   valid8();
        // });
      </script>


      <script>
        // var check_name = /^[A-Za-z0-9 ]{3,20}$/;
        // var check_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i; 

        // function validate(form){
        //   var name =  document.getElementById('firstname').value;
        //   var email = document.getElementById('email').value;
        //   var errors = [];
       
        //   if (!check_name.test(name)) {
        //     errors[errors.length] = "You valid Name .";
        //   }
        //   if (!check_email.test(email)) {
        //     errors[errors.length] = "You must enter a valid email address.";
        //   }
        //   if (errors.length > 0) {
        //     reportErrors(errors);
        //     return false;
        //   }

        //   return true;
        // }

        // function reportErrors(errors){
        //   var msg = "Please Enter Valide Data...\n";

        //   for (var i = 0; i < errors.length; i++) {
        //     var numError = i + 1;
        //     msg += "\n" + numError + ". " + errors[i];
        //   }

        //   alert(msg);
        // }

        function createDiv(){

          var errorMessage = "There was an error";
          // Create new div
          var newDiv = document.createElement("div");
          newDiv.className = "error";

          // Create text node
          var newContent = document.createTextNode(errorMessage);

          // Insert the created text node into the new div 
          newDiv.appendChild(newContent);

          // get the element with id of "form-section"
          var formSection = document.getElementById("form-section");

          // get the element with id of "form"
          var form = document.getElementById("form");

          // This is the same as "prepending"
          formSection.insertBefore(newDiv, form);

        }

        var button = document.getElementById('button');
        button.addEventListener("click", validate);


        function validateEmail(email) { 
          // http://stackoverflow.com/a/46181/11236

          var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return re.test(email);
        }

        function validate(el){
          var target = document.getElementById('email');

          var email = target.value;

          if (validateEmail(email)) {
            alert('god is good');
          } else {
            target.className = "error";
            el.preventDefault();
            target.value = "";
            createDiv();
          }
        }

      </script>

    <?php
      }
    ?>    
  </section>

<?php include 'includes/feet.php';?>