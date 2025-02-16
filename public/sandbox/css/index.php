<html>
    <head>
        <link rel="stylesheet" href="/assets/css/style.css">
        <link rel="stylesheet" href="/assets/css/public.css">
    </head>
    <body id="page-scratch" class="">
        <div class="container py-5">
            <h1>Hello world!</h1>

            <p>This is where I can test things without messing up anything within the codebase.</p>

            <?php
                function get_headline($headline_text) : string {
                    return "<div>" . $headline_text . "</div>";
                }
            ?>

            <div>
                <?php echo get_headline("This is a test"); ?>
            </div>

            <?php
                // create an associative array of strings
                $carousel_blurbs = array(
                    'Lorem ipsum dolor sit amet, consectetur adipisicing elit',
                    'Lorem ipsum dolor sit amet, consectetur adipisicing',
                    'Lorem ipsum dolor sit amet, consectetur'
                );

                // create a function that will print the $carousel_blurbs array
                function print_carousel_blurbs($array) {
                    foreach ($array as $value) {
                        echo '<div class="blurb"><span>' . $value . '</span></div>';
                    }
                }

                print_carousel_blurbs($carousel_blurbs);
            ?>
        </div>
        
        <script>
            console.log('Test console log message');
        </script>
    </body>
</html>