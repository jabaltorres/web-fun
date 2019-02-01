/* START Typography test */
function displayFontSize(){
    if($(".page-node-51736").length){
        console.log("yolo");
        var aiH1 = $("#typography-test h1").css('font-size');
        var aiH2 = $("#typography-test h2").css('font-size');
        var aiH3 = $("#typography-test h3").css('font-size');
        var aiH4 = $("#typography-test h4").css('font-size');
        var aiH5 = $("#typography-test h5").css('font-size');
        var aiH6 = $("#typography-test h6").css('font-size');
        $("h1 span.fs").text(" - " + aiH1);
        $("h2 span.fs").text(" - " + aiH2);
        $("h3 span.fs").text(" - " + aiH3);
        $("h4 span.fs").text(" - " + aiH4);
        $("h5 span.fs").text(" - " + aiH5);
        $("h6 span.fs").text(" - " + aiH6);
    }
}

jQuery(function() {
    displayFontSize();
});
jQuery(window).resize(function(){
    displayFontSize();
});
/* END Typography test */