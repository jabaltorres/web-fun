function twoPartForm(){
  // create the form footer element
  var $formFooter = $("<div>", {id: "formfooter"}).prop("class", "formfooter");

  // form footer HTML content
  var $formFooterHTML = '<p class="small text-center privacyNote">' + 
                        'We respect your privacy and will never sell, rent, or share your personal information. ' + 
                        '<a href="http://www.adaptiveinsights.com/privacy" target="_blank">Privacy Policy</a></p>' +
                        '<a class="two-part-form-truste-logo" href="//privacy.truste.com/privacy-seal/Adaptive-Insights/validation?rid=f290c0a6-40d8-4d56-ab23-6f5122931178"><img src="//privacy-policy.truste.com/privacy-seal/seal?rid=f121802f-6eb9-4286-9a24-ab40fbc405cd" alt="TRUSTe Privacy Certification"></a>';

  // append form footer HTML content to the form footer
  // Online demo has a footer. We're checking to see if a similar footer exists, and if so remove it and render the new footer        
  if ($('#formblockfooter').length === 0) {
    $formFooter.append($formFooterHTML); 
  }
              

  // find every sibling until --company-information and wrap with .contactInfo
  // .nextUntil excludes the first selector so then we prepend it
  $( ".webform-client-form > div" ).children().first().nextUntil( ".webform-component--step2-heading" ).wrapAll("<div class='contactInfo'></div>");
  $( ".webform-client-form div" ).children().first().prependTo(".contactInfo");

  // create and append the Continue button to .contactInfo 
  $(".contactInfo").append('<div class="row"><button type="button" class="webform-component btn btn-primary btn-continue">Continue</button></div>');

  // find every sibling after --company-information and wrap with .companyInfo
  // append last selector
  $(".contactInfo").nextUntil( ".form-actions" ).wrapAll("<div class='companyInfo'></div>");
  $( ".form-actions" ).appendTo(".companyInfo");

  // append the form footer to both parts of the two step form 
  $(".contactInfo, .companyInfo").append($formFooter);

  //control for enter key behavior in step 1 vs. step 2
  jQuery(window).keydown(function(event) {
    if (event.keyCode == 13) {
      if (jQuery("#edit-submitted-email-address:visible").length > 0) {
        event.preventDefault();
        jQuery('.btn-continue').click();
      }
    }
  });

  //define the validation function to handle two steps separately
  window.validForm = false;
  window.setValidation = function(panel) {
    if (typeof panel == "undefined") {
      validForm = jQuery(".contactInfo").validate();
    } else {
      validForm = jQuery(".companyInfo").validate();
    }
    //move to step 2 of form
    jQuery('.btn-continue').click(function() {
      if (validForm.form()) {
        $(".contactInfo").fadeOut("fast", function() {
          $(".companyInfo").fadeIn("slow", function() {
            setValidation("true");
          });
        });
      }
    });
  };

  //set validation code and form submit behavior
  jQuery(document).ready(function() {
    setValidation();
    $(".webform-client-form:first").submit(function() {
      if (validForm.form()) {
        //add submit handler for goalCompletions
        $(".form-actions .btn").val("Working on it...").attr("disabled", true);
        if (typeof goalCompletion != 'undefined') {
          try {
            goalCompletion.trackGoal($("input[name*='submitted[conversiontype]']").val());
          } catch (e) {}
        }
      }
    });
  });
}

// GROUP DEMO
// - 15416
// - 28341
// - 35026

// ONLINE DEMO
// - 14726
// - 29331
// - 35061
// - 46916

// PERSONALIZED DEMO
// - 14641
// - 35041
// - 29386
// - 46911

// TRIAL DISCOVER
// - 14651
// - 35046
// - 29376
// - 35081

// TRIAL PLANNING CONSOLIDATION
// - 14656
// - 35051
// - 29371
// - 35076

$(document).ready(function(){
  // retrieve the form ID
  var formID = $('form').attr('id');

  // list of form IDs that we want to make into two parts
  var webformIdArray = [ "webform-client-form-15416", 
                         "webform-client-form-28341",
                         "webform-client-form-35026",

                         "webform-client-form-14726", 
                         "webform-client-form-29331",
                         "webform-client-form-35061",
                         "webform-client-form-46916",

                         "webform-client-form-14641", 
                         "webform-client-form-35041",
                         "webform-client-form-29386",
                         "webform-client-form-46911",

                         "webform-client-form-14651", 
                         "webform-client-form-35046",
                         "webform-client-form-29376",
                         "webform-client-form-35081",

                         "webform-client-form-14656", 
                         "webform-client-form-35051",
                         "webform-client-form-29371",
                         "webform-client-form-35076"];
  
  // loop through the array
  for ( var i = 0; i < webformIdArray.length; i++ ){
    // Check if the current is a match
    if ( webformIdArray[i] == formID ){
      // if is a match run the function
      twoPartForm();
    }
  }
});






