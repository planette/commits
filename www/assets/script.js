/**!*/
;(function (window, $) {

	$.fn.collapse.Constructor.TRANSITION_DURATION = 0;

	$(function () {

		$.nette.ext('clipboard', {
			load: function () {
				$('[data-clipboard-text]').each(function () {
					new ClipboardJS(this);
				});
			}
		});

		$.nette.ext('pagination', {
			success: function (payload, status, jqXHR, settings) {
				if (settings.nette && settings.nette.el) {
					var href = settings.nette.el.attr('href');

					if (href && href.indexOf('paginate') !== -1) {
						window.scrollTo(0, 0);
					}
				}
			}
		});

		$.nette.init();

	});

})(window, window.jQuery);
