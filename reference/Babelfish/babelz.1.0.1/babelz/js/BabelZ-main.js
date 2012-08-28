jQuery(function() {
	// Minimize/Maximize Boxes Based on Stored Value
	jQuery(".BabelZ-sh").each(function (i) {
		var a = jQuery(this).attr("target");
		if (jQuery("[name='"+ a +"']").val() == "hide") {
		    jQuery("[id='"+ a +"']").hide();
		}
	});
	// Add Cursor to Box Headers
	jQuery(".BabelZ-h").css("cursor","pointer");
	// Header Click
	jQuery(".BabelZ-h").click(function () {
		var a = jQuery(this).attr('target');
		if (jQuery("[id='"+ a +"']").is(":hidden")) {
		    jQuery("[name='"+ a +"']").val("show");
		    jQuery("[id='"+ a +"']").toggle("fast");
		} else {
		    jQuery("[name='"+ a +"']").val("hide");
		    jQuery("[id='"+ a +"']").toggle("fast");
		}
	});
});
