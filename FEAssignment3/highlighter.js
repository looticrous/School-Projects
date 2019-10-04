
(function ( $ ) {
 	$.fn.highlight = function (options) {
		var settings = $.extend ({
			match_emails: true,
			match_hashtags: true,
			match_text: true,
			email_background_color: "yellow", 
			hashtag_background_color: "yellow", 
			text_background_color: "yellow",
			delimiter: " ",
			//commonly used regular expression to validate an email address - see: https://stackoverflow.com/questions/46155/how-to-validate-an-email-address-in-javascript
			pattern: /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i,
			text: ""
		}, options );   
		var text = $(this)[0].innerText; 
		var textarr = text.split(settings.delimiter);
		for (var i = 0; i < textarr.length; i ++) {
			if (settings.match_emails) {
				if (textarr[i].match(settings.pattern)) {
					textarr[i] = '<mark style="background-color:'+settings.email_background_color+' ">' + textarr[i] + '</mark>'; 
				}
			}
			if (settings.match_hashtags) {
				if (textarr[i][0] == "#") {
					textarr[i] = '<mark style="background-color:'+settings.hashtag_background_color+' ">' + textarr[i] + '</mark>';
				}
			}
			if (settings.match_text) {
				if (textarr[i] == settings.text) {
					textarr[i] = '<mark style="background-color:'+settings.text_background_color+' ">' + textarr[i] + '</mark>'; 
				}
			}
		}
		
		$(this)[0].innerHTML = textarr.join(settings.delimiter);
	}; 
	
 
}( jQuery ));

