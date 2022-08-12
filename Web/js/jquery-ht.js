$(document).ready(function() {
    $("#jq_topmenu li").hover(function() {
        $(this).addClass("hover").find("div.jq_hidebox").show();
		$("$topmenu").css("opacity","0.3");
    },
    function() {
        $(this).removeClass("hover").find("div.jq_hidebox").hide();
    });
});


