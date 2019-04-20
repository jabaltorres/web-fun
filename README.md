# To install:  
- Clone the repo. I have this project located in my `Sites` directory.
- `cd` into the directory and run `npm install`.
- After all of the dependencies have been installed run `gulp`.
- All of the processes will run and should open a new browser tab to `localhost:3000`.
- You're good to go.

## DB Credentials
db_credentials.php has been ignored. It should live in `private/db_credentials` and look like this:

    <?php
        if ($server_name == $enviro_prod){
            define ("DB_SERVER", "000.000.000.000");
            define ("DB_USER", "YOUR NAME");
            define ("DB_PASS", "YOUR PASS");
            define ("DB_NAME", "YOUR DB NAME");
        } else {
            define ("DB_SERVER", "localhost");
            define ("DB_USER", "root");
            define ("DB_PASS", "root");
            define ("DB_NAME", "lorem_test_db");
        }
    ?>
 