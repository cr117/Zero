
// Avoid 'console' errors in browsers that lack a console.
(function() {
	var method;
	var noop = function() {};
	var methods = [
		'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
		'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
		'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
		'timeStamp', 'trace', 'warn'
	];
	var length = methods.length;
	var console = (window.console = window.console || {});

	while(length--) {
		method = methods[length];
		if(!console[method]) { // only stub undefined methods
			console[method] = noop;
		}
	}
}());



// equalHeight

(function($) {

	var methods = {
		init: function(options) {
			var $group = this;
			var is_init = false;

			var settings = $.extend({
				breakpoint: 768
			}, options);

			$group.each(function() {
				var $this = $(this);
				var data = $this.data('equalHeight');
				if(!data) {
					$this.data('equalHeight', { breakpoint: settings.breakpoint });
					is_init = true;
				}
			});

			if(is_init) {
				$group.equalHeight('equalize');
				$(window).load(function() { $group.equalHeight('equalize'); });
				$(window).resize(function() { $group.equalHeight('equalize'); });
			}

			return $group;
		},
		equalize: function() {
			var $group = this;
			var window_width = document.body.clientWidth ? document.body.clientWidth : window.outerWidth;

			$group.css('height', 'auto');
			if(window_width < $group.first().data('equalHeight').breakpoint) return false;
			var max_height = 0;
			$group.each(function() { max_height = Math.max(max_height, $(this).height()); });
			$group.height(max_height);

			return $group;
		}
	};

	$.fn.equalHeight = function(method) {
		if(methods[method]) {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if(typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' +  method + ' does not exist on jQuery.equalHeight');
		}
	};

})(jQuery);



// Place any jQuery/helper plugins in here.