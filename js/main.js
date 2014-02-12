

(function($) {
	
	$(document).ready(function() {

		

	});

	$(window).load(function() {

		

	});

	$.wptheme = (function(wptheme) {

		wptheme.smoothScrollToElement = function(element, speed, offset) {
			speed = typeof speed !== 'undefined' ? speed : 1000;
			offset = typeof offset !== 'undefined' ? offset : 0;
			if(element.length > 0) {
				var margin = parseInt(element.css('margin-top'));
				wptheme.smoothScrollToPos(element.offset().top - (margin > 0 ? margin : 0), speed, offset);
			}
		};
		wptheme.smoothScrollToPos = function(y, speed, offset) {
			speed = typeof speed !== 'undefined' ? speed : 1000;
			offset = typeof offset !== 'undefined' ? offset : 0;
			var fixed_header_offset = 0;
			$('html, body').stop(true).animate({ scrollTop: y - fixed_header_offset + offset }, speed, 'easeInOutExpo');
		};

		return wptheme;
		
	})({});

})(jQuery);