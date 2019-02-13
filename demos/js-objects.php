<?php
    require_once '../private/initialize.php';

    // this is for <title>
    $title = "JavaScripts Objects Obsession";

    // This is for breadcrumbs if I want a custom title other than the default
    $page_title = "This is the object obsession page title";

    // This is the subheading
    $page_subheading = "Welcome to the Object Obsession page subheading";

    //custom CSS for this page only
    $custom_class = "object-obsession-page";

    include_once(INCLUDES_PATH . '/site-header.php');
?>

<div class="container <?php echo $custom_class; ?>">
    <?php
        include_once(INCLUDES_PATH . '/masthead.php');
        include_once(INCLUDES_PATH . '/navigation.php');
        include_once(INCLUDES_PATH . '/headline-page.php');
    ?>

    <section class="mt-4">
        <article>
            <h3>Host information courtesy of JavaScript</h3>

            <!-- being used by javascript-->
            <div id="host-info" class="mb-4"></div>

            <!-- being used by javascript-->
            <div id="display-info" class="">
                <h3 class="mb-2">Going to display jToolTip info here.</h3>
                <div class="wrapper">
                    <span class="jToolTip"></span>
                    <div class="object-items">
                        <h4>vidyardVideos inner objects:</h4>
                        <ul>

                        </ul>
                    </div>
                </div>
            </div>
        </article>
    </section>

    <script>
        var vidyardVideos = {
            video1: {
                uuid: "Rh2oJsa3HDj1hVPfKDCdeg",
                hash: "#reports-demo",
                name: "Reports Demo",
                text: "<p>The best movie ever.</p>"
            },
            video2: {
                uuid: "APxTNIXtBL6SoluRC_N2dQ",
                hash: "#sheets-demo",
                name: "Sheets Demo",
                text: "<p>The second best movie ever.</p><p>The second best movie ever.</p>"
            },
            video3: {
                uuid: "OxCDlNlSTZ2ZuT4xfUHKtQ",
                hash: "#dashboards-demo",
                name: "Dashboards Demo",
                text: "<p>The third best movie ever.</p>"
            },
            video4: {
                uuid: "5jgoBXkZCujmc_q02qj-eQ",
                hash: "#financial-planning-demo-sales",
                name: "Financial Planning Demo: Sales",
                text: "<p>The fourth best movie ever.</p>"
            },
            video5: {
                uuid: "X7Xhgmr_mXla9giD6Vlb5A",
                hash: "#captital-management-demo",
                name: "Capital Management Demo",
                text: "<p>The fifth best movie ever.</p>"
            },
            video6: {
                uuid: "48hjkrhSGAwiJ4c2_uA3oQ",
                hash: "#profitability-analysis-demo",
                name: "Profitability Analysis Demo",
                text: "<p>The sixth best movie ever.</p>"
            },
            video7: {
                uuid: "Q3hlMwq93Y157_RxYjtkcQ",
                hash: "#financial-close-demo",
                name: "Financial Close Demo",
                text: "<p>The seventh best movie ever.</p>"
            }
        };

        var objItems = document.querySelector(".object-items ul");

        // create list element and input a text value
        function addLiItem(text){
            var node = document.createElement("LI");             // Create a <li> node
            var textnode = document.createTextNode(text);        // Create a text node
            node.appendChild(textnode);                          // Append the text to <li>
            return objItems.appendChild(node);
        }

        for (var key in vidyardVideos) {
            // Loop through the object keys and console.log the properties
            var propValue = vidyardVideos[key];
            // console.log(key, propValue);
            console.log(key, propValue['name']);

            // use the above declared function
            addLiItem(key);

            for (key2 in propValue) {
                // console.log("The key: " + key, "The key2: " + key2, "the propValue[key2]: " + propValue[key2]);
                // console.log(key, key2, propValue[key2]);

                if (propValue[key2] === "48hjkrhSGAwiJ4c2_uA3oQ") {
                    console.log("----------------");
                    console.log("The key: " + key);
                    console.log("The key name: " + key2, "The key value: " + propValue[key2]);
                    console.log("----------------");
                }
            }
        }

    </script>
</div>

<?php include_once(INCLUDES_PATH . '/site-footer.php');?>