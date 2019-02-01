// run on trial pages
function trialFunc(){

  var btnVal = "Get Started";

  var $contactInfo = $(".contactInfo");
  $(".form-actions input:submit").val( btnVal );

  $contactInfo.append('<div class="form-actions row"><button type="button" class="webform-component btn btn-primary btn-continue">Continue</button></div>');

  var $companyInfo = jQuery(".companyInfo").hide();


  jQuery(window).keydown(function(event){
    if(event.keyCode == 13) {
      if(jQuery("#edit-submitted-email-address:visible").length > 0){
        event.preventDefault();
        jQuery('.btn-continue').click();
      }
    }
  });

  var validForm = false;
  function setValidation (){
    validForm = jQuery(".contactInfo").validate();

    jQuery('.btn-continue').click(function(){ 
      if (validForm.form()){
        $contactInfo.fadeOut("fast", function(){ $companyInfo.fadeIn("slow");}); 
      }
    });
  }

  jQuery(document).ready(function(){
    setValidation();
  });


  // change submit button on click
  $(".form-submit").click(function(){
    $(this).val( "Working on it..." );
  });
}

// run on demo pages
function demoFunc(){
  var btnVal = "See the demos";
  var $contactInfo = $(".contactInfo");

  // find every sibling until --company-information and wrap with .contactInfo
  // .nextUntil excludes the first selector so then we prepend it
  $( ".webform-client-form > div" ).children().first().nextUntil( ".webform-component--company-information" ).wrapAll("<div class='contactInfo'></div>");
  $( ".webform-client-form div" ).children().first().prependTo(".contactInfo");

  // append the button 
  $(".contactInfo").append('<div class="row"><button type="button" class="webform-component btn btn-primary btn-continue">Continue</button></div>');

  // find every sibling after --company-information and wrap with .companyInfo
  // append last selector
  $(".contactInfo").nextUntil( ".form-actions" ).wrapAll("<div class='companyInfo'></div>");
  $( ".form-actions" ).appendTo(".companyInfo");
  
  // set the value of the button 
  $(".form-actions input:submit").val(btnVal);

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

// $(document).ready(function(){
//   // get the path name
//   var thePath = window.location.pathname;

//   // the paths we are testing against
//   var pathsTrial = [ "/discovery-trial", "/planning-consolidation-trial" ];
//   var pathsDemo  = [ "/online-demo-registration"];
  
//   // loop through the array. Check if trial page
//   for ( var i = 0; i < pathsTrial.length; i++ ){
//     if ( pathsTrial[i] == thePath ){
//       // trialFunc();
//     }
//   }
//   // loop through the array. Check if demo page
//   for ( var i = 0; i < pathsDemo.length; i++ ){
//     if ( pathsDemo[i] == thePath ){
//       // demoFunc();
//     }
//   }
// });


$(document).ready(function(){
  var formID = $('form').attr('id');
  var webformIdArray = [ "webform-client-form-14651", 
                         "webform-client-form-29376", 
                         "webform-client-form-35046", 
                         "webform-client-form-14656", 
                         "webform-client-form-29371", 
                         "webform-client-form-35051", 
                         "webform-client-form-35076" ];
  
  // loop through the array. Check if trial page
  for ( var i = 0; i < webformIdArray.length; i++ ){
    if ( webformIdArray[i] == formID ){
      demoFunc();
    }
  }
});
