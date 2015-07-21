<?php include 'includes/head.php';?>
<div class="container">
  <?php include 'includes/masthead.php';?>
  <?php include 'includes/navigation.php';?>
  <?php include 'includes/email-db-nav.php';?>
  <section id="form-section">
    <h2>Add Email</h2>
    <?php

      require_once('connectvars.php');

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
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
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
        <label for="firstname" id="name-label">First name:</label>
        <input type="text" id="firstname" name="firstname" /><br />
        <label for="lastname">Last name:</label>
        <input type="text" id="lastname" name="lastname" /><br />
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" /><br />
        <input type="submit" name="submit" value="Submit" id="button" class="button" />
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

        var tested = false;

        function displayError(){
          if (tested == false){
            var errorMessage = "There was an error";

            // Create text node
            var newContent = document.createTextNode(errorMessage);

            // Create new div
            var newDiv = document.createElement("div");

            // Give it a class
            newDiv.className = "error";

            // Insert the created text node into the new div  
            newDiv.appendChild(newContent);

            var label = document.getElementById("name-label");          
            var form = document.getElementById("form");
            form.insertBefore(newDiv,label);
          }
          tested =  true;
        }

        // var clicks = 0;
        // function clickCounter(){
        //     clicks +=1;
        //     console.log(clicks);

        //     if (clicks > 5) {
        //       alert('more than 5 clicks');
        //     }
        // }


        var button = document.getElementById('button');
        button.addEventListener("click", validate);


        function validateEmail(email) { 
          // http://stackoverflow.com/a/46181/11236

          var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return re.test(email);
        }

        function validate(event){
          var target = document.getElementById('email');

          var email = target.value;

          if (validateEmail(email)) {
            alert('god is good');
          } else {
            target.className = "error";
            event.preventDefault();
            target.value = "";

            displayError();
            // clickCounter();

          }
        }

      </script>

    <?php
      }
    ?>

    <!-- This is to test a stash comment. Let's images this is the third stash-->
  </section>

<?php include 'includes/feet.php';?>