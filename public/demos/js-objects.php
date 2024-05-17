<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/../private/initialize.php');

    // this is for <title>
    $title = "JavaScripts Objects Obsession";

    // This is for breadcrumbs if I want a custom title other than the default
    $page_title = "This is the object obsession page title";

    // This is the subheading
    $page_subheading = "Welcome to the Object Obsession page subheading";

    //custom CSS for this page only
    $custom_class = "object-obsession-page";

    include_once(SHARED_PATH . '/site_header.php');
?>

<div class="container <?php echo $custom_class; ?>">
    <?php
        include_once(SHARED_PATH . '/navigation.php');
        include_once(SHARED_PATH . '/headline-page.php');
    ?>

    <section class="mt-4">
        <article>
            <!-- being used by javascript-->
            <div id="display-info" class="">
                <h3 class="mb-2">Going to display jToolTip info here.</h3>
                <div class="wrapper">
                    <span class="jToolTip bg-info d-block"></span>
                    <div class="object-items">
                        <h4>Object inner objects:</h4>
                        <ul>

                        </ul>
                    </div>
                </div>
            </div>
        </article>
    </section>

    <section class="input-wrapper">
        <h3>Test your value here</h3>
        <p>Use one of the object keynames from the vidyardVideos object, like video1, video2, video3, etc</p>
        <div class="wrapper">
            <input type="text" id="input" class="form-control" placeholder="Enter a value">
            <button id="submit" class="btn btn-primary">Submit</button>
        </div>
    </section>

    <script>
		// create an immediately invoked function
        (function(){
	        // create an object
	        let vidyardVideos = {
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

	        // query the DOM for the object-items ul
	        var objItemsList = document.querySelector(".object-items ul");

	        // create list element and input a text value
	        function addLiItem(text){
		        let node = document.createElement("li");             // Create a <li> node
		        let textnode = document.createTextNode(text);        // Create a text node
		        node.appendChild(textnode);                          // Append the text to <li>
		        return objItemsList.appendChild(node);
	        }

	        // loop through the vidyardVideos object and console.log the properties
	        for (let key in vidyardVideos) {
		        // Loop through the object keys and console.log the properties
		        let propValue = vidyardVideos[key];
		        console.log(`The key: ${key}, The name: ${propValue['name']}`);

		        // add the key to the list
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

	        // create a function that will take keys from the vidyardVideos object
	        let inputCheck = function(val){
		        // console.log("----------------");
		        // console.log("Parameter Value: " + val);
		        // console.log("----------------");

		        // if the key exists in the vidyardVideos object
		        if (vidyardVideos.hasOwnProperty(val)) {
			        console.log("The key exists in the object: " + val);
			        console.log("The name property: " + vidyardVideos[val].name);
		        } else {
			        console.log("The key does NOT exist in the object: " + val);
		        }
	        }

			// query element with id of input
            let input = document.getElementById("input");
            let submit = document.getElementById("submit");

			//add event listener to input and check for enter key
            input.addEventListener("keyup", function(event){
                // check if the enter key was pressed
                if (event.key === "Enter") {
                    // get the value of the input
                    let inputValue = input.value;
                    // console.log(inputValue);
                    inputCheck(inputValue);
                }
            });

            // add event listener to submit button
            submit.addEventListener("click", function(){
                // get the value of the input
                let inputValue = input.value;
                // console.log(inputValue);
                inputCheck(inputValue);
            });

        })();
    </script>
</div>

<?php include_once(SHARED_PATH . '/site_footer.php');?>